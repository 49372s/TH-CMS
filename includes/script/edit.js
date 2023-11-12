// Takanashi CMS Edit-article Script File
// (C)2016-2023 Takanashi.
// -------------------------------
// Using librarys
// -jQuery
// -Bootstrap
// -------------------------------
// version 1.04

//新規投稿ページ
if(document.getElementById('new-article')!=undefined){
    const form = document.getElementById('new-article');
    form.onsubmit = (e)=>{
        e.preventDefault();
        //処理に時間がかかることが予想されるため、Progress Barを配置する。
        document.getElementById('loading').classList.add('show');
        const form = document.getElementById('new-article');
        //Authorを取得する。
        $.post("/api/users/get/",(data)=>{
            if(data.result==true){
                $.post("/api/articles/post/",{"author":data.data.id,"category":form.cat.value,"title":form.title.value,"body":form.body.value,"mode":form.autoPost.checked,"token":data.data.mi,"instance":data.data.url},(res)=>{
                    if(res.result==true){
                        document.getElementById('loading').classList.remove('show');
                        window.alert('記事を投稿しました。');
                        location.href = "/dashboard/list/article.php";
                    }
                }).fail(
                    ()=>{
                        window.alert("APIの実行に失敗しました。");
                        document.getElementById('loading').classList.remove('show');
                    }
                )
            }
        })
    }
    window.onload = function(){
        $.post("/api/admin/category/get/",(data)=>{
            if(data.result==true){
                document.getElementById('datalistOptions').innerHTML = data.data;
            }
        })
    }
}

if(document.getElementById('edit-article')!=undefined){
    const form = document.getElementById('edit-article');
    form.onsubmit = (e)=>{
        e.preventDefault();
        //処理に時間がかかることが予想されるため、Progress Barを配置する。
        document.getElementById('loading').classList.add('show');
        const form = document.getElementById('edit-article');
        //Authorを取得する。
        $.post("/api/users/get/",(data)=>{
            if(data.result==true){
                $.post("/api/articles/edit/",{"id":form.id.value,"category":form.cat.value,"title":form.title.value,"body":form.body.value,"mode":form.autoPost.checked,"token":data.data.mi,"instance":data.data.url},(res)=>{
                    if(res.result==true){
                        document.getElementById('loading').classList.remove('show');
                        window.alert('記事を編集しました。');
                        location.href = "/dashboard/list/article.php";
                    }
                }).fail(
                    ()=>{
                        window.alert("APIの実行に失敗しました。");
                        document.getElementById('loading').classList.remove('show');
                    }
                )
            }
        })
    }
    window.onload = function(){
        $.post("/api/admin/category/get/",(data)=>{
            if(data.result==true){
                document.getElementById('datalistOptions').innerHTML = data.data;
            }
        })
    }
}

//記事一覧
if(document.getElementById('search-article-edit')!=undefined){
    const search = document.getElementById('search-article-edit');
    const control = document.getElementById('control-article');
    window.onload = ()=>{
        getArticle();
    }
    search.onsubmit = (e)=>{
        e.preventDefault();
        if(search.ast.value == undefined || search.ast.value == null || search.ast.value == ""){
            getArticle();
        }else{
            getArticle(search.ast.value);
        }
    }
    control.onsubmit = (e)=>{
        e.preventDefault();
    }
}

//カテゴリー一覧
if(document.getElementById('search-category-edit')!=undefined){
    const search = document.getElementById('search-category-edit');
    const control = document.getElementById('control-category');
    window.onload = ()=>{
        getCategory();
    }
    search.onsubmit = (e)=>{
        e.preventDefault();
        if(search.act.value == undefined || search.act.value == null || search.act.value == ""){
            getCategory();
        }else{
            getCategory(search.act.value);
        }
    }
    control.onsubmit = (e)=>{
        e.preventDefault();
    }
}


function getArticle(q = ""){
    toggleLoading()
    $.post("/api/articles/",{"q":q},(data)=>{
        if(data.result==true){
            document.getElementById('article-list').innerHTML = data.data;
            toggleLoading(false);
        }
    });
}

function getArticleByName(title){
    toggleLoading();
    $.post("/api/admin/get/detail/",{"title":title},(data)=>{
        if(data.result==true){
            document.getElementById('article-list').innerHTML = data.data;
            toggleLoading(false);
        }
    });
}

function requestDelete(id){
    toggleLoading()
    $.post("/api/articles/delete/",{"id":id},(data)=>{
        if(data.result==true){
            window.alert("記事の削除に成功しました。");
            document.getElementById('search-article-edit').ast.value = "";
            getArticle();
            toggleLoading(false);
        }
    })
}

function toggleLoading(flug=true){
    if(flug == true){
        document.getElementById('loading').classList.add('show');
    }else{
        document.getElementById('loading').classList.remove('show');
    }
}

function view(id){
    window.open("/view/?id="+id);
}

function getCategory(q = ""){
    toggleLoading()
    $.post("/api/categories/",{"q":q},(data)=>{
        if(data.result==true){
            document.getElementById('category-list').innerHTML = data.data;
            toggleLoading(false);
        }
    });
}

function getCategoryByName(title){
    toggleLoading();
    $.post("/api/admin/category/get/dashboard/",{"title":title},(data)=>{
        if(data.result==true){
            document.getElementById('category-list').innerHTML = data.data;
            toggleLoading(false);
        }
    });
}

function requestDeleteCat(id){
    toggleLoading()
    $.post("/api/categories/delete/",{"id":id},(data)=>{
        if(data.result==true){
            window.alert("カテゴリの削除","カテゴリの削除に成功しました。");
            document.getElementById('search-category-edit').act.value = "";
            getCategory();
            toggleLoading(false);
        }
    })
}

if(document.getElementById('add-category')!=undefined){
    const form = document.getElementById('add-category');
    form.onsubmit = (e)=>{
        e.preventDefault();
        $.post("/api/categories/add/",{"name":form.category.value},(data)=>{
            if(data.result==true){
                window.alert("カテゴリーを追加しました。");
                location.reload();
            }else{
                window.alert(data.data);
            }
        })
    }
}