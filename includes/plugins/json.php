<?php
function APIResponse($flug=false,$data=null){
    header('Content-Type: application/json;charset=UTF-8;');
    echo json_encode(array("result"=>$flug,"data"=>$data));
    exit();
}
?>