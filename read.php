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
    $tDpA += (float)$row[6];
    // 日付をISO 8601形式に変換 非常に重要
    $date = DateTime::createFromFormat('Y/m/d H:i', $row[0])->format('Y-m-d\TH:i:s');
    $dates[] = $date;
    $fuelEs[] = (float)$row[6];
    $rowCount++;
    
}
fclose($fData);

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
echo htmlspecialchars("平均燃費：".$aDpA."km/円", ENT_QUOTES); ?>
</div>

<div class="mx-2 w-4/5">
    <canvas id="mychart" width="600" height="200"></canvas>

</div>

<script>
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





</script>

<?php include("inc/footer.html") ?>

</body>

</html>