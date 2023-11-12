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
                            <form action="./" method="get" class="d-flex">
                                <input type="search" name="q" class="form-control" placeholder="検索">
                                    <button type="submit" class="btn btn-outline-success" style="width: 100px;">検索</button>
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
        <script>
            function getArticle(q = ""){
                $.post("/api/articles/search/",{"q":q},(data)=>{
                    if(data.result==true){
                        document.getElementById('result').innerHTML = data.data;
                    }
                });
            }
            window.onload = ()=>{
                getArticle("<?=$_GET['q']??""?>");
            }
        </script>
    </body>
</html>