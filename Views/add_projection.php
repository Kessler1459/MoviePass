<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>
<main class="container_movies">
    <h1>Movies</h1>

    <section>
        <div>
            <div class="dropdown">
                    <button class="button-a dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Genres
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php
                        foreach ($genres as $gen) {
                            $g = $gen->getName() ?>
                            <label for="<?php echo $gen->getId() ?>"><?php echo $g ?>
                            <input class="GenreChk" type='checkbox' name="genres[]" id="<?php echo $gen->getId() ?>" value="<?php echo $g ?>">
                        </label>
                        <?php } ?>
                        <input type="hidden" name="roomId" value="<?php echo $roomId ?>">
                    </div>
            </div> 
        </div>

        <button id="filerButton" type="button" class="button-a">Filter</button>
        <button type="button" id="resetBtn" class="button-a">Clear</button>

        <input id="searchInput" class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" name="search">
        
    </section>

    <div class="custom-scrollbar table-wrapper-scroll-y">
        <div class="row" id="moviesResponse">
            <?php
            foreach ($movieList as  $value) {?>
                <div class="col-md-3">
                    <button type="button" class="btn"  onClick="dataChange(<?php echo "'" . $value->getPoster() . "','" . addslashes($value->getTitle()) . "','" . addslashes($value->getSynopsis()). "','" . $value->getId() . "'" ?>);" data-id="<?php echo $value->getId() ?>" data-toggle="modal" data-target=".movie">

                        <figure class="figure">
                            <img class="figure-img img-fluid rounded" src="<?php echo "https://image.tmdb.org/t/p/w500" . $value->getPoster() ?>" width="60%">
                            <figcaption class="figure-caption"><?php echo $value->getTitle() ?></figcaption>
                        </figure>

                    </button>
                </div>
                <br>

            <?php } ?>
        </div>
    </div>
    <form action="<?php echo FRONT_ROOT ?>Projection/updateMoviesList" method="post">
        <input type="hidden" value="<?php echo $roomId ?>" name="hehe">
        <button class="button-a" type="submit">Update movies database</button>
    </form>
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
                    <form action="<?php echo FRONT_ROOT ?>Projection/add" method="post">
                        <input type="hidden" name="roomId" value="<?php echo $roomId ?>">
                        <input type="hidden" name="movie_id" id="projection_movie" value="">
                        <input type="date" name="projection_date" id="projection_date" min=<?php echo date("yy-m-d") ?> value=<?php echo date("yy-m-d") ?> required>
                        <input type="time" name="projection_time" id="projection_time" required>
                        <button type="submit" class="button-a">Save Projection</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<script src="<?php echo JS_PATH ?>moviesFilter.js"></script>
<script src="<?php echo JS_PATH ?>moviesSearch.js"></script>
<script src="<?php echo JS_PATH ?>dataChange.js"></script>
<?php require_once(VIEWS_PATH . "footer.php") ?>