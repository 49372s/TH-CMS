<?php
include($_SERVER['DOCUMENT_ROOT']."/th-config.php");
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed");
}
$pdo = cdb();
$sql = "select * from category";
$html = "";
foreach($pdo->query($sql) as $val){
    $html = $html . '<option value="'.$val[1].'">'.$val[0].'</option>'."\n";
}
if(empty($html)){
    APIResponse(false);
}
APIResponse(true,$html);

?>