<?php
include_once('../../th-config.php');
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
        <?php include('../../includes/template/nav.php');?>
        <div class="container mt-3 mb-3 m-auto rounded p-3 shadow">
            <h1>プラグインリスト</h1>
            <table class="table">
                <thead>
                    <tr><th scope="col" style="word-break: keep-all;">プラグイン名</th><th scope="col">詳細</th><th scope="col">作者</th><th scope="col" style="word-break: keep-all;">設定</th><th scope="col" style="word-break: keep-all;">有効・無効</th></tr>
                </thead>
                <tbody>
                    <?=master::outputPluginsList();?>
                </tbody>
            </table>
        </div>
    </body>
</html>