function listing(id){
    $.post("/api/articles/?mode=1",(data)=>{
        if(data.result==true){
            buildLinks(id, data.data);
        }
    })
}

function buildLinks(elementId, arr){
    dei = document.getElementById(elementId);
    arr.forEach(element => {
        dei.innerHTML = dei.innerHTML + "<div class=\"list-group-item\"><a href=\""+element.url+"\">"+element.title+"</a><a class=\"ms-3 badge bg-primary\" href=\"/search/?c="+element.category+"\" style=\"text-decoration: none;\">"+element.category+"</a><br>更新: "+element.lastupdate+"</div>"
    });
}
