<?php
if(file_exists('./th-config.php')){
    http_response_code(404);
    exit();
}
header('Content-Type: application/json; charset=UTF-8;');
if(empty($_POST['dbh']) || empty($_POST['dbu']) || empty($_POST['dbp']) || empty($_POST['dbn'])){
    echo json_encode(array("result"=>"fail","detail"=>"プロパティ値が無効です。"));
    exit();
}


//SQLコネクション
try{
    $pdo = new PDO("mysql:host=".$_POST['dbh'].";charset=utf8;dbname=".$_POST['dbn'],$_POST['dbu'],$_POST['dbp'],[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    //成功しているのでこのまま保存処理を行う
    //データベースビルド
    //ユーザーテーブルを作成する
    $sql = "CREATE TABLE IF NOT EXISTS `test`.`user` ( `uid` VARCHAR(255) NOT NULL COMMENT '一意' , `handle` VARCHAR(255) NOT NULL , `nickname` VARCHAR(255) NOT NULL , `mail` VARCHAR(255) NOT NULL , `pwd` VARCHAR(255) NOT NULL , `mi` VARCHAR(255) NOT NULL COMMENT 'Misskey自動投稿用トークン' ,`permit` INT(5) NOT NULL, `instance` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Misskey URL', PRIMARY KEY (`uid`, `handle`)) ENGINE = InnoDB;";
    if($pdo -> query($sql) == false){
        echo json_encode(array("result"=>"fail","detail"=>"データベースの構築に失敗しました。権限を確認してください。"));
        exit();
    }
    $sql = "CREATE TABLE IF NOT EXISTS `article` (
        `id` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        `author` varchar(255) NOT NULL,
        `category` varchar(255) NOT NULL,
        `lastupdate` varchar(255) NOT NULL,
        `militime` int(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    if($pdo -> query($sql) == false){
        echo json_encode(array("result"=>"fail","detail"=>"データベースの構築に失敗しました。権限を確認してください。"));
        exit();
    }
    $sql = "CREATE TABLE IF NOT EXISTS `category` (
        `id` varchar(255) NOT NULL,
        `name` varchar(255) NOT NULL
        , PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    if($pdo -> query($sql) == false){
        echo json_encode(array("result"=>"fail","detail"=>"データベースの構築に失敗しました。権限を確認してください。"));
        exit();
    }
    $sql = "CREATE TABLE IF NOT EXISTS `files` (
        `id` varchar(255) NOT NULL,
        `name` varchar(255) NOT NULL,
        `hash` varchar(255) NOT NULL,
        `tag` varchar(255) NOT NULL,
        `author` varchar(255) NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    if($pdo -> query($sql) == false){
        echo json_encode(array("result"=>"fail","detail"=>"データベースの構築に失敗しました。権限を確認してください。"));
        exit();
    }
    //データベースを作成したので、次は設定類を保存していく
    //パラメーターチェック
    if(empty($_POST['uid']) || empty($_POST['name']) || empty($_POST['pwd'])){
        echo json_encode(array("result"=>"fail","detail"=>"パラメーターの値が異常です。データの保存に失敗しました。"));
        exit();
    }

    include('./includes/plugins/uuid.php');
    $sql = "INSERT into user(uid,handle,nickname,mail,pwd,mi,permit) value(:u,:h,:n,:m,:p,:mi,:pe)";
    $pre = $pdo->prepare($sql);
    $arr = array(
        ":u"=>UuidV4Factory::generate(),
        ":h"=>$_POST['uid'],
        ":n"=>$_POST['name'],
        ":p"=>hash("sha3-512",$_POST['pwd']),
        ":m"=>"null@null.pointer.exception",
        ":mi"=>"null",
        ":pe"=>3
    );
    if($pre -> execute($arr) != 1){
        echo json_encode(array("result"=>"fail","detail"=>"データベースの構築に失敗しました。権限を確認してください。"));
        exit();
    }
    //最悪な気分です。余計なものをコミットしたせいで削除しないといけません。リポジトリ変えるまでそのままとか罰ゲームにもほどがあるだろ。ignoreに追加し忘れただけなのに。なので手動削除。
    unlink($_SERVER['DOCUMENT_ROOT'].'/content/data/blog_32b1e47d-abde-48cc-8132-1264d7f134b5.html');
    unlink($_SERVER['DOCUMENT_ROOT'].'/content/data/image_861edf39-5220-42ac-8378-c8ede5fdc328');
    unlink($_SERVER['DOCUMENT_ROOT'].'/content/data/image_2932ce18-f138-473a-8d67-9978c6a36bd6');
    unlink($_SERVER['DOCUMENT_ROOT'].'/content/data/image_8040ffbe-d17e-4d05-a34e-f18c0f5b93b0');
    //設定ファイルを作成する
    $_sitename = $_POST['siteName'];
    $_sitedetails = $_POST['siteDetail'];
    $_siteurl = $_POST['siteUrl'];
    $_mysql_host = $_POST['dbh'];
    $_mysql_dbname = $_POST['dbn'];
    $_mysql_user_name = $_POST['dbu'];
    $_mysql_user_password = $_POST['dbp'];

    $config_file = 
'<?php function getConfig(){$CMS_CONFIG = array(
    "SITE_NAME"=>"'.$_sitename.'",
    "SITE_DETAIL"=>"'.$_sitedetails.'",
    "SITE_URL"=>"'.$_siteurl.'",
    "SITE_LOGO"=>"/content/system/image/tkngh.png",
    "mysql"=>array(
        "host"=>"'.$_mysql_host.'",
        "database"=>"'.$_mysql_dbname.'",
        "username"=>"'.$_mysql_user_name.'",
        "password"=>"'.$_mysql_user_password.'"
));
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
    echo json_encode(array("result"=>"success"));
}catch(PDOException $e){
    echo json_encode(array("connection"=>"fail","detail"=>$e->getMessage()));
    exit();
}
?>