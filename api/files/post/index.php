<?php
include($_SERVER['DOCUMENT_ROOT'].'/th-config.php');
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed");
}
//ファイルのアップロードを開始する

//先に必要な変数を用意する
$fileId = UuidV4Factory::generate();
$pdo = cdb();

$tmp = $_FILES['file']['tmp_name'];
$ufn = $_FILES['file']['name'];

$base_path = $_SERVER['DOCUMENT_ROOT'].'/content/data/image_';

$res = $pdo->query("SELECT * From user");
foreach($res as $val){
    if($_COOKIE['token'] == md5(date("Ym").$val[0].$val[4]) && $val[6]==3){
        //APIResponse(true,array('id'=>$val[0],'name'=>$val[2],"handle"=>$val[1],"mi"=>$val[5],"url"=>$val[7]));
        $author = $val[0];
    }
}
if(move_uploaded_file($tmp,$base_path.$fileId)){
    $sql = "INSERT INTO files(id,name,hash,tag,author) value(:id,:name,:hash,'unknown',:author)";
    $pre = $pdo -> prepare($sql);
    $arr = array(
        ":id"=>$fileId,
        ":name"=>$ufn,
        ":hash"=>md5(file_get_contents($base_path.$fileId)),
        ":author"=>$author
    );
    $pre->execute($arr);
    http_response_code(200);
    header('Location: /dashboard/new/imageUpload.php');
    exit();
}else{
    echo("Failed upload image!");
}
?>