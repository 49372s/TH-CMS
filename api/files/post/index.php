<?php
include($_SERVER['DOCUMENT_ROOT'].'/th-config.php');
if(!APIAuthenticate($_COOKIE['token'])){
    APIResponse(false,"Authenticate failed");
}
//ファイルのアップロードを開始する

//ファイルがアップロードされているか確認
if(!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK){
    $error_messages = [
        UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
        UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
        UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
    ];
    $error_code = $_FILES['file']['error'] ?? 'No file uploaded';
    $error_message = is_numeric($error_code) ? ($error_messages[$error_code] ?? 'Unknown error') : $error_code;
    APIResponse(false,"File upload error: ".$error_code." - ".$error_message);
}

//先に必要な変数を用意する
$fileId = UuidV4Factory::generate();
$pdo = cdb();

$tmp = $_FILES['file']['tmp_name'];
$ufn = $_FILES['file']['name'];

$base_path = $_SERVER['DOCUMENT_ROOT'].'/content/data/image_';

//ディレクトリが存在しない場合は作成
$data_dir = $_SERVER['DOCUMENT_ROOT'].'/content/data/';
if(!is_dir($data_dir)){
    mkdir($data_dir, 0755, true);
}

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