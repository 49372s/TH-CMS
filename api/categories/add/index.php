<?php
include($_SERVER["DOCUMENT_ROOT"]."/th-config.php");
//利用する変数配列群
$key = array(
    "name"
);
emptyCheck($key,"post");
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed.");
}
$uuid = UuidV4Factory::generate();
//DBにデータを保存する
$pdo = cdb();
$sql = "insert into category(id,name) values(:i,:n)";
$pre = $pdo->prepare($sql);
$arr = array(
    ":i"=>$uuid,
    ":n"=>$_POST['name']
);
$flug = $pre->execute($arr);
if($flug != 1){
    APIResponse(false,"Undefined error");
}else{
    APIResponse(true);
}
?>