<?php
require($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/MASTER.php");
//アクセスカウンタプラグイン
class AccessCounter {
    //プラグインID
    public static $id = "0956ca2b-0d19-45da-8dab-af6ec75b57b9";

    public static function status(){
        $CMS_CONFIG = getConfig();
        $pdo = cdb();
        $sql = "SELECT 1 FROM information_schema.tables WHERE table_name = 'access' and table_schema = '".$CMS_CONFIG["mysql"]["database"]."'";
        $query = $pdo->query($sql);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        /*if($data[0][1] == 1){
            return true;
        }*/
        return false;
    }
    public static function initialize(){
        if(AccessCounter::status() == false){
            $pdo = cdb();
            $sql = "CREATE TABLE IF NOT EXISTS `access` (
                `id` varchar(255) NOT NULL,
                `pv` int(255) NOT NULL,
                `ua` int(255) NOT NULL
                , PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            if($pdo -> query($sql) == false){
                echo json_encode(array("result"=>"fail","detail"=>"データベースの構築に失敗しました。権限を確認してください。"));
                exit();
            }
            $sql = "CREATE TABLE IF NOT EXISTS `access_control` (
                `id` varchar(255) NOT NULL,
                `session` varchar(255) NOT NULL,
                `lastdate` varchar(255) NOT NULL
                , PRIMARY KEY (`id`, `session`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            if($pdo -> query($sql) == false){
                echo json_encode(array("result"=>"fail","detail"=>"データベースの構築に失敗しました。権限を確認してください。"));
                exit();
            }
        }else{
            return "設定済";
        }
    }
    public static function count($id){
        AccessCounter::initialize();
        if(master::getPluginStatus(AccessCounter::$id) == false){
            return "このプラグインは無効です。";
        }
        if(AccessCounter::checkExists($id) == true){
            $pv = AccessCounter::getNow($id)["pv"];
            $ua = AccessCounter::getNow($id)["ua"];
            $pdo = cdb();
            if(AccessCounter::checkAccessed($id, AccessCounter::getSession())==false){
                $ua = intval($ua) + 1;
                $sql = "UPDATE access_control set lastdate=:l where id=:i and session=:s";
                $pre = $pdo->prepare($sql);
                $arr = array(
                    ":l" => date('Ymd'),
                    ":i" => $id,
                    ":s" => AccessCounter::getSession()
                );
                $pre->execute($arr);
            }
            $pv = intval($pv) + 1;
            $sql = "UPDATE access set pv=:p, ua=:u where id=:i";
            $pre = $pdo->prepare($sql);
            $arr = array(
                ":p" => $pv,
                ":i" => $id,
                ":u" => $ua
            );
            $pre->execute($arr);
        }else{
            AccessCounter::checkAccessed($id, AccessCounter::getSession());
            $pdo = cdb();
            $pv = 1;
            $ua = 1;
            $sql = "INSERT into access(id,pv,ua) values(:i,:p,:u)";
            $pre = $pdo->prepare($sql);
            $pre->execute(array(
                ":i"=>$id,
                ":p" => $pv,
                ":u" => $ua
            ));
        }
        return array("pv"=>$pv,"ua"=>$ua);
    }
    public static function checkExists($id){
        $pdo = cdb();
        $sql = "SELECT * FROM access";
        $res = $pdo->query($sql);
        if($res == array()){
            return false;
        }
        foreach($res as $val){
            if($val[0] == $id){
                return true;
            }
        }
        return false;
    }
    public static function getSession(){
        if(empty($_COOKIE["p_a_c_d_i_s"])){
            $uuid = UuidV4Factory::generate();
            setcookie("p_a_c_d_i_s", $uuid, time() + 60 * 60 * 24 * 365, "/");
            return $uuid;
        }else{
            return $_COOKIE["p_a_c_d_i_s"];
        }
    }
    public static function checkAccessed($pageId, $sessionKey){
        $pdo = cdb();
        $sql = "SELECT * FROM access_control";
        $sessionExist = false;
        $res = $pdo->query($sql);
        if($res != array()){
            foreach($res as $val){
                if($val[0] == $pageId && $val[1] == $sessionKey){
                    $sessionExist = true;
                }
                if($val[0] == $pageId && $val[1] == $sessionKey && $val[2] != date('Ymd')){
                    return false;
                }
            }
        }
        if($sessionExist == false){
            print("fals");
            $sql = "INSERT into access_control(`id`, `session`, `lastdate`) values(:i,:s,:l)";
            $pre = $pdo->prepare($sql);
            $arr = array(
                ":i" => $pageId,
                ":s" => $sessionKey,
                ":l" => date('Ymd')
            );
            $pre->execute($arr);
        }
        return true;
    }
    public static function getNow($pageId){
        $pdo = cdb();
        $sql = "SELECT * FROM access";
        foreach($pdo->query($sql) as $val){
            if($val[0] == $pageId){
                return array("pv"=>$val[1], "ua"=>$val[2]);
            }
        }
    }
}


$master = new master();
//プラグイン設定
$master->addPlugin(array(
    "id" => AccessCounter::$id,
    "name" => "アクセスカウンター",
    "detail" => "アクセスカウンターです。ページごとに記録でき、ページビュー数とユニークアクセス数を記録できます。ただし、IPアドレスを用いるため、プライバシーポリシーへの明記が必要です。",
    "config" => AccessCounter::initialize(),
    "status" => master::getPluginStatus("0956ca2b-0d19-45da-8dab-af6ec75b57b9"),
    "author" => "德永皓斗"
));
?>