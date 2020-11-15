$(document).ready(function () {
    $("#searchInput").keypress(function (e) {
        if (e.which == 13) { //si apreta enter hehe
            var search=$("#searchInput").val();
            $.ajax({
                type: "GET",
                url: "/MoviePass/Projection/showProjectionSearch",
                data: {
                    "search": search
                },
                success: function (data) {
                    $("#moviesResponse").html("");
                    var parse = JSON.parse(data, null, 2);
                    $.each(parse, function (key, value) {
                        var str = "<div class='col-md-3'><button type='button' class='btn' onClick=\"dataChange('" + value["movie"]["poster"] + "','" + value["movie"]["title"] + "','" + value["movie"]["synopsis"] + "','"+value["movie"]["id"]+"')\" data-id=\"" + value["movie"]["id"] + "\" data-toggle='modal' data-target='.movie' >";
                        str += "<figure class='figure'><img class='figure-img img-fluid rounded' src=\"https://image.tmdb.org/t/p/w154" + value["movie"]["poster"] + "\" width=60% ><figcaption class='figure-caption'>" + value["movie"]["title"] + "</figcaption></figure>";
                        str += "</button></div>";
                        $("#moviesResponse").append(str);
                    })
                }
            });
        }

    });
});