<?php
// エラーを出力する
ini_set( 'display_errors', 1 );
$distance = $_POST["distance"];
$price = $_POST["price"];
$amount = $_POST["amount"];
$PpA = $_POST["PpA"];
$DpP = 0;
$DpP = number_format($distance / $price, 3);
$DpA = 0;
$DpA = number_format($distance / $amount, 2);
$store = $_POST["store"];
$br = ",";
// echo $DpP;
// echo "<br>";
// echo $DpA;
//文字作成
    // デバッグ用に$_POSTデータを表示
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
// echo $distance;
$str = date("Y/m/d H:i").$br.$distance.$br.$price.$br.$amount.$br.$PpA.$br.$DpP.$br.$DpA.$br.$store;
// echo $str;
//File書き込み
$file = fopen("data/data.txt","a");	// ファイル読み込み
fwrite($file, $str."\n");
fclose($file);
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<?php include("inc/header.html") ?>
<div class="mx-2">
    <?php
    echo "走行距離：".$distance." km";
    echo "<br>";
    echo "価格：".$price." 円";
    echo "<br>";
    echo "購入量：".$amount." L";
    echo "<br>";
    echo "単価：".$PpA." 円/L";
    echo "<br>";
    echo "距離単価：".$DpP." km/円";
    echo "<br>";
    echo "燃費：".$DpA." km/L";
    echo "<br>";
    echo "店舗：".$store." 店";
    echo "<br>";
    echo "上記を登録しました。"
    ?>
    <div>A : EneJet新大宮SS, B : EneJetセルフ与野SS</div>
    <div>C : EneJetセルフ栗橋SS, D : Shell全般, E : その他</div>

</div>


<?php include("inc/footer.html") ?>
</body>
</html>