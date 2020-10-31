$(document).ready(function(){
    $("#province").change(function(){
        var selectedProvince = $("#province option:selected");
        var id=selectedProvince.data("id");
        $.ajax({
            type: "POST",
            url: "/MoviePass/Location/updateCitiesSelect",
            data: { province : id },
            success:function(data){               
                $("#response").html("");
                var parse=JSON.parse(data, null, 2);
                $.each(parse,function(key,value){
                    $("#response").append("<option value="+value["id"]+">"+value["name"]+"</option>");
                })
            }
        });
    });
});