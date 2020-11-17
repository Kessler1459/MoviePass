<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>
<main class="container">

    <?php
    foreach ($ticketsArray as  $ticket) { ?>
        <div class="cajitajaja">
            <img class="qr" src="<?php echo $ticket->getQr() ?>">
            <div class="form-group centrados">
                <h2 class="title_"><?php echo $proj->getMovie()->getTitle() ?></h2>
                <strong><?php echo "Room: ".$proj->getRoom()->getDescription() ?></strong>
                <span><?php echo "Seat: ".$ticket->getNum() ?></span>
                <span><?php echo "Date: ".$proj->getDate() ?></span>
                <span><?php echo "Time: ".$proj->getHour() ?></span>
            </div>
        </div>
    <?php } ?>

</main>