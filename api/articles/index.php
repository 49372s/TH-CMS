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
    if(!empty($_GET['mode'])){
        if($_GET['mode']=="1"){
            array_push($html, array(
                "url"=>$CMS_CONFIG["SITE_URL"]."/article/?id=".$val[0],
                "title"=>$val[1],
                "category"=>$val[3],
                "lastupdate"=>$val[4],
                "author"=>verifyUser($val[2])
            ));
        }
    }else{
        if(!APIAuthenticate($_COOKIE['token'])){
            APIResponse(false,"Authenticate failed");
        }
        if(!empty($_POST['q'])){
            if(mb_strpos($val[1],$_POST['q'])===false){
                continue;
            }
        }
        $html = $html . "<tr>
        <td>".$val[4]."</td>
        <td>".$val[1]."</td>
        <td>".verifyUser($val[2])."</td>
        <td>".$val[3]."</td>
        <td>".$val[0]."</td>
        <td><button class=\"me-1 btn btn-primary\" onclick=\"location.href='/dashboard/edit/?id=".$val[0]."'\">編集</button><button class=\"me-1 btn btn-info\" onclick=\"view('".$val[0]."');\">閲覧</button><button class=\"btn btn-danger\" onclick=\"requestDelete('".$val[0]."');\">削除</button>
        </tr>";
    }
}
APIResponse(true,$html);
?>