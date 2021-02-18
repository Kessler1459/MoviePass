<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>
<main class="container">
    <h1 class="title_">Movies</h1>
    
    
    <section class="movie_filter">



        <select name="province" class="form-control" id="province" required>
            <option value="" disabled selected>Province</option>
            <?php foreach ($provinces as $value) {
                echo "<option data-id=" . $value->getId() . " value=" . $value->getId() . ">" . $value->getName() . "</option>";
            } ?>
        </select>
        <select name="city" class="form-control" id="response" required>
            <option value="" disabled selected>City</option>
        </select>
        <input class="form-control" type="date" name="projection_date" id="projection_date" min=<?php echo date("Y-m-d") ?> value="" required>
        <dl class="dropdown button-a">
        <dt>
            <a href="#">
                <span class="hida">Genres</span>
                <p class="multiselct"></p>
            </a>
        </dt>
        <dd>
            <div class="mutliSelect">
                <ul>
                    <?php
                    foreach ($genres as $gen) {
                        $g = $gen->getName() ?>
                        <label for="<?php echo $gen->getId() ?>"><?php echo $g ?>
                            <input class="GenreChk" type='checkbox' name="genres[]" id="<?php echo $gen->getId() ?>" value="<?php echo $g ?>">
                        </label>
                    <?php } ?>
                </ul>
            </div>
        </dd>
    </dl>
        <button id="filerButton" type="button" class="button-a">Filter</button>
        <button type="button" id="resetBtn" class="button-a">Clear</button>


    </section>
    
    <input id="searchInput" class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" name="search">
    <div class="container_movies">
        <div class="row" id="moviesResponse">
            <?php
            foreach ($projectionList as  $proj) {
                $movie = $proj->getMovie(); ?>
                <div class="col-md-2">
                    <button type="button" class="btn" onClick="dataChange(<?php echo "'" . $movie->getPoster() . "','" . addslashes($movie->getTitle()) . "','" . addslashes($movie->getSynopsis()) . "','" . $movie->getId() . "'" ?>)" data-id="<?php echo $movie->getId() ?>" data-toggle="modal" data-target=".movie">

                        <figure class="figure">
                            <img class="figure-img img-fluid rounded" src="<?php echo "https://image.tmdb.org/t/p/w154" . $movie->getPoster() ?>" width=150>
                            <figcaption class="figure-caption"><?php echo $movie->getTitle() ?></figcaption>
                        </figure>

                    </button>
                </div>
                <br>

            <?php } ?>
        </div>
    </div>
</main>

<!-- modal portada -->

<div class="modal fade movie" id="" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-c">
            <div class="media">
                <img id="imgModal" class="align-self-center mr-3" src="" width="60%">
                <div class="media-body">
                    <br>
                    <h5 class="mt-0" id="modalTitle"></h5>
                        
                    <p id="modalSyn" class="movie_descript"></p>
                    <br><br>
                <?php if (isset($_SESSION['name'])) { ?>
                    <form action="<?php echo FRONT_ROOT ?>Projection/selectProjection" method="get">
                        <input type="hidden"id="cityId" name="cityId">
                        <input type="hidden" id="movieIdInput" name="movieIdModal">
                        <button type="submit" class="button-a">Choose cinema</button>
                    </form>
                <?php }else{ ?>
                    <form action="<?php echo FRONT_ROOT ?>Home/logIn" method="get">
                        <button type="submit" class="button-a">LogIn</button>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<script type='text/javascript' src="<?php echo JS_PATH ?>location_select.js"></script>
<script src="<?php echo JS_PATH ?>projFilter.js"></script>
<script src="<?php echo JS_PATH ?>dataChangeProjs.js"></script>
<script src="<?php echo JS_PATH ?>projSearch.js"></script>
<script src="<?php echo JS_PATH ?>genres_dropdown.js"></script>
<?php require_once(VIEWS_PATH . "footer.php") ?>