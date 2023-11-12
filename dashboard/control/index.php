<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/th-config.php');
loginRedirect();
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>サイト管理 | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include($_SERVER["DOCUMENT_ROOT"].'/includes/template/nav.php');?>
        <section class="p-4">
            <h2>ようこそ、<?=verifyUser(getUserID($_COOKIE['token']))?>さん</h2>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            アカウント設定
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form action="/api/users/update/" method="post">
                                <h2>ニックネーム</h2>
                                <input type="text" name="nickname" placeholder="ニックネーム" value="<?=verifyUser(getUserID($_COOKIE['token']))?>" class="form-control">
                                <h2>パスワード</h2>
                                <input type="password" name="password" class="form-control" placeholder="新しいパスワード" autocomplete="new-password">
                                <h2>Misskey連携</h2>
                                <?php
                                if(checkAuthenticateMisskey(getUserID($_COOKIE["token"]))==true){
                                    ?>
                                    <p>連携済みです</p>
                                    <?php
                                }else{
                                    ?>
                                    <input type="url" name="instance" id="instance" class="form-control" placeholder="インスタンスURL(例: misskey.io)">
                                    <a class="btn btn-success" onclick="authMi()">連携</a>
                                    <?php
                                }
                                ?>
                                <input type="submit" value="設定" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">サイト設定</button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form action="/api/admin/config/update/" method="post">
                                <h2>サイト名</h2>
                                <input type="text" name="sitename" id="sitename" class="form-control" value="<?=$CMS_CONFIG["SITE_NAME"]?>" required>
                                <h2>サイト説明</h2>
                                <input type="text" name="sitedetail" id="sitedetails" class="form-control" value="<?=$CMS_CONFIG["SITE_DETAIL"]?>" required>
                                <h2>サイトURL</h2>
                                <input type="url" name="siteurl" id="siteurl" class="form-control" value="<?=$CMS_CONFIG["SITE_URL"]?>" required>
                                <h2>サイトロゴ</h2>
                                <input type="text" name="sitelogo" id="sitelogo" class="form-control" value="<?=$CMS_CONFIG["SITE_LOGO"]?>" required>
                                <h2>ログイン画面背景</h2>
                                <input type="text" name="logindisplay_background" id="logindisplayBackground" class="form-control" value="<?=$CMS_CONFIG["loginDisplay"]["background"]?>">
                                <h2>ログイン画面色調</h2>
                                <select name="theme" id="theme" class="form-select" required>
                                    <option value="light" <?php if($CMS_CONFIG["loginDisplay"]["theme"]=="light"){echo("selected");}?>>Light</option>
                                    <option value="dark" <?php if($CMS_CONFIG["loginDisplay"]["theme"]=="dark"){echo("selected");}?>>Dark</option>
                                </select>
                                <input type="submit" value="設定" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/logout.php" class="btn btn-danger">ログアウト</a>
        </section>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script>
            function authMi(){
                location.href = "/api/users/misskey/auth/?text="+document.getElementById('instance').value+"&loginMode=miauth"
            }
        </script>
    </body>
</html>