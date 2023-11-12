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
        dei.innerHTML = dei.innerHTML + "<a href=\""+element.url+"\" class=\"list-group-item\">"+element.title+"<span class=\"ms-3 badge bg-primary\">"+element.category+"</span><br>更新: "+element.lastupdate+"</a>"
    });
}