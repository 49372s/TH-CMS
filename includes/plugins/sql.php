<?php
function cdb(){
    $CMS_CONFIG = getConfig();
    return new PDO("mysql:host=".$CMS_CONFIG["mysql"]["host"].";dbname=".$CMS_CONFIG["mysql"]["database"].";charset=utf8",$CMS_CONFIG["mysql"]["username"],$CMS_CONFIG["mysql"]["password"]);
}
?>