<?php 
require_once(VIEWS_PATH."header.php");
require_once(VIEWS_PATH."nav.php");
?>
<main class="container-table">
    <h1 class="table-title">Rooms</h1>
    <div class="custom-scrollbar table-wrapper-scroll-y">
        <input type="text" id="input" onkeyup="myFunction()" class="form-control" placeholder="Search for description..">
        <table id="table" class="table text-center table-hover table-striped table-cinemas" >
            <thead>
                <tr class="th-pointer">              
                    <th>Description</th>
                    <th>Capacity</th>
                    <th>Ticket Price</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room) {
                    ?>
                    <tr>
                        <td><?php echo $room->getDescription()?></td>
                        <td><?php echo $room->getCapacity()?></td>
                        <td><?php echo "$". $room->getTicketPrice()?></td>
                        <td>
                            <form action="<?php echo FRONT_ROOT?>Projection/showProjections" method="POST">
                                <button name ="id" class="btn vinculito" type="submit" value="<?php echo $room->getId()?>" ><strong>Projections</strong>   
                                </button>
                            </form> 
                        </td>
                        <td>
                            
                                <input type="hidden" name="id" value =<?php echo $room->getId()?>>
                                <input type="hidden" name="cinemaId" value=<?php echo $cinemaId?>>
                                <button type="button" class="btn"  onClick="modifyRoom(<?php echo "'".$room->getId() . "','" .$room->getCapacity() . "','" .$room->getTicketPrice() ."','" . $room->getDescription() ."','". $cinemaId ."'"  ?>)" data-toggle="modal" data-target="#modify_room"  >
                                <img src="/MoviePass/Views/img/wrench-4x.png" alt="trash_icon">     
                                </button>
                           
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
                  
                    <input type="hidden" name = "cinemaId" value=<?php echo $cinemaId?>> 
                    <button class="table-button" data-toggle="modal" data-target="#add_room">Add Room</button>
                 </form>
    </div>
</main>

<!--MODAL ADDING NEW ROOM-->

<form action="<?php echo FRONT_ROOT?>Room/add" method="post">


   
    <div class="modal fade" tabindex="-1" role="dialog" id="add_room">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header-adding">
                   
                    <button class="close" data-dismiss="modal">
                        <span class="close" aria-hidden="true">&times;</span>
                    </button>

                    <h2 class="modal-title-adding">New Room</h1>
                
                </div>
   
                <div class="modal-body-body">
                                   
                        <label class="form-label" for="capacity"><span>Capacity</span></label>
                        <input type="number" name=capacity class= "cinema-form-control" required>       
                        <label class="form-label" for="ticketPrice"><span>Ticket Price</span></label> 
                        <input class= "cinema-form-control" type="number" name ="ticketPrice">
                        <label class="form-label" for="description">Description</label>
                        <input class="cinema-form-control" type="text" name="description">
                        <input type="hidden" name="cinemaId" value = <?php echo $cinemaId ?>>

                        <button class="form-button" type="submit">Register</button>
                     
                </div>

            </div>
                    <div class="modal-footer">

                    </div>

        </div>
    </div>
</form>


<!--   MODAL  MODIFY   ROOM   -->



<form action="<?php echo FRONT_ROOT?>Room/modify" method="post">
<div class="modal fade" role="document" id="modify_room">

    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <div class="modal-header-adding">
                        <button class="close" data-dismiss="modal">
                        <span class="close" aria-hidden="true">&times;</span>
                        </button>
                        <h2 class="modal-title-adding">Modify Room</h2>
            </div>
            <div class="modal-body-body">

               
                <label  class="form-label" for="capacity"><span>Capacity</span></label>
                <input class="cinema-form-control" type="number" name="modalCapacity" id="modalCapacity" class= "input-cinema"  required>
                <label  class="form-label" for="ticketPrice"><span>Ticket Price</span></label>  
                <input class="cinema-form-control" type="number" name ="modalTPrice" id="modalTPrice"class= "input-cinema"  required>
                <label class="form-label"  for="description">Description</label>
                <input class="cinema-form-control" type="text" name="modalDescription" id ="modalDescription"class= "input-cinema"   required>
      
                <input type="hidden" name="roomId" id="roomId" >
                <input type="hidden" name="cinemaId" id="cinemaId">     
                
           
                <button class="form-button" type="submit">Modify</button> 

            </div>
        </div>
                
                <div class="modal-footer">
        
     
                </div>
        
    </div>

</div>  
</form>



<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>cinema.table.js"></script>
<script src="<?php echo JS_PATH?>modifyRegister.js"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<?php require_once(VIEWS_PATH."footer.php")?>



