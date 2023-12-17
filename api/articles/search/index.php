<?php
include($_SERVER["DOCUMENT_ROOT"].'/th-config.php');
//一斉取得モード
$pdo = cdb();

$res = $pdo->query("SELECT * from article order by militime desc");
if(!empty($_POST['mode'])){
    if($_POST['mode']=="1"){
        if(master::getPluginStatus(search::$id)==true){
            APIResponse(true,search::searchByCategory($_POST["c"]));
        }else{
            APIResponse(false,"INVALID");
        }
        APIResponse(false,"Undefined");
    }
}else{
    $html = "";
}
foreach($res as $val){
    /*if(!APIAuthenticate($_COOKIE['token'])){
        APIResponse(false,"Authenticate failed");
    }*/
    if(!empty($_POST['q'])){
        if(mb_strpos($val[1],$_POST['q'])===false){
            continue;
        }
    }
    if(!empty($_POST["c"])){
        if(mb_strpos($val[3],$_POST["c"])===false){
            continue;
        }
    }
    $html = $html . '<a class="list-group-item" href="/article/?id='.$val[0].'"><div style="line-height: 2em;position: relative;"><span style="font-size: 2em">'.$val[1].'</span><span class="ms-3 badge bg-primary">'.$val[3].'</span></div><span class="text-secondary">最終更新: '.$val[4].'</span></a>';
}
APIResponse(true,$html);
?>