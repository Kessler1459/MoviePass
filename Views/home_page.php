<?php 
    require_once("header.php");
?>
<main>
  <div class="">
    <h1>Movies</h1>
       <div id="carouselExampleControls" class="carousel slide " data-ride="carousel">
  <div class="carousel-inner ">
    <div class="carousel-item active d-flex justify-content-center">
      <img src="<?php echo $cinemas[0]->getPoster()?>" class="d-inline w-25" alt="...">
      <img src="<?php echo $cinemas[1]->getPoster()?>" class="d-inline w-25" alt="...">
      <img src="<?php echo $cinemas[2]->getPoster()?>" class="d-inline w-25" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?php echo $cinemas[3]->getPoster()?>" class="d-inline w-25" alt="...">
      <img src="<?php echo $cinemas[4]->getPoster()?>" class="d-inline w-25" alt="...">
      <img src="<?php echo $cinemas[5]->getPoster()?>" class="d-inline w-25" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?php echo $cinemas[6]->getPoster()?>" class="d-inline w-25" alt="...">
      <img src="<?php echo $cinemas[7]->getPoster()?>" class="d-inline w-25" alt="...">
      <img src="<?php echo $cinemas[8]->getPoster()?>" class="d-inline w-25" alt="...">
    </div>
  </div>
  
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
    
  

</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>