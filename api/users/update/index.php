<?php
include($_SERVER["DOCUMENT_ROOT"].'/th-config.php');
loginRedirect();

$pdo = cdb();
$sql = "SELECT * from user";
$res = $pdo->query($sql);
$pw = null;
foreach($res as $val){
    if($val[0] == getUserID($_COOKIE["token"])){
        $pw = $val[4];
    }
}
if($pw==null){
    if(empty($_POST["password"])){
        header('Location: /logout.php');
    }else{
        $pw = hash("sha3-512",$_POST["password"]);
    }
}
    $sql = "UPDATE user set nickname=:n, pwd=:p where uid=:uid";
    $pre = $pdo->prepare($sql);
    $arr = array(":uid"=>getUserID($_COOKIE["token"]),":n"=>$_POST["nickname"],":p"=>$pw);
    $pre -> execute($arr);
header('Location: /dashboard/control/');
?>