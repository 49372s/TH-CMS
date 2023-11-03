<?php
include_once($_SERVER['DOCUMENT_ROOT']."/th-config.php");
AdminAuthenticate($_POST['handle'],$_POST['password']);
?>