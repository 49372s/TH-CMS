<?php
//データを受け取る
if(empty($_GET['text']) || empty($_GET['loginMode'])){
    echo("Can not be login.");
    exit();
}
$mode = $_GET['loginMode'];
$text = $_GET['text'];
session_start();
include($_SERVER["DOCUMENT_ROOT"].'/th-config.php');

$session = UuidV4Factory::generate();

if($mode == "miauth"){
    http_response_code(200);
    header("Location: https://".$text."/miauth/$session?name=".$CMS_CONFIG["SITE_NAME"]."&callback=".urlencode($CMS_CONFIG["SITE_URL"]."/api/users/misskey/callback/")."&permission=read:account,write:notes");
    $_SESSION['session'] = $session;
    $_SESSION['url'] = $text;
    exit();
}
?>