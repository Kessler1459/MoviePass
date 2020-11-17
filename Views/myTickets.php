<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>
<main class="container">

    <?php
    if(empty($ticketsArray)){         
        echo "<div class='alert alert-danger'><strong>D:</strong> You don't have tickets yet</div>";     
    }
    else{
    for ($i=0; $i <count($ticketsArray); $i++) {
        $proj=$projs[$i];
        $ticket=$ticketsArray[$i]; ?>
        <div class="cajitajaja">
            <img class="qr" src="<?php echo $ticket->getQr() ?>">
            <div class="form-group centrados">
                <h2 class="title_"><?php echo $proj->getMovie()->getTitle() ?></h2>
                <strong><?php echo "Room: ".$proj->getRoom()->getDescription() ?></strong>
                <div><?php echo "Seat: ".$ticket->getNum() ?></div>
                <div><?php echo "Date: ".$proj->getDate() ?></div>
                <div><?php echo "Time: ".$proj->getHour() ?></div>
            </div>
        </div>
    <?php } 
    } ?>

</main>