<?php
include($_SERVER["DOCUMENT_ROOT"]."/th-config.php");
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed");
}
$pdo = cdb();
$sql = "DELETE from files where id=:id";
$pre = $pdo->prepare($sql);
$arr = array(":id"=>$_POST['id']);
$flug = $pre->execute($arr);
if($flug == 1){
    unlink($_SERVER["DOCUMENT_ROOT"]."/content/data/image_".$_POST["id"]);
    APIResponse(true);
}else{
    APIResponse(false);
}
?>