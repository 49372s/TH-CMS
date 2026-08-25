<?php
include('../../th-config.php');
loginRedirect();
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>新規記事投稿 | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/includes/css/main.css?<?=time()?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include('../../includes/template/nav.php');?>
        <div class="w-75 ms-auto me-auto">
            <h1>新規投稿</h1>
            <form method="post" id="new-article">
                <div class="mb-3">
                    <label for="title" class="form-label">記事タイトル</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="タイトルを入力">
                </div>
                <hr>
                <div class="mb-3">
                    <label for="cat" class="form-label">カテゴリー</label>
                    <input class="form-control" list="datalistOptions" id="cat" placeholder="カテゴリーの名前を入力" name="cat">
                    <p>カテゴリーが存在しない場合→<a href="/dashboard/new/categories.php">カテゴリーの追加</a></p>
                    <datalist id="datalistOptions">
                    </datalist>
                </div>
                <hr>
                <div class="mb-3">
                    <input type="checkbox" name="autoPost" id="autoPost" class="form-check-input">
                    <label class="form-check-label" for="autoPost">自動投稿(Misskey)</label><br>
                </div>
                <hr>
                <div class="mb-3">
                    <label for="article-body" class="form-label">本文</label>
                    <textarea name="body" id="article-body" class="form-control" placeholder="記事の本文を入力してください" style="height: 30vh;"></textarea>
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
        <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#article-body',
                language: 'ja',
                height: 500,
                menubar: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | link image media table | code fullscreen | help',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px }',
                promotion: false,
                branding: false
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="/includes/script/edit.js?<?=time()?>"></script>
    </body>
</html>