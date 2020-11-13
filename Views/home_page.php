<?php 
require_once(VIEWS_PATH."header.php");
require_once(VIEWS_PATH."nav.php");
?>
<main class="container">
  <div>
  
    <h1 class="title_">Home</h1>
    <div id="carouselExampleControls" class="carousel slide  justify-content-center d-flex" data-ride="carousel">
      <div class="carousel-inner">

        <div class="carousel-item active">
            <iframe width="1100" height="600"
                src="<?php echo 'https://www.youtube.com/embed/'.$projs[0]->getMovie()->getVideo()?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen >
            </iframe>
        </div>
        <?php 
        $i=0;
        while($i< count($projs)&& $i<5){ ?>
        <div class="carousel-item">
            <iframe width="1100" height="600"
                src="<?php echo 'https://www.youtube.com/embed/'.$projs[$i]->getMovie()->getVideo()?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen >
            </iframe>
        </div>
        <?php $i++;} ?>     
        
      </div>
    
      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>


  </div>

</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>

