<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"]."/th-config.php");
if(empty($_GET['session'])){
    http_response_code(400);
    exit();
}
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://".$_SESSION['url']."/api/miauth/".$_GET['session']."/check");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
$res = curl_exec($ch);
curl_close($ch);

$res = json_decode($res, true);
if($res["ok"] == 1 || $res["ok"] == true){
    $pdo = cdb();
    $sql = "UPDATE user set mi=:m, instance=:i where uid=:uid";
    $pre = $pdo->prepare($sql);
    $arr = array(":uid"=>getUserID($_COOKIE["token"]),":i"=>$_SESSION['url'],":m"=>$res["token"]);
    $pre -> execute($arr);
    http_response_code(200);
    header('Location: /dashboard/control/');
}
echo("セッションが有効期限切れです。");
?>