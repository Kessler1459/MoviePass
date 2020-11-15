<?php 
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php"); ?>
<main class="container">
    
    <?php 
    echo "<h3 class='title_'>Error</h3>";
    echo "<br>$message";
    ?>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<?php require_once(VIEWS_PATH . "footer.php") ?>
