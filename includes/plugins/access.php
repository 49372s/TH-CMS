<?php
require($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/MASTER.php");
//アクセスカウンタプラグイン
class AccessCounter {
    public static function status(){
        $pdo = cdb();
        $sql = "SELECT 1 FROM information_schema.tables WHERE table_name = 'article'";
        $query = $pdo->query($sql);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        if($data[0][1] == 1){
            return "Exists!";
        }
    }
}
$master = new master();
//プラグイン設定
$master->addPlugin(array(
    "id" => "0956ca2b-0d19-45da-8dab-af6ec75b57b9",
    "name" => "アクセスカウンター",
    "detail" => "アクセスカウンターです。ページごとに記録でき、ページビュー数とユニークアクセス数を記録できます。ただし、IPアドレスを用いるため、プライバシーポリシーへの明記が必要です。",
    "config" => null,
    "status" => master::getPluginStatus("0956ca2b-0d19-45da-8dab-af6ec75b57b9"),
    "author" => "德永皓斗"
));
?>