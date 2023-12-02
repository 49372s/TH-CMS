<?php
/**
 * !警告!
 * Warning!
 * 
 * このファイルはプラグインマスターファイルです！
 * This file is plugins master script file!
 * 
 * このファイルの改変や削除、また導入忘れがあった場合は正常にソフトウェアが機能しない場合があります！
 * If you modify or delete this file, or forget to install it, the software may not function properly!
 * 
 * 必ず慎重に扱うようにしてください！
 * Be sure to handle it carefully!
 */


/**ここから下は、プラグインに対しての関数になります。通常はユーザー向けに扱いません。 */
class master{
    public static function addPlugin($arr){
        if(!file_exists($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/plugins.json")){
            $fhd = fopen($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/plugins.json","w");
            fwrite($fhd, json_encode(array(),JSON_UNESCAPED_UNICODE));
            fclose($fhd);
        }
        
        $f = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/plugins.json");
        $pluginsFile = json_decode($f,true);
        if(master::deplicateCheck($pluginsFile,$arr)==false){
            array_push($pluginsFile,$arr);
        }elseif(master::deplicateCheck($pluginsFile,$arr)==2){
            $key = array_search($arr["id"],$pluginsFile);
            array_splice($pluginsFile, $key, 1);
            array_push($pluginsFile,$arr);
        }
        $fhd = fopen($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/plugins.json","w");
        fwrite($fhd, json_encode($pluginsFile,JSON_UNESCAPED_UNICODE));
        fclose($fhd);
    }
    public static function getToggle($id, $status = false){
        if($status == true){
            $html = '<form action="/api/admin/plugins/toggle-active-inactive/" method="get"><div class="form-check"><input class="form-check-input" type="radio" name="AIa" id="pluginActive_'.$id.'" value="on" checked><label class="form-check-label" for="pluginActive_'.$id.'">有効</label></div><div class="form-check"><input class="form-check-input" type="radio" name="AIa" id="pluginInactive_'.$id.'" value="off"><label class="form-check-label" for="pluginInactive_'.$id.'">無効</label></div><input type="hidden" value="'.$id.'" name="id"><input type="submit" class="btn btn-primary" value="反映"></form>';
        }else{
            $html = '<form action="/api/admin/plugins/toggle-active-inactive/" method="get"><div class="form-check"><input class="form-check-input" type="radio" name="AIa" id="pluginActive_'.$id.'" value="on"><label class="form-check-label" for="pluginActive_'.$id.'">有効</label></div><div class="form-check"><input class="form-check-input" type="radio" name="AIa" id="pluginInactive_'.$id.'" value="off" checked><label class="form-check-label" for="pluginInactive_'.$id.'">無効</label></div><input type="hidden" value="'.$id.'" name="id"><input type="submit" class="btn btn-primary" value="反映"></form>';
        }
        return $html;
    }
    public static function status(){
        $CMS_CONFIG = getConfig();
        $pdo = cdb();
        $sql = "SELECT 1 FROM information_schema.tables WHERE table_name = 'plugins' and table_schema = '".$CMS_CONFIG["mysql"]["database"]."'";
        $query = $pdo->query($sql);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        if($data[0][1] == 1){
            return true;
        }
        return false;
    }
    public static function initialize(){
        if(master::status() == false){
            $pdo = cdb();
            $sql = "CREATE TABLE IF NOT EXISTS `plugins` (
                `id` varchar(255) NOT NULL,
                `name` varchar(255) NOT NULL,
                `status` int(255) NOT NULL
                , PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            if($pdo -> query($sql) == false){
                echo json_encode(array("result"=>"fail","detail"=>"データベースの構築に失敗しました。権限を確認してください。"));
                exit();
            }
        }else{
            echo ( "すでに有効" );
        }
    }
    public static function getPluginStatus($id){
        if(!master::status()){
            master::initialize();
        }
        $pdo = cdb();
        $sql = "SELECT * from plugins";
        $res = $pdo->query($sql);
        $flug = false;
        foreach($res as $val){
            if($val[0] == $id){
                $flug = true;
                if($val[2] == 1){
                    return true;
                }else{
                    return false;
                }
            }
        }
        if($flug == false){
            $sql = "INSERT into plugins(id, name, status) values(:i,:n,:s)";
            $pre = $pdo->prepare($sql);
            $arr = array(
                ":i" => $id,
                ":n" => master::getPluginsInfo($id)["name"],
                ":s" => 0
            );
            $pre->execute($arr);
        }
    }
    public static function getPluginsInfo($id){
        $f = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/plugins.json");
        $pluginsFile = json_decode($f,true);
        print_r($pluginsFile);
        foreach($pluginsFile as $val){
            if($val["id"] == $id){
                return $val;
            }
        }
    }
    public static function outputPluginsList(){
        $f = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/includes/modules/plugin/plugins.json");
        $pluginsFile = json_decode($f,true);
        $list = $pluginsFile;
        $html = "";
        foreach($list as $val){
            $html = $html . "<tr><td style=\"word-break: keep-all;\">".$val['name']."</td><td style=\"word-break: break-all;\">".$val["detail"]."</td><td style=\"word-break: keep-all;\">".$val["author"]."</td><td style=\"word-break: keep-all;\">".$val["config"]."</td><td style=\"word-break: keep-all;\">".master::getToggle($val['id'],$val["status"])."</td></tr>\n";
        }
        return $html;
    }
    public static function deplicateCheck($b, $s){
        foreach($b as $val){
            if($s["id"] == $val["id"]){
                if($s["status"] == $val["status"]){
                    return true;
                }else{
                    return 2;
                }
            }
        }
        return false;
    }
}
?>