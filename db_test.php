<?php
header('Content-Type: application/json; charset=UTF-8;');
if(empty($_POST['dbh']) || empty($_POST['dbu']) || empty($_POST['dbp']) || empty($_POST['dbn'])){
    echo json_encode(array("connection"=>"fail","detail"=>"プロパティ値が無効です。"));
    exit();
}
try{
    $pdo = new PDO("mysql:host=".$_POST['dbh'].";charset=utf8;dbname=".$_POST['dbn'],$_POST['dbu'],$_POST['dbp'],[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo json_encode(array("connection"=>"success"));
    $pdo = null;
}catch(PDOException $e){
    echo json_encode(array("connection"=>"fail","detail"=>$e->getMessage()));
    exit();
}
?>