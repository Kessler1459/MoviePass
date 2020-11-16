$(document).ready(function (){
    $("#quanty").change(function(){
        var price=$("#tcPrice").html();
        var quant=$("#quanty").val();
        $("#resultPrice").val(price*quant);
        
    })
});