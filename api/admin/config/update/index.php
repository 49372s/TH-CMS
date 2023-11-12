<?php
include($_SERVER["DOCUMENT_ROOT"].'/th-config.php');
if(empty($_POST["logindisplay_background"])){
    $lb = null;
}else{
    $lb = $_POST["logindisplay_background"];
}
$config_file = 
'<?php function getConfig(){$CMS_CONFIG = array(
    "SITE_NAME"=>"'.$_POST["sitename"].'",
    "SITE_DETAIL"=>"'.$_POST["sitedetail"].'",
    "SITE_URL"=>"'.$_POST["siteurl"].'",
    "SITE_LOGO"=>"'.$_POST["sitelogo"].'",
    "mysql"=>array(
        "host"=>"'.$CMS_CONFIG["mysql"]["host"].'",
        "database"=>"'.$CMS_CONFIG["mysql"]["database"].'",
        "username"=>"'.$CMS_CONFIG["mysql"]["username"].'",
        "password"=>"'.$CMS_CONFIG["mysql"]["password"].'"
    ),
    "loginDisplay"=>array(
        "background"=>"'.$lb.'",
        "theme"=>"'.$_POST["theme"].'"
    )
);
return $CMS_CONFIG;
}
$CMS_CONFIG = getConfig();
function getFileList($dir) {
    $files = glob(rtrim($dir, "/") . "/*");
    $list = array();
    foreach ($files as $file) {
        if (is_file($file)) {
            $list[] = $file;
        }
        if (is_dir($file)) {
            $list = array_merge($list, getFileList($file));
        }
    }
    return $list;
}
/*プラグインロード処理*/
$arr = getFileList($_SERVER["DOCUMENT_ROOT"]."/includes/plugins/");
foreach($arr as $file){
    include_once($file);
}
?>';
$config_file_name = "/th-config.php";
    $path = $_SERVER['DOCUMENT_ROOT'];

    //保存
    $fh = fopen($path.$config_file_name,"w");
    fwrite($fh,$config_file);
    fclose($fh);

http_response_code(200);
header("Location: /dashboard/control/");
exit();
?>