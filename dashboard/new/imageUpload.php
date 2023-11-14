<?php
include('../../th-config.php');
loginRedirect();
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="/includes/css/main.css?<?=time()?>">
        <title>画像のアップロード</title>
    </head>
    <body>
        <?php include('../../includes/template/nav.php');?>
        <div class="w-75 ms-auto me-auto">
            <h1>画像のアップロードと参照</h1>
            <p>このページでは、画像のアップロードと参照を行うことができます。</p>
            <h2>アップロード</h2>
            <form action="/api/files/post/" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="upFile" class="form-label">ファイルアップロード</label>
                    <input type="file" name="file" id="upFile" class="form-control">
                    <p>ファイル名はアップロードしたファイル名が適用されます。仮に、同じファイル名がアップロードされても、内部では違う名前を適用しているため、問題ありません。</p>
                </div>
                <input type="submit" value="アップロード" class="btn btn-primary">
            </form>
            <hr>
            <h2>画像の参照</h2>
            <form method="post" id="fileSearch">
                <div class="mb-3 ps-4 pe-4">
                    <label for="searchFile" class="form-label">ファイルを検索</label>
                    <input type="text" name="q" id="searchFile" class="form-control mb-3" placeholder="ファイル名 / ファイルタイトル">
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-outline-primary">検索</button>
                    </div>
                    <ul class="list-group" id="fileList"></ul>
                </div>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script>
            let form = document.getElementById('fileSearch');
            form.onsubmit = (event)=>{
                event.preventDefault();
                document.getElementById('fileList').innerHTML = "";
                if(form.q.value == "" || form.q.value == undefined || form.q.value == null){
                    q = "";
                }else{
                    q = form.q.value;
                }
                loadImages(q)
            }
            function loadImages(q = ""){
                $.post("/api/files/get/",{"q":q},(data)=>{
                    if(data.result==true){
                        data.data.forEach(element => {
                                document.getElementById('fileList').innerHTML = document.getElementById('fileList').innerHTML + '<li class="list-group-item"><img src="/content/data/image_'+element["id"]+'" class="w-50 ms-auto me-auto" style="display: block"><hr>'+element["name"]+'<a class="btn btn-success ms-3" onclick="copyToCB(\'/content/data/image_'+element['id']+'\')">リンクをコピー</a><button class="btn btn-danger ms-3" onclick="requestDelete(\''+element['id']+'\')">削除</button></li>'
                        });
                    }
                });
            }
            window.onload = ()=>{
                loadImages();
            }
            function copyToCB(str){
                navigator.clipboard.writeText(str).then(()=>{
                    window.alert("コピーしました。");
                })
            }
            function requestDelete(id){
                $.post("/api/files/delete/",{"id":id},(data)=>{
                    if(data.result==true){
                        window.alert("ファイルの削除に成功しました。");
                        location.reload();
                    }
                })
            }
        </script>
    </body>
</html>