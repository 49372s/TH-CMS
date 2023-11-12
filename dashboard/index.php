<?php
include_once('../th-config.php');
loginRedirect();
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>ダッシュボード | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include('../includes/template/nav.php');?>
        <div class="container mt-3 mb-3 m-auto rounded p-3 shadow">
            <h2>アクティビティ</h2>
            <ul id="activity">
                プラグインがありません。
            </ul>
        </div>
        <div class="container mt-3 mb-3 m-auto rounded p-3 shadow">
            <h2>最近の投稿</h2>
            <ul id="latestArticles" class="list-group">
            </ul>
        </div>
        <div class="container mt-3 mb-3 m-auto rounded p-3 shadow">
            <h2>編集メニュー</h2>
            <a class="btn btn-primary m-1" href="./new/">新規作成</a>
            <a class="btn btn-primary m-1" href="./list/article.php">記事一覧</a>
            <a class="btn btn-primary m-1" href="./new/imageUpload.php">ファイル</a>
            <a class="btn btn-primary m-1" href="./new/categories.php">タグ追加</a>
            <a class="btn btn-primary m-1" href="./list/categories.php">タグ一覧</a>
        </div>
        <div class="container mt-3 mb-3 m-auto rounded p-3 shadow">
            <h2>管理</h2>
            <a href="./control/" class="btn btn-primary m-1">コントロールパネル</a>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script>
            let articles = '<?=latestArticles() ?>'
            document.getElementById('latestArticles').innerHTML = articles
        </script>
    </body>
</html>