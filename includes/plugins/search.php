<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/MASTER.php");
class search{
    public static $id = "cc3d6e5a-42e0-43be-99f2-84ac67beb0db";
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
        return "設定内容無";
    }
    public static function searchByCategory($category){
        //完全一致検索
        $CMS_CONFIG = getConfig();
        $pdo = cdb();
        $res = $pdo->query("SELECT * from article order by militime desc");
        $response = array();
        foreach($res as $val){
            if($val[3]!=$category){
                continue;
            }
            array_push($response, array(
                "url"=>$CMS_CONFIG["SITE_URL"]."/article/?id=".$val[0],
                "title"=>$val[1],
                "category"=>$val[3],
                "lastupdate"=>$val[4],
                "author"=>verifyUser($val[2])
            ));
        }
        return $response;
    }
}

$master = new master();
//プラグイン設定
$master->addPlugin(array(
    "id" => search::$id,
    "name" => "検索プラグイン",
    "detail" => "検索システムプラグインです。いろんな検索方法を提供します。",
    "config" => search::initialize(),
    "status" => master::getPluginStatus(search::$id),
    "author" => "德永皓斗"
));
?>