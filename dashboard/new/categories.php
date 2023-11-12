<?php
include($_SERVER["DOCUMENT_ROOT"].'/th-config.php');
loginRedirect();
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>カテゴリー追加 | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/includes/css/main.css?<?=time()?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include($_SERVER["DOCUMENT_ROOT"].'/includes/template/nav.php');?>
        <div class="w-75 ms-auto me-auto">
            <h1>カテゴリーの追加</h1>
            <form method="post" id="add-category">
                <div class="mb-3">
                    <label for="category" class="form-label">カテゴリー名</label>
                    <input type="text" name="category" id="category" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">追加</button> | <a href="/dashboard/list/categories.php">カテゴリー一覧へ</a>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="/includes/script/edit.js?<?=time()?>"></script>
    </body>
</html>