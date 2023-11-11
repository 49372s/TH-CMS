<?php
include($_SERVER['DOCUMENT_ROOT'].'/th-config.php');
require_once($_SERVER['DOCUMENT_ROOT']."/includes/modules/markdown/Markdown.inc.php");
use Michelf\Markdown;
//利用する変数配列群
$key = array(
    "author",
    "category",
    "title",
    "body",
    "mode"
);
emptyCheck($key,"post");
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed.");
}

//データを一度格納
$author = $_POST['author'];
$category = $_POST['category'];
$title = $_POST['title'];
$body = $_POST['body'];
$mode = $_POST['mode'];

//タイトルへのHTMLタグの使用を禁止する
$title = strip_tags($title);
//カテゴリーの検証
if(!getCategory(0,$category)){
    //問題あり
    APIResponse(false,"Category is invalid.");
}

//DBにデータを保存する
//記事のIDを取得する
$uuid = UuidV4Factory::generate();
$pdo = cdb();
$sql = "insert into article(id,title,author,category,lastupdate,militime) values(:i,:t,:a,:c,:l,:m)";
$pre = $pdo->prepare($sql);
$arr = array(
    ":i"=>$uuid,
    ":t"=>$title,
    ":a"=>$author,
    ":c"=>$category,
    ":l"=>date("Y/m/d H:i:s"),
    ":m"=>time()
);
$flug = $pre->execute($arr);
if($flug != 1){
    APIResponse(false,"Undefined error");
}

$html = Markdown::defaultTransform($body);
if(!file_exists($_SERVER['DOCUMENT_ROOT']."/content/data/")){
    mkdir($_SERVER['DOCUMENT_ROOT']."/content/data/");
}
$fhd = fopen($_SERVER['DOCUMENT_ROOT']."/content/data/blog_$uuid.html","w");
fwrite($fhd,$html);
fclose($fhd);

if($mode === true || $mode === "1" || $mode === "true"){
    //Mi Auto Post
    $token = $_POST['token'];
    $server = $_POST['instance'];

    //APIアクセス
    $param = array(
        "text"=>$title." - ".$CMS_CONFIG["SITE_NAME"]."\n".$CMS_CONFIG["site_url"]."/article/?id=".$uuid,
        "i"=>$token
    );
    APIRequest($server,"notes/create",$param);
}
APIResponse(true);
?>