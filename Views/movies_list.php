<main class="container">
    <h1>Movies</h1>
    <section>
        <div class="dropdown">
            <form action="<?php echo FRONT_ROOT ?>Movie/showMoviesByGenre" method="GET">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <form class="form-inline d-flex justify-content-center md-form form-sm mt-0" method="GET" action="<?php echo FRONT_ROOT ?>Movie/showMoviesSearch">
            <i class="fas fa-search" aria-hidden="true"></i>
            <input class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" name="search">
        </form>
    </section>
    <div class="custom-scrollbar table-wrapper-scroll-y">
        <div class="row">
            <?php
            foreach ($movies as $key => $value) { ?>
                <div class="col-md-3">
                    <button type="button" class="btn" onClick="dataChange(<?php echo "'" . $value->getPoster() . "','" . $value->getTitle() . "','" . $value->getSynopsis() . "'" ?>)" data-id="<?php echo $value->getId() ?>" data-toggle="modal" data-target=".movie">

                        <figure class="figure">
                            <img class="figure-img img-fluid rounded" src="<?php echo $value->getPoster() ?>" width="60%">
                            <figcaption class="figure-caption"><?php echo $value->getTitle() ?></figcaption>
                        </figure>

                    </button>
                </div>
                <br>

            <?php } ?>

            <div class="modal fade movie" id="" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="media">
                            <img id="imgModal" class="align-self-center mr-3" src="" width="70%">
                            <div class="media-body">
                                <h5 class="mt-0" id="modalTitle"></h5>

                                <p id="modalSyn"></p>
                                <br><br>
                                <button type="submit" class="btn btn-success">Buy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</main>

<script>
    function dataChange(imageIncome, titleIncome, SynIncome) {

        document.getElementById("imgModal").src = imageIncome;
        document.getElementById("modalTitle").innerHTML = titleIncome;
        document.getElementById("modalSyn").innerHTML = SynIncome;

    }
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>