<?php 
require_once(VIEWS_PATH."header.php");
require_once(VIEWS_PATH."nav.php");
?>
<main class="container_movies">
    <h1>Movies</h1>
    <section>
        <div>
            <div class="dropdown">
                <form action="<?php echo FRONT_ROOT ?>Movie/showMoviesByGenre" method="GET">
                    <button class="button-a dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Genres
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php
                        foreach ($genres as $gen) {
                            $g = $gen->getName() ?>
                            <label for="<?php echo $g ?>"><?php echo $g ?>
                                <input type='checkbox' name="genres[]" id="<?php echo $g ?>" value="<?php echo $g ?>">
                            </label>
                        <?php } ?>
                    </div>
            </div>
            <button type="submit" class="button-a">Filter</button>
            </form>
        </div>

        <form class="form-inline " method="GET" action="<?php echo FRONT_ROOT ?>Movie/showMoviesSearch">
            <input class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" name="search">
        </form>
    </section>
    <div class="custom-scrollbar table-wrapper-scroll-y">
        <div class="row">
            <?php
            foreach ($movieList as $key => $value) { ?>
                <div class="col-md-3">
                    <button type="button" class="btn" onClick="dataChange(<?php echo "'" . $value->getPoster() . "','" . $value->getTitle() . "','" . $value->getSynopsis() . "','" . $value->getId() ."'"?>)" data-id="<?php echo $value->getId() ?>" data-toggle="modal" data-target=".movie">

                        <figure class="figure">
                            <img class="figure-img img-fluid rounded" src="<?php echo "https://image.tmdb.org/t/p/w500".$value->getPoster() ?>" width="60%">
                            <figcaption class="figure-caption"><?php echo $value->getTitle() ?></figcaption>
                        </figure>

                    </button>
                </div>
                <br>

            <?php } ?>

            



        </div>
    </div>
</main>
<div class="modal fade movie" id="" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="media">
                            <img id="imgModal" class="align-self-center mr-3" src="" width="70%">
                            <div class="media-body">
                                <h5 class="mt-0" id="modalTitle"></h5>

                                <p id="modalSyn"></p>
                                <br><br>
                                <form action="<?php echo FRONT_ROOT ?>Projection/" method="post">
                                    <!-- Acá tiene que haber una función JS que averigue cuales son las funciones activas de esta película. Más tarde lo hago -->
                                    <input type="hidden" name="movie_id" id="projection_movie" value="">
                                    <button type="submit" class="btn btn-success">Buy</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<script>
    function dataChange(imageIncome, titleIncome, SynIncome, movieId) {

        document.getElementById("imgModal").src = "https://image.tmdb.org/t/p/w500" + imageIncome;
        document.getElementById("modalTitle").innerHTML = titleIncome;
        document.getElementById("modalSyn").innerHTML = SynIncome; 
        document.getElementById("projection_movie").value = movieId;
        for (var i = 0; i < <?php echo count($projections) ?> i++)
        {
            
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<?php require_once(VIEWS_PATH."footer.php")?>