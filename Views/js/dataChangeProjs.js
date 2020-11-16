function dataChange(imageIncome, titleIncome, SynIncome, movieId) {
    document.getElementById("imgModal").src = "https://image.tmdb.org/t/p/original" + imageIncome;
    document.getElementById("modalTitle").innerHTML = titleIncome;
    document.getElementById("modalSyn").innerHTML = SynIncome;
    document.getElementById("movieIdInput").value = movieId;
    document.getElementById("cityId").value=document.getElementById("response").value;
}