<?php 
    include_once('header.php');
    include_once('footer.php');
?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php $movie->getTitle()?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe width="720" height="1280" src="https://www.youtube.com/embed/<?php echo $movie->getVideo(); ?>">
            </iframe>
      </div>
    </div>
  </div>
</div>
<main>
    <section id="movie-details">
        <div id="title">
            <?php echo "<h2>". $movie->getTitle()."</h2>" ?>
        </div>
        <div id="cuerpo">
            <div id='#right_info_container'>
                <figure class="figure">
                            <img class="figure-img img-fluid rounded" src="<?php echo "https://image.tmdb.org/t/p/w500" . $value->getPoster() ?>" width="60%">
                            <figcaption class="figure-caption"><?php echo $value->getTitle() ?></figcaption>
                </figure>
            </div>
            <div id="#left_info_container">
                <p id="lenght_info"> <?php echo $movie->getLenght();?></p>
                <p id="synopsis"> <?php echo $movie->getSynopsis();?></p>
                <p id="genre">
                    <?php 
                        foreach($movie->getGenres() as $key -> $value)
                        {
                            echo "<span>". $value->getName() . "</span>";
                        }
                    ?>
                </p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Ver Trailer
                </button>
            </div>
        </div>
    </section>    