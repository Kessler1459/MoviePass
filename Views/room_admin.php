<?php 
require_once(VIEWS_PATH."header.php");
require_once(VIEWS_PATH."nav.php");
?>
<main class="container">
    <h1>Rooms</h1>
    <div class="custom-scrollbar table-wrapper-scroll-y">
        <input type="text" id="input" onkeyup="myFunction()" class="form-control" placeholder="Search for names..">
        <table id="table" class="table text-center table-hover table-striped table-cinemas" >
            <thead>
                <tr class="th-pointer">
                    <th class="th-pointer">Id</th>
                  
                    <th>Capacity</th>
                    <th>Ticket Price</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room) {
                    ?>
                    <tr>
                   
                        <td><?php echo $room->getId()?></td>
                        <td><?php echo $room->getCapacity()?></td>
                        <td><?php echo "$". $room->getTicketPrice()?></td>
                        <td><?php echo $room->getDescription()?></td>
                        <td>
                            <form action="<?php echo FRONT_ROOT?>Projection/showProjections" method="POST">
                            <button name ="id" class="btn" type="submit" value="<?php echo $room->getId()?>" >Show Projections  
                            </form> 
                            </button>
                        </td>
                        <td>
                            <form action="<?php echo FRONT_ROOT ?>Room/showModifyRoom" method="post">
                                <input type="hidden" name="id" value =<?php echo $room->getId()?>>
                                <input type="hidden" name="cinemaId" value=<?php echo $cinemaId?>>
                                <button type="submit" class="btn" >
                                <img src="/MoviePass/Views/img/wrench-4x.png" alt="trash_icon">     
                            </button>
                            </form>
                        </td>
                        <td>
                        </td>
                        <td>
                            <form action="<?php echo FRONT_ROOT ?>Room/remove" method="post">
                              
                                <input type="hidden" name="id" value=<?php echo $room->getId()?>>
                                <input type="hidden" name="cinemaId" value=<?php echo $cinemaId?>>
                                <button type="submit" class="btn">
                                <img src="/MoviePass/Views/img/trash-4x.png" alt="trash_icon">
                                </button>
                            
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div>
                  <form action="<?php echo FRONT_ROOT?>Room/showAddRoom" method="post">
                    <input type="hidden" name = "cinemaId" value=<?php echo $cinemaId?>> 
                    <button type="submit" class="submit button-a" >Add Room</button>
                 </form>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>cinema.table.js"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<?php require_once(VIEWS_PATH."footer.php")?>



