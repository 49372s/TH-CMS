<?php
include('../../th-config.php');
loginRedirect();
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>投稿一覧 | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/includes/css/main.css?<?=time()?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include('../../includes/template/nav.php');?>
        <div class="w-75 ms-auto me-auto">
            <h1>投稿一覧</h1>
            <form method="post" id="search-article-edit">
                <div class="mb-3">
                    <label for="article-search-title" class="form-label">記事タイトル</label>
                    <input type="text" name="ast" id="article-search-title" class="form-control">
                </div>
                <button type="submit" class="btn btn-outline-primary w-100">検索</button>
            </form>
            <hr>
            <form id="control-article" method="post" style="overflow-x: scroll;">
                <table class="table" style="white-space: nowrap;">
                    <thead>
                        <tr>
                            <th scope="col">投稿日時</th>
                            <th scope="col">タイトル</th>
                            <th scope="col">投稿者名</th>
                            <th scope="col">カテゴリ</th>
                            <th scope="col">ID</th>
                            <th scope="col">操作</th>
                        </tr>
                    </thead>
                    <tbody id="article-list">
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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