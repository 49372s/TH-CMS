<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/modules/markdown/Markdown.inc.php');
use Michelf\Markdown;
function getArticle($id){
    $pdo = cdb();
    $sql = "SELECT * from article";
    $res = $pdo->query($sql);
    foreach($res as $val){
        if($val[0]==$id){
            $html = file_get_contents($_SERVER['DOCUMENT_ROOT']."/content/data/blog_$id.html");
            return array("title"=>$val[1],"author"=>$val[2],"category"=>$val[3],"lastUpdate"=>$val[4],"html"=>$html);
        }
    }
}

function readArticles($id){
    $pdo = cdb();
    $sql = "SELECT * from article";
    $res = $pdo->query($sql);
    foreach($res as $val){
        if($val[0]==$id){
            $html = file_get_contents($_SERVER['DOCUMENT_ROOT']."/content/data/blog_$id.html");
            return Markdown::defaultTransform($html);
        }
    }
}

function latestArticles($int = 5){
    $pdo = cdb();
    $sql = "SELECT * from article order by militime desc limit 3";
    $res = $pdo->query($sql);
    $html = "";
    foreach($res as $val){
        if(!APIAuthenticate($_COOKIE['token'])){
            APIResponse(false,"Authenticate failed");
        }
        $html = $html . '<a class="list-group-item" href="/article/?id='.$val[0].'"><span style="font-size: 2em">'.$val[1].'</span><br><span class="text-secondary">最終更新: '.$val[4].'</span></a>';
    }
    return $html;
}
?>