<?php 
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");
?>
<main class="container">
    
    
    <div class="container_movies">
        <div class="row" id="moviesResponse">
            

                <div class="col-md-2">

                    <?php
                    foreach ($ticketsArray as  $ticket) { ?>
                        <figure class="figure">
                            <img class="figure-img img-fluid rounded" src="<?php echo $ticket->getQr()?>"  width=50>
                            <figcaption class="figure-caption"><?php echo $ticket->getId()?></figcaption>
                        </figure>   
                        <br>
                    </button>
                </div>
                

            <?php } ?>
        </div>
    </div>
</main>