<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>
<main class="container">
    <h1>Modify cinema</h1>
    <form action="<?php echo FRONT_ROOT ?>Room/modify" method="post" class="form-center">
        <div class="form-group text-center">
            
            <label for="capacity"><span>Capacity</span></label>
            <input type="number" name=capacity class= "input-cinema" value ="<?php echo $room->getCapacity()?>" required>
            <label for="ticketPrice"><span>Ticket Price</span></label>  
            <input type="number" name ="ticketPrice" class= "input-cinema" value="<?php echo $room->getTicketPrice()?>" required>
            <label for="description">Description</label>
            <input type="text" name="description" class= "input-cinema"  value="<?php echo $room->getDescription()?>" required>
      
            <input type="hidden" name="id" value=<?php echo $room->getId()?>>
            <input type="hidden" name="cinemaId" value=<?php echo $cinemaId?>>               
        </div>
        <button class="submit button-a" type="submit">Register</button>
    </form>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<script type='text/javascript' src="<?php echo JS_PATH ?>location_select.js"></script>
<?php require_once(VIEWS_PATH . "footer.php") ?>