function listing(id){
    $.post("/api/articles/?mode=1",(data)=>{
        if(data.result==true){
            buildLinks(id, data.data);
        }
    })
}

function listingByCategories(id, category){
    $.post("/api/articles/search/",{"mode":"1","c":category},(data)=>{
        if(data.result==true){
            buildLinks(id, data.data);
        }else if(data.result == false && data.data == "INVALID"){
            document.getElementById(id).innerHTML = "<div class=\"list-group-item\">プラグインが無効のため、利用できません。管理者にお問い合わせください。</div>"
        }
    })
}

function buildLinks(elementId, arr){
    dei = document.getElementById(elementId);
    arr.forEach(element => {
        dei.innerHTML = dei.innerHTML + "<div class=\"list-group-item\"><a href=\""+element.url+"\">"+element.title+"</a><a class=\"ms-3 badge bg-primary\" href=\"/search/?c="+element.category+"\" style=\"text-decoration: none;\">"+element.category+"</a><br>更新: "+element.lastupdate+"</div>"
    });
}
