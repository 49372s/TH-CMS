<?php
if(file_exists('./th-config.php')){
    http_response_code(404);
    exit();
}
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>TKNGH CMSのセットアップ</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container p-4 align-items-center">
            <section class="shadow mb-5 me-auto ms-auto p-4 rounded">
                <h1>TKNGH CMSのセットアップ</h1>
            </section>
            <section class="shadow mb-5 me-auto ms-auto p-4 rounded">
                <h2 class="mb-2">サイト名</h2>
                <input type="text" id="site-name" placeholder="サイト名" class="form-control mb-4">
                <h2 class="mb-2">サイトの詳細</h2>
                <input type="text" id="site-descript" class="form-control" placeholder="サイト概要">
            </section>
            <section class="shadow mb-5 me-auto ms-auto p-4 rounded">
                <h2>データベースへの接続設定</h2>
                <h3>ホスト名</h3>
                <div class="input-group mb-4">
                    <span class="input-group-text" id="database-host-text">mysql://</span>
                    <input type="text" class="form-control" placeholder="localhost:3306" aria-label="database" aria-describedby="database-host-text" id="database-host">
                </div>
                <h3>ユーザー名</h3>
                <p>分からない場合は、ドメイン名を「%」のままにしてください。</p>
                <div class="input-group mb-4">
                    <input type="text" class="form-control" placeholder="user" aria-label="user" aria-describedby="database-username-text" id="database-username">
                    <span class="input-group-text" id="database-username-text">@</span>
                    <input type="text" class="form-control" value="%" placeholder="domain" aria-label="domain" aria-describedby="database-username-text" id="database-username-domain">
                </div>
                <h3>パスワード</h3>
                <input type="password" id="database-password" class="form-control" placeholder="データベース接続パスワード" autocomplete="new-password">
                <h3>データベース名</h3>
                <input type="text" class="form-control" placeholder="db01" id="database-name">
                <div class="text-end pt-3">
                    <button class="btn btn-outline-danger me-3" id="form-clear">クリア</button>
                    <button class="btn btn-outline-primary me-3" onclick="check()">接続テスト</button>
                </div>
            </section>
            <div>
                <section class="shadow mb-5 me-auto ms-auto p-4 rounded">
                    <h2>ユーザー設定</h2>
                    <h3>ユーザー名</h3>
                    <p>ユーザーハンドルです。文字についての指定はありませんが、絵文字を指定すると正常な動作が行えなくなります。</p>
                    <input type="text" name="user_handle" id="user_handle" class="form-control" placeholder="user handle">
                    <h3>ニックネーム</h3>
                    <p>サイトに表示される名前です。ハンドルと違いIDとしては扱われません。</p>
                    <input type="text" class="form-control" id="user_nickname" placeholder="Nickname">
                    <h3>パスワード</h3>
                    <p>パスワードの確認はありません。その為、メモ帳からコピーしてきたり、ブラウザのパスワード作成機能を用いてペーストを行うことを推奨いたします。</p>
                    <input type="password" class="form-control" id="user_password" placeholder="Account password">
                </section>
                <section class="shadow mb-5 me-auto ms-auto p-4 rounded">
                    <h2>データの保存</h2>
                    <p>保存を行う前に確認してください！</p>
                    <p><b>データベースのテスト</b>を実行しましたか？また、データベースに誤りはありませんか？</p>
                    <p>ユーザー名、パスワードに誤りはありませんか？</p>
                    <p>全項目設定を確認しましたか？</p>
                    <p>保存後、このページには戻ってこれません！</p>
                    <p>確認出来たら、下のボタンを押して設定完了です。</p>
                    <button id="saveConfig" class="btn btn-primary">設定を確定</button>
                </section>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script>
            let config_sql = false;
            function clear(){
                document.getElementById('database-host').value = "";
                document.getElementById('database-name').value = "";
                document.getElementById('database-username').value = "";
                document.getElementById('database-username-domain').value = "localhost";
                document.getElementById('database-password').value = "";
            }
            function check(){
                //ユーザー名にドメイン指定がある場合(%ではない場合)は、ユーザー名にアクセス元のアドレスを付加する
                if(document.getElementById('database-username-domain').value != "%" && document.getElementById('database-username-domain').value != null && document.getElementById('database-username-domain').value != "" && document.getElementById('database-username-domain').value != undefined){
                    user = document.getElementById('database-username').value + "@" + document.getElementById('database-username-domain').value;
                }else if(document.getElementById('database-username-domain').value == null || document.getElementById('database-username-domain').value == "" || document.getElementById('database-username-domain').value == undefined){
                    window.alert("ユーザーのログイン元アドレスは指定する必要があります。");
                    return;
                }else{
                    user = document.getElementById('database-username').value;
                }
                $.post("/db_test.php",{"dbh":document.getElementById('database-host').value,"dbn":document.getElementById('database-name').value,"dbu":user,"dbp":document.getElementById('database-password').value},(data)=>{
                    if(data.connection == "success"){
                        window.alert("接続成功");
                        config_sql = true;
                    }else{
                        window.alert(data.detail);
                    }
                })
            }
            function getFormdata(id){
                return document.getElementById(id).value;
            }
            document.getElementById('form-clear').onclick = ()=>{
                clear();
            }
            document.getElementById('saveConfig').onclick = ()=>{
                if(getFormdata('database-username-domain') != "%" && getFormdata('database-username-domain') != null && getFormdata('database-username-domain') != "" && getFormdata('database-username-domain') != undefined){
                    user = getFormdata('database-username') + "@" + getFormdata('database-username-domain');
                }else if(document.getElementById('database-username-domain').value == null || document.getElementById('database-username-domain').value == "" || document.getElementById('database-username-domain').value == undefined){
                    window.alert("ユーザーのログイン元アドレスは指定する必要があります。");
                    return;
                }else{
                    user = getFormdata('database-username');
                }
                $.post("/save-config.php",{
                    "dbh":getFormdata("database-host"),
                    "dbn":getFormdata("database-name"),
                    "dbu":user,
                    "dbp":getFormdata("database-password"),
                    "siteName":getFormdata("site-name"),
                    "siteDetail":getFormdata("site-descript"),
                    "uid":getFormdata("user_handle"),
                    "name":getFormdata("user_nickname"),
                    "pwd":getFormdata("user_password")
                },(data)=>{
                    if(data.result == "success"){
                        window.alert("設定の保存に成功しました。");
                        location.href = "";
                    }else{
                        window.alert("設定の保存に失敗しました。\n"+data.detail);
                    }
                });
            }
            
        </script>
    </body>
</html>