<?php
include($_SERVER["DOCUMENT_ROOT"]."/th-config.php");
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed");
}
$pdo = cdb();
$sql = "DELETE from category where id=:id";
$pre = $pdo->prepare($sql);
$arr = array(":id"=>$_POST['id']);
$flug = $pre->execute($arr);
if($flug == 1){
    APIResponse(true);
}else{
    APIResponse(false);
}
?>