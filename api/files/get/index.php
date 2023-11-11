<?php
include($_SERVER['DOCUMENT_ROOT'].'/th-config.php');
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed");
}
$pdo = cdb();
$res = $pdo->query("SELECT * From user");
foreach($res as $val){
    if($_COOKIE['token'] == md5(date("Ym").$val[0].$val[4]) && $val[6]==3){
        $uid = $val[0];
    }
}

$files = array();
$res = $pdo->query("SELECT * From files");
foreach($res as $val){
    if($val[4] == $uid){
        if($_POST['q'] == ""){
            array_push($files, array("id"=>$val[0],"name"=>$val[1]));
        }else{
            if(mb_strstr($val[1],$_POST["q"])!=false){
                array_push($files, array("id"=>$val[0],"name"=>$val[1]));
            }
        }
    }
}
if($files == array()){
    APIResponse(false,"No match files.");
}

APIResponse(true,$files);
?>