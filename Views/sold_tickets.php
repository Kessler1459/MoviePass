<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>
<main class="container">

    <?php
    foreach ($ticketsArray as  $ticket) { ?>
        <div class="cajitajaja">
            <img src="<?php echo $ticket->getQr() ?>" width=200>
        </div>
    <?php } ?>

</main>