$(document).ready(function (){
    $("#btn").on("click",function(){
        var movieID=$("#movieID").val();
        var firstDate=$("#firstDate").val();
        var secondDate=$("#secondDate").val();
        $.ajax({
            type: "GET",
            url: "/MoviePass/Purchase/totalSoldByMovieJson",
            data:{ "movieID": movieID, "firstDate": firstDate, "secondDate": secondDate },
            success:function(dato){
                var parse=JSON.parse(dato, null, 2);
                $("#result").html("$"+parse);
            }
        })
    });
});