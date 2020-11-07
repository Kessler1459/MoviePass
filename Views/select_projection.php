<?php 
    include_once('movie_details.php');
    include_once('select_city');
?>

<section>
    <article>
        <?php 
            foreach ($cinemasXrooms as $cinema => $rooms) {?>
                <form action="<?php echo FRONT_ROOT?>Buy/addDetailsMovie" method="get" id="<?php $cinema->getId()?>">
                    <div>
                        <p><?php $cinema->getName()?></p>
                        <p><?php $cinema->getAddres()?></p>
                        
                        <input type="hidden" name="cinemaId" value="<?php echo $cinema->getId()?>">
                        <input type="hidden" name="movieId" value="<?php echo $movie->getId()?>">
                    </div>
                    <div>
                        <?php foreach ($rooms as $room => $projections) { ?>
                            <p> <?php $actualRoom->getDescription()?> </p>
                            <p> <?php $actualRoom->getPrice()?> </p>
                            <p> <?php $actualRoom->getTicketPrice()?> </p>
                            <input type="hidden" name="roomId" value="<?php $room->getId()?>">
                            <?php foreach ($projections as $key => $projection){?>
                                <div>
                                        <a href="#" onClick="button-press(<?php echo $cinema->getId() ?>)">
                                            <span> <?php $projection->getDate() ?> </span>
                                            <span> <?php $projection->getHour() ?> </span>
                                        </a>
                                        <input type="hidden" name="projectionId" value="<?php $projection->getId()?>">
                                    
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </form>
            <?php } 
        ?>
    </article>
</section>
<script>
    function button-press(cinemaId)
    {
        var form = document.getElementById("cinemaId");
        form.submit();
    }
</script>