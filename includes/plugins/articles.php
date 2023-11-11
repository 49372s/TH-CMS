<?php
function getArticle($id){
    $pdo = cdb();
    $sql = "SELECT * from article";
    $res = $pdo->query($sql);
    foreach($res as $val){
        if($val[0]==$id){
            $html = file_get_contents($_SERVER['DOCUMENT_ROOT']."/content/blog/$id.html");
            return array("title"=>$val[1],"author"=>$val[2],"category"=>$val[3],"lastUpdate"=>$val[4],"html"=>$html);
        }
    }
}
?>