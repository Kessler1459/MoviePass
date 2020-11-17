$(document).ready(function (){
    $("#btn").on("click",function(){
        var cinemaId=$("#cinemaId").val();
        var firstDate=$("#firstDate").val();
        var secondDate=$("#secondDate").val();
        $.ajax({
            type: "GET",
            url: "/MoviePass/Purchase/totalSoldByCinemaJson",
            data:{ "cinId": cinemaId, "firstDate": firstDate, "secondDate": secondDate },
            success:function(dato){
                var parse=JSON.parse(dato, null, 2);
                $("#result").html("$"+parse);
            }
        })
    });
});