$(document).ready(function(){
    $("#filerButton").on("click",function(){
        var cityId=$("#response").val();
        var date = $("#projection_date").val();
        var genresChk = []; 
        $("input[name='genres[]']:checked").each(function ()
        {
            genresChk.push($(this).val());
        });
        $.ajax({
            type: "GET",
            url: "/MoviePass/Projection/projectionFilters",
            data: {
                "city" : cityId,
                "date" : date,
                "genr" : JSON.stringify(genresChk)
            },
            success:function(data){
                $("#moviesResponse").html("");
                var parse=JSON.parse(data,null,2);
                $.each(parse,function(key,value){
                    var str="<div class='col-md-3'><button type='button' class='btn' onClick=\"dataChange('"+value["movie"]["poster"]+"','"+value["movie"]["title"]+"','"+value["movie"]["synopsis"]+"','"+value["movie"]["id"]+"')\" data-id=\""+value["movie"]["id"]+"\" data-toggle='modal' data-target='.movie' >";
                    str+="<figure class='figure'><img class='figure-img img-fluid rounded' src=\"https://image.tmdb.org/t/p/w154"+value["movie"]["poster"]+"\" width=60% ><figcaption class='figure-caption'>"+value["movie"]["title"]+"</figcaption></figure>";
                    str+="</button></div>";
                    $("#moviesResponse").append(str);         
                })
            }
        });
    });
    
    $("#resetBtn").on("click", function () {
        $("#province")[0].selectedIndex = 0;
        $("#response")[0].selectedIndex = 0;
        $("#projection_date").val("");
        $(".GenreChk").prop("checked",false);
        $('.multiselct').html("");
        $(".hida").show();
    });
    
});
