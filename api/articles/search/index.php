<?php
include($_SERVER["DOCUMENT_ROOT"].'/th-config.php');
//一斉取得モード
$pdo = cdb();

$res = $pdo->query("SELECT * from article order by militime desc");
if(!empty($_GET['mode'])){
    if($_GET['mode']=="1"){
        $html = array();
    }
}else{
    $html = "";
}
foreach($res as $val){
    if(!APIAuthenticate($_COOKIE['token'])){
        APIResponse(false,"Authenticate failed");
    }
    if(!empty($_POST['q'])){
        if(mb_strpos($val[1],$_POST['q'])===false){
            continue;
        }
    }
    $html = $html . '<a class="list-group-item" href="/article/?id='.$val[0].'"><span style="font-size: 2em">'.$val[1].'</span><br><span class="text-secondary">最終更新: '.$val[4].'</span></a>';
}
APIResponse(true,$html);
?>