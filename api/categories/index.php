<?php
include($_SERVER["DOCUMENT_ROOT"].'/th-config.php');
//一斉取得モード
$pdo = cdb();

$res = $pdo->query("SELECT * from category");
$html = "";
foreach($res as $val){
    if(!empty($_GET['mode'])){
        if($_GET['mode']=="1"){
            $html = $html . "<li><a href=\"/search/?c=".$val[0]."\">".$val[1]."</a></li>";
        }
    }else{
        if(!APIAuthenticate($_COOKIE['token'])){
            APIResponse(false,"Authenticate failed");
        }
        if(!empty($_POST["q"])){
            if(mb_strstr($val[1],$_POST["q"])==false){
                continue;
            }
        }
        $html = $html . "<tr>
        <td>".$val[1]."</td>
        <td>".$val[0]."</td>
        <td><button class=\"btn btn-danger\" onclick=\"requestDeleteCat('".$val[0]."');\">削除</button>
        </tr>";
    }
}
sleep(1);
APIResponse(true,$html);
?>