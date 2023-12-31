<?php
include_once('../th-config.php');
?>
<!doctype html>
<html lang="ja-jp">
    <head>
        <title>検索 | <?=$CMS_CONFIG["SITE_NAME"]?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    </head>
    <body>
        <?php include('../includes/template/nav.php');?>
        <div class="p-2">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            検索
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form action="./" method="get">
                                <div class="d-flex">
                                    <input type="search" name="q" class="form-control" placeholder="検索" value="<?=$_GET['q']??""?>">
                                    <button type="submit" class="btn btn-outline-success" style="width: 100px;">検索</button>
                                </div>
                                <hr>
                                <label for="categories" class="form-label">カテゴリー</label>
                                <input class="form-control" list="datalistOptions" id="categories" placeholder="カテゴリーの名前を入力" name="c" value="<?=$_GET['c']??""?>">
                                <datalist id="datalistOptions">
                                </datalist>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <h1>検索結果</h1>
            <ul class="list-group" id="result"></ul>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="/includes/script/search.js"></script>
        <script>
            window.onload = ()=>{
                getArticle("<?=$_GET['q']??""?>","<?=$_GET["c"]??""?>");
                $.post("/api/admin/category/get/",(data)=>{
                    if(data.result==true){
                        document.getElementById('datalistOptions').innerHTML = data.data;
                    }
                })
            }
        </script>
    </body>
</html>