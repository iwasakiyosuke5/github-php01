<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include("inc/header.html") ?>

<?php
ini_set( 'display_errors', 1 );
$data = 'data/data.txt';

// 一行ずつ取得もしくは全文取得用
$fData = fopen($data, 'r');

// 一行ずつ取得
// $tData = fgets($fData);
// echo $tData.'<br>';

//全行取得 
while (!feof($fData)){
    $tData = fgets($fData);
    echo $tData.'<br>';    
}

// 下記はclose専用
fclose($fData);

// file_get_contents
// $content = file_get_contents($data);
// echo $content;

// readfileで開く
// readfile($data);

// htmlの外で利用する時1
// $lines = file($data);

?>
 <!-- htmlの外で利用する時2 -->
<!-- <ul>
    <?php //foreach ($lines as $line) :?>
        
            <li><?php //echo $line; ?></li>

    <?php //endforeach?>
</ul> -->
<?php include("inc/footer.html") ?>
</body>
</html>