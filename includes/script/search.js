function getArticle(q = "",c="", id = "result"){
    $.post("/api/articles/search/",{"q":q,"c":c},(data)=>{
        if(data.result==true){
            document.getElementById(id).innerHTML = data.data;
        }
    });
}

function searchArticles(elementId, query = "", category = ""){
    getArticle(query, category, elementId);
}