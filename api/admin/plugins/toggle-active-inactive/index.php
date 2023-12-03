<?php
include_once($_SERVER["DOCUMENT_ROOT"].'/th-config.php');
loginRedirect();

$id = $_GET["id"];
$mode = $_GET["AIa"];

if($mode == "on"){
    $mode = 1;
}elseif($mode == "off"){
    $mode = 0;
}else{
    APIResponse("Error","Invalid request.");
}
$pdo = cdb();
$sql = "UPDATE plugins set status = :status where id=:id";
$pre = $pdo->prepare($sql);
$pre->execute(array(":status"=>$mode,":id"=>$id));

http_response_code(200);
header('Location: /dashboard/plugins/');
exit();
?>