<?php
include('../../th-config.php');
loginRedirect();
$keys = array(
    "id"
);
emptyCheck($keys);
$article = getArticle($_GET["id"]);
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>記事編集 | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/includes/css/main.css?<?=time()?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include('../../includes/template/nav.php');?>
        <div class="w-75 ms-auto me-auto">
            <h1>編集</h1>
            <form method="post" id="edit-article">
                <div class="mb-3">
                    <label for="title" class="form-label">記事タイトル</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="タイトルを入力" value="<?=$article["title"] ?>">
                </div>
                <hr>
                <div class="mb-3">
                    <label for="cat" class="form-label">カテゴリー</label>
                    <input class="form-control" list="datalistOptions" id="cat" placeholder="カテゴリーの名前を入力" name="cat" value="<?=$article["category"]?>">
                    <p>カテゴリーが存在しない場合→<a href="../../category/new">カテゴリーの追加</a></p>
                    <datalist id="datalistOptions">
                    </datalist>
                </div>
                <input type="hidden" name="id" value="<?=$_GET["id"]?>">
                <hr>
                <div class="mb-3">
                    <input type="checkbox" name="autoPost" id="autoPost" class="form-check-input">
                    <label class="form-check-label" for="autoPost">自動投稿(Misskey)</label><br>
                </div>
                <hr>
                <div class="mb-3 form-floating">
                    <textarea name="body" id="article-body" class="form-control" placeholder="leave a comment." style="height: 30vh;"><?=$article["html"]?></textarea>
                    <label for="article-body">本文</label>
                    <p>画像をアップロードしたい場合は<a href="imageUpload.php" target="_blank" rel="noopener noreferrer">こちら</a></p>
                </div>
                <button type="submit" class="btn btn-primary">投稿する</button>
            </form>
        </div>
        <div id="loading">
            <div class="spinner-border text-primary" role="status" id="spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="/includes/script/edit.js?<?=time()?>"></script>
    </body>
</html>