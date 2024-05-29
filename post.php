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
    $ymd_his = date("Y/m/d H:i");
    echo $ymd_his;
    ?>

</div>
    <form class="mx-2" action="write.php" method="post">
        <div>
            <div>走行距離 : <input type="number" name="distance"></div>
            <div>金額 : <input type="number" name="price"></div>
            <div>L : <input type="number" name="amount" step="any"></div>
            <div>円/L : <input type="number" name="PpA"></div>
            <div>店舗: 
                <select name="store" calss="" id="">
                    <option name="" hidden>店舗選択</option>
                    <option name="">A</option>
                    <option name="">B</option>
                    <option name="">C</option>
                    <option name="">D</option>
                    <option name="">E</option>

                </select>
                <div class="w-4/5 border-2 border-gray-400">
                    <div>A : EneJet新大宮SS, B : EneJetセルフ与野SS</div>
                    <div>C : EneJetセルフ栗橋SS, D : Shell全般, E : その他</div>
                </div>
                
            </div>

	    <input class="bg-gray-300 rounded-lg" type="submit" value="送信">
        </div>
	    
    </form>

<?php include("inc/footer.html") ?>
</body>
</html>