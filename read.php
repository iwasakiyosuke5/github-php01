<!DOCTYPE html>

<?php
ini_set( 'display_errors', 1 );
// $data = 'data/data.txt';

// 一行ずつ取得もしくは全文取得用
$fData = fopen('data/data.txt', 'r');
$data = [];
$tDistance = 0;
$tPrice = 0;
$tAmount = 0;
$tPpA = 0;
$tDpP = 0;
$tDpA = 0;
$maxDpA = 0;
$minDpA = PHP_FLOAT_MAX; // 初期値を最大の浮動小数点数に設定
$rowCount = 0;
$dates = [];
$fuelEs = [];


while ($line = fgets($fData)){
    // $data = explode(",", trim($line));
    $row = explode(",", trim($line));
    $data[] = $row;
    $tDistance += (float)$row[1];
    $tPrice += (float)$row[2];
    $tAmount += (float)$row[3];
    $tPpA += (float)$row[4];
    $tDpP += (float)$row[5];
    $currentDpA = (float)$row[6];
    $tDpA += $currentDpA;
    if ($currentDpA > $maxDpA){
        $maxDpA = $currentDpA;
    }
    if ($currentDpA < $minDpA){
        $minDpA = $currentDpA;
    }
    
    // 日付をISO 8601形式に変換 非常に重要
    $date = DateTime::createFromFormat('Y/m/d H:i', $row[0])->format('Y-m-d\TH:i:s');
    $dates[] = $date;
    $fuelEs[] = (float)$row[6];
    $rowCount++;
    
}
fclose($fData);

$latestData = array_slice($data, -10);
$dates10 = [];
$prices10 = [];

foreach ($latestData as $row) {
    $dates10[] = DateTime::createFromFormat('Y/m/d H:i', $row[0])->format('Y-m-d\TH:i:s');
    
    $prices10[] = (float)$row[4];
}

$pastData = array_slice($data, 0, 10);
$pastDates10 = [];
$pastAmount10 = [];

foreach ($pastData as $row) {
    $pastDates10[] = DateTime::createFromFormat('Y/m/d H:i', $row[0])->format('Y-m-d\TH:i:s');
    
    $pastAmount10[] = (float)$row[3];
}

// echo $dates10;
// echo $prices10;
// echo "<pre>";
// print_r($dates10);
// print_r($prices10);
// echo "</pre>";

$aPrice = number_format($tPrice / $rowCount);
$aAmount = number_format($tAmount / $rowCount, 2);
$aPpA = number_format($tPpA / $rowCount);
$aDpP = number_format($tDpP / $rowCount, 3);
$aDpA = number_format($tDpA / $rowCount, 2);
?>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js"
        integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@next/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

</head>
<body>

<?php include("inc/header.html") ?>


<div class="w-4/5 mx-2 border-4 border-indigo-700 rounded-xl" >
<table class="w-full border-2 border-indigo-700">
    <thead>
        <tr class="text-lg">
            <th class="border-x-2 border-indigo-300">日時</th>
            <th class="border-x-2 border-indigo-300">走行距離</th>
            <th class="border-x-2 border-indigo-300">金額</th>
            <th class="border-x-2 border-indigo-300">購入量</th>
            <th class="border-x-2 border-indigo-300">単価</th>
            <th class="border-x-2 border-indigo-300">km/円</th>
            <th class="border-x-2 border-indigo-300">燃費</th>
            <th class="border-x-2 border-indigo-300">店舗</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr class="text-xl text-center border-2 border-indigo-700">
            <td class="border-x-2 border-indigo-300 px-2"><?php echo htmlspecialchars($row[0], ENT_QUOTES); ?></td>
            <td class="border-x-2 border-indigo-300 px-2"><?php echo htmlspecialchars($row[1]."km", ENT_QUOTES); ?></td>
            <td class="border-x-2 border-indigo-300 px-2"><?php echo htmlspecialchars($row[2]."円", ENT_QUOTES); ?></td>
            <td class="border-x-2 border-indigo-300 px-2"><?php echo htmlspecialchars($row[3]."L", ENT_QUOTES); ?></td>
            <td class="border-x-2 border-indigo-300 px-2"><?php echo htmlspecialchars($row[4]."円", ENT_QUOTES); ?></td>
            <td class="border-x-2 border-indigo-300 px-2"><?php echo htmlspecialchars($row[5], ENT_QUOTES); ?></td>
            <td class="border-x-2 border-indigo-300 px-2"><?php echo htmlspecialchars($row[6]."km/L", ENT_QUOTES); ?></td>
            <td class="border-x-2 border-indigo-300 px-2"><?php echo htmlspecialchars($row[7], ENT_QUOTES); ?></td>        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
<div class="mx-2">
<?php 
echo htmlspecialchars("総距離：".$tDistance."km", ENT_QUOTES); 
echo "<br>";
echo htmlspecialchars("総浪費：".$tPrice."円"."/平均支払金額".$aPrice."円", ENT_QUOTES); 
echo "<br>";
echo htmlspecialchars("総燃料：".$tAmount."L"."/平均購入燃量".$aAmount."L", ENT_QUOTES);
echo "<br>";
echo htmlspecialchars("平均単価：".$aPpA."円", ENT_QUOTES);
echo "<br>";
echo htmlspecialchars("１円当たりの走行距離：".$aDpP."km/円", ENT_QUOTES);
echo "<br>";
echo htmlspecialchars("平均燃費：".$aDpA."km/L", ENT_QUOTES); ?>
</div>
<div class="mx-2 text-red-500"><?php echo htmlspecialchars("最高燃費：".$maxDpA."km/円", ENT_QUOTES); ?></div>
<div class="mx-2 text-blue-500"><?php echo htmlspecialchars("最低燃費：".$minDpA."km/円", ENT_QUOTES); ?></div>

<div class="mx-2 w-4/5">
    <canvas id="mychart" width="600" height="200"></canvas>
    <canvas id="mychart2" width="600" height="200"></canvas>
    <canvas id="mychart3" width="600" height="200"></canvas>

</div>

<script>
// グラフ１個目
let dates = <?php echo json_encode($dates); ?>;
let fuelEs = <?php echo json_encode($fuelEs); ?>;
console.log(dates);
console.log(fuelEs);
let ctx = document.getElementById('mychart');
let myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: dates,
        datasets: [{
            label: '燃費 (km/L)',
            data: fuelEs,
            borderColor: 'red',
            fill: false
        }],
    },
    options: {
        backgroundColor: 'blue', 
        scales: {
            x: {
                type: 'time',
                
                time: {
                    unit: 'month',
                    tooltipFormat: 'YYYY/MM/DD'
            
                },
                title: {
                    display: true,
                    text: '日付'
                // },
                // ticks: {
                //     autoSkip: false,
                //     maxRotation: 0,
                //     major: {
                //         enabled: true
                //     },
                },
            },
            y: {
                min: 6,
                max: 17,
                title: {
                    display: true,
                    text: '燃費 (km/L)'
                }
            }
        }
    }
});


// グラフ２個目
let dates10 = <?php echo json_encode($dates10); ?>;
let prices10 = <?php echo json_encode($prices10); ?>;
console.log(prices10);
let ctx2 = document.getElementById('mychart2');
let myChart2 = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: dates10,
        datasets: [{
            label: '直近10件の単価 (円)',
            data: prices10,
            borderColor: 'blue',
            fill: false
        }],
    },
    options: {
        backgroundColor: 'red', 
        scales: {
            x: {
                type: 'time',
                
                time: {
                    unit: 'month',
                    tooltipFormat: 'YYYY/MM/DD'
            
                },
                title: {
                    display: true,
                    text: '日付'
                // },
                // ticks: {
                //     autoSkip: false,
                //     maxRotation: 0,
                //     major: {
                //         enabled: true
                //     },
                },
            },
            y: {
                min: 140,
                max: 190,
                title: {
                    display: true,
                    text: '単価 (円)'
                }
            }
        }
    }
});

// グラフ3個目
let pastDates10 = <?php echo json_encode($pastDates10); ?>;
let pastAmount10 = <?php echo json_encode($pastAmount10); ?>;
console.log(pastAmount10);
let ctx3 = document.getElementById('mychart3');
let myChart3 = new Chart(ctx3, {
    type: 'line',
    data: {
        labels: pastDates10,
        datasets: [{
            label: '最過去10件の購入量 (L)',
            data: pastAmount10,
            borderColor: 'violet',
            fill: false
        }],
    },
    options: {
        backgroundColor: 'red', 
        scales: {
            x: {
                type: 'time',
                
                time: {
                    unit: 'month',
                    tooltipFormat: 'YYYY/MM/DD'
            
                },
                title: {
                    display: true,
                    text: '日付'
                // },
                // ticks: {
                //     autoSkip: false,
                //     maxRotation: 0,
                //     major: {
                //         enabled: true
                //     },
                },
            },
            y: {
                min:0,
                max: 60,
                title: {
                    display: true,
                    text: '購入量 (L)'
                }
            }
        }
    }
});



</script>

<?php include("inc/footer.html") ?>

</body>

</html>