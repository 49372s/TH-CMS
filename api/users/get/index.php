<?php
include("../../../th-config.php");
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed");
}
//ログイン情報からアカウントの情報を返す
$pdo = cdb();
$res = $pdo->query("SELECT * From user");
foreach($res as $val){
    if($_COOKIE['token'] == md5(date("Ym").$val[0].$val[4]) && $val[6]==3){
        APIResponse(true,array('id'=>$val[0],'name'=>$val[2],"handle"=>$val[1],"mi"=>$val[5],"url"=>$val[7]));
    }
}
APIResponse(false);
?>