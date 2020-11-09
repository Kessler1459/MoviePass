$(document).ready(function(){
    $("#filerButton").on("click",function(){
        var genresChk = []; 
        $("input[name='genres[]']:checked").each(function ()
        {
            genresChk.push($(this).val());
        });
        $.ajax({
            type: "GET",
            url: "/MoviePass/Projection/addFromListFiltered",
            data: {
                "genr" : JSON.stringify(genresChk)
            },
            success:function(data){
                $("#moviesResponse").html("");
                var parse=JSON.parse(data,null,2);
                $.each(parse,function(key,value){
                    var str="<div class='col-md-3'><button type='button' class='btn' onClick=\"dataChange('"+value["poster"]+"','"+value["title"]+"','"+value["synopsis"]+"','"+value["id"]+"')\" data-id=\""+value["id"]+"\" data-toggle='modal' data-target='.movie' >";
                    str+="<figure class='figure'><img class='figure-img img-fluid rounded' src=\"https://image.tmdb.org/t/p/w500"+value["poster"]+"\" width=60% ><figcaption class='figure-caption'>"+value["title"]+"</figcaption></figure>";
                    str+="</button></div>";
                    $("#moviesResponse").append(str);
                })
            }
        });
    });
    
    $("#resetBtn").on("click", function () {
        $(".GenreChk").prop("checked",false);
    });
    
});