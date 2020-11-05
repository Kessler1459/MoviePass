$(document).ready(function(){
    $("#projection_date").on("change",function(){
        var date = $("#projection_date").val();
        $.ajax({
            type: "GET",
            url: "/MoviePass/Projection/showProjectionDate",
            data: {data : date },
        });
    });
});