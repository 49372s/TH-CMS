<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/modules/markdown/Markdown.inc.php');
use Michelf\Markdown;
function getArticle($id){
    $pdo = cdb();
    $sql = "SELECT * from article";
    $res = $pdo->query($sql);
    foreach($res as $val){
        if($val[0]==$id){
            $html = file_get_contents($_SERVER['DOCUMENT_ROOT']."/content/data/blog_$id.html");
            return array("title"=>$val[1],"author"=>$val[2],"category"=>$val[3],"lastUpdate"=>$val[4],"html"=>$html);
        }
    }
}

function readArticles($id){
    $pdo = cdb();
    $sql = "SELECT * from article";
    $res = $pdo->query($sql);
    foreach($res as $val){
        if($val[0]==$id){
            $html = file_get_contents($_SERVER['DOCUMENT_ROOT']."/content/data/blog_$id.html");
            return Markdown::defaultTransform(latex($html));
        }
    }
}

function latestArticles($int = 5){
    $pdo = cdb();
    $sql = "SELECT * from article order by militime desc limit 3";
    $res = $pdo->query($sql);
    $html = "";
    foreach($res as $val){
        if(!APIAuthenticate($_COOKIE['token'])){
            APIResponse(false,"Authenticate failed");
        }
        $html = $html . '<a class="list-group-item" href="/article/?id='.$val[0].'"><div style="line-height: 2em;position: relative;"><span style="font-size: 2em">'.$val[1].'</span><span class="ms-3 badge bg-primary">'.$val[3].'</span></div><span class="text-secondary">最終更新: '.$val[4].'</span></a>';
    }
    return $html;
}

function latex($body){
    //LaTexを利用する(beta)
    $bcLatex = array();
    //LaTex構文の位置指定文字を指定する
    $latex_start = '$sl$';
    $latex_final = '$el$';
    //latex構文位置が複数あることを考慮し、分割する(終了位置分割)
    $latex_final_position = explode($latex_final, $body);
    foreach($latex_final_position as $column){
        array_push($bcLatex,explode($latex_start, $column));
    }

    //print_r($bcLatex);
    $body = "";
    foreach($bcLatex as $row){
        if(count($row)===1){
            $body = $body . $row[0];
            continue;
        }
        $ch = curl_init();
        $row[1] = str_replace(PHP_EOL,"",$row[1]);
        curl_setopt($ch, CURLOPT_URL, "https://api.tkngh.jp/latex2html");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("latexString"=>$row[1])));
        $headers = [
            'Content-Type: application/json',
            'Accept-Charset: UTF-8',
        ];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $converted = curl_exec($ch);
        $body = $body . $row[0] . json_decode($converted,true)["html"];
    }
    return $body;
}
?>