<?php
function APIRequest($host,$api,$payload = array()){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,"https://".$host."/api/$api");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $res = curl_exec($ch);
    curl_close($ch);

    $res = json_decode($res, true);
    return $res;
}

function checkAuthenticateMisskey($uid){
    $pdo = cdb();
    $res = $pdo->query("SELECT * from user");
    foreach($res as $val){
        if($uid==$val[0]){
            if($val[5]=="null"){
                return false;
            }else{
                return true;
            }
        }
    }
    return false;
}
?>