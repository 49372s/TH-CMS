<?php
//設定とプラグインをロードする
include('../th-config.php');

//キーチェック
$keys = array("id");
emptyCheck($keys);

//情報を取得する
$pdo = cdb();
$sql = "SELECT * from article";
foreach($pdo->query($sql) as $row){
    if($row[0] == $_GET["id"]){
        $author = verifyUser($row[2]);
        $title = $row[1];
        $category = $row[3];
        $lastUpdate = $row[4];
    }
}
if(empty($author) || empty($title) || empty($category) || empty($lastUpdate)){
    http_response_code(404);
    exit();
}
?>
<html lang="ja-jp">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title><?=$title?> | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <!-- ここから指示あるまでは削除しても構わない -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <!-- ここまで -->
    </head>
    <body>
        <?php include('../includes/template/nav.php');?>
        <section class="m-3">
            <div>
                <h1><?=$title?></h1>
                <div class="text-secondary">最終更新: <?=$lastUpdate?></div>
            </div>
            <hr>
            <?=readArticles($_GET['id']);?>
            <hr>
            <div class="text-center">
            <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a> | <a href="https://misskeyshare.link/share.html?text=" onclick="window.open(this.href+encodeURI(decodeURI(document.title))+'&url='+encodeURI(decodeURI(location.href)), '', 'width=500,height=400'); return false;"><img src="https://misskeyshare.link/image/notebutton.webp" width="80" height="20"></a>
            </div>
        </section>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        <script>
            function copyToCB(str){
                navigator.clipboard.writeText(str).then(()=>{
                    window.alert("コピーしました。");
                })
            }
        </script>
    </body>
</html>