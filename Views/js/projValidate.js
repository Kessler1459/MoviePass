$(document).ready(function () {
    $('#submitProj').click(function (e) {
        e.preventDefault();
        var roomId = $("#RoomIdInput").val();
        var movieId = $("#movieIdInput").val();
        var projDate = $("#projDateInput").val();
        var projTime = $("#projTimeInput").val();
        $.ajax({
            type: "GET",
            url: "/MoviePass/Projection/validateProjection",
            data:{ "roomId": roomId, "movieId": movieId, "projDate": projDate, "projTime": projTime },
            success: function (dat) {
                dat = JSON.parse(dat, null, 2);
                if (dat["msg"] == "Ok"){
                    $("#addProjForm").submit();
                } else {
                    $("#modal-msg").html(dat["msg"]);
                    $('#staticBackdrop').modal('show');
                }
            }
        });
    });
});