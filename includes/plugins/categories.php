<?php
function getCategory($mode=0,$q=null){
    if($mode==0){
        $pdo = cdb();
        $res = $pdo->query("SELECT * from category");
        foreach($res as $val){
            //IDあるいはカテゴリー名で検索する。よってカテゴリー名の重複は不可能。
            if($val[0] == $q || $val[1] == $q){
                return true;
            }
        }
        return false;
    }elseif($mode==1){
        $pdo = cdb();
        $res = $pdo->query("SELECT * from category");
        $html = "";
        foreach($res as $val){
            $html = $html . '<option value="'.$val[0].'">'.$val[1].'</option>'."\n";
        }
        APIResponse(true,$html);
    }
}

function searchCat($id){
    $pdo = cdb();
    $res = $pdo->query("SELECT * from category");
    $category = array();
    foreach($res as $val){
        if($id == $val[0]){
            return $val[1];
        }
    }
    return false;
}
?>