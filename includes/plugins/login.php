<?php
function getSHA($str){
    return hash("sha3-512",$str);
}

function loginCheck(){
    if(empty($_COOKIE['token'])){
        return false;
    }
    return APIAuthenticate($_COOKIE['token']);
}

function loginRedirect(){
    if(!loginCheck()){
        http_response_code(401);
        header('Location: ./login.php');
        exit();
    }
}

function AdminAuthenticate($user,$pass){
    $pdo = cdb();
    $res = $pdo->query("SELECT * from user");
    foreach($res as $val){
        if($val[1] == $user && $val[4]==getSHA($pass) && $val[6]==3){
            setcookie("token",md5(date("Ym").$val[0].$val[1]),time() + 60 * 60 * 24 * 30, "/", null, true);
            http_response_code(200);
            header('Location: /dashboard');
            exit();
        }
    }
    APIResponse(false,"Login authenticate is failed.");
}

function APIAuthenticate($token){
    $pdo = cdb();
    $res = $pdo->query("SELECT * from user");
    foreach($res as $val){
        if($token == md5(date("Ym").$val[0].$val[1])){
            return true;
        }
    }
    return false;
}
?>