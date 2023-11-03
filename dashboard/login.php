<?php
include('../th-config.php');
if(loginCheck()){
    http_response_code(302);
    header('Location: ./');
    exit();
}
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>ログイン | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <?php include('../includes/template/nav.php');?>
        <div class="container mt-5 m-auto p-3 rounded shadow text-center">
            <div><img src="<?=$CMS_CONFIG["SITE_LOGO"]?>" style="width: auto; height: 80px;"></div>
            <form action="/api/users/login/" method="post" class="m-auto mt-3 w-50 text-start">
                <label for="handle" class="form-label">ユーザーID(ハンドル)</label>
                <input type="text" name="handle" id="handle" class="form-control mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" class="form-control mb-3">
                <div class="text-center">
                    <button class="btn btn-primary">ログイン</button>
                </div>
                <a href="forget.php" class="text-secondary">パスワードを忘れた</a> | 
                <a href="/" class="text-secondary">サービスに戻る</a>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>