<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>
<main class="container">
    <h1 class="table-title title_">Rooms</h1>
    <div class="custom-scrollbar table-wrapper-scroll-y">
        <input type="text" id="input" onkeyup="myFunction()" class="form-control" placeholder="Search for description..">
        <table id="table" class="table text-center table-hover table-striped table-cinemas">
            <thead>
                <tr class="th-pointer">
                    <th>Description</th>
                    <th>Capacity</th>
                    <th>Ticket Price</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room) {
                ?>
                    <tr>
                        <td><?php echo $room->getDescription() ?></td>
                        <td><?php echo $room->getCapacity() ?></td>
                        <td><?php echo "$" . $room->getTicketPrice() ?></td>
                        <td>
                            <form action="<?php echo FRONT_ROOT ?>Projection/showProjections" method="POST">
                                <button name="id" class="btn vinculito" type="submit" value="<?php echo $room->getId() ?>"><strong>Projections</strong>
                                </button>
                            </form>
                        </td>
                        <td>

                            <input type="hidden" name="id" value=<?php echo $room->getId() ?>>
                            <input type="hidden" name="cinemaId" value=<?php echo $cinemaId ?>>
                            <button type="button" class="btn" onClick="modifyRoom(<?php echo "'" . $room->getId() . "','" . $room->getCapacity() . "','" . $room->getTicketPrice() . "','" . $room->getDescription() . "','" . $cinemaId . "'"  ?>)" data-toggle="modal" data-target="#modify_room">
                                <img src="/MoviePass/Views/img/wrench-4x.png" alt="wrench_icon" width="30px" >
                            </button>

                        </td>
                        <td>
                            <form action="<?php echo FRONT_ROOT ?>Room/remove" method="post">

                                <input type="hidden" name="id" value=<?php echo $room->getId() ?>>
                                <input type="hidden" name="cinemaId" value=<?php echo $cinemaId ?>>
                                <button type="submit" class="btn">
                                    <img src="/MoviePass/Views/img/trash-4x.png" alt="trash_icon" width="30px">
                                </button>

                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div>

        <input type="hidden" name="cinemaId" value=<?php echo $cinemaId ?>>
        <button class="button-a" data-toggle="modal" data-target="#add_room">Add Room</button>
        </form>
    </div>
</main>

<!--MODAL ADDING NEW ROOM-->




<div class="modal fade" tabindex="-1" role="dialog" id="add_room">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-c container">
            <div class="modal-header-adding">
                <button class="close" data-dismiss="modal">
                    <span class="close" aria-hidden="true">&times;</span>
                </button>
                <h1 class="modal-title-adding title_">New room</h1>
            </div>
            <form action="<?php echo FRONT_ROOT ?>Room/add" method="post" class="form-group">
                <label for="capacity"><span>Capacity</span></label>
                <input type="number" name=capacity class="form-control input-cinema" required>
                <label for="ticketPrice"><span>Ticket Price</span></label>
                <input class="form-control input-cinema" type="number" name="ticketPrice" required>
                <label for="description">Description</label>
                <input class="form-control input-cinema" type="text" name="description" required>
                <input type="hidden" name="cinemaId" value=<?php echo $cinemaId ?>>
                <button class="button-a" type="submit">Register</button>
            </form>
        </div>
    </div>
</div>


    <!--   MODAL  MODIFY   ROOM   -->



<div class="modal fade" role="document" id="modify_room">
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-c container">
                <div class="modal-header-adding">
                    <button class="close" data-dismiss="modal">
                        <span class="close" aria-hidden="true">&times;</span>
                    </button>
                    <h1 class="modal-title-adding title_">Modify room</h1>
                </div>
                <form action="<?php echo FRONT_ROOT ?>Room/modify" method="post" class="form-group">
                
                    <label for="capacity"><span>Capacity</span></label>
                    <input class="form-control input-cinema" type="number" name="modalCapacity" id="modalCapacity" class="input-cinema" required>
                    <label for="ticketPrice"><span>Ticket Price</span></label>
                    <input class="form-control input-cinema" type="number" name="modalTPrice" id="modalTPrice" class="input-cinema" required>
                    <label for="description">Description</label>
                    <input class="form-control input-cinema" type="text" name="modalDescription" id="modalDescription" class="input-cinema" required>
                    <input type="hidden" name="roomId" id="roomId">
                    <input type="hidden" name="cinemaId" id="cinemaId">
                    <button class="form-button" type="submit">Modify</button>
                </form>   
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>cinema.table.js"></script>
<script src="<?php echo JS_PATH ?>modifyRegister.js"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<script src="<?php echo JS_PATH ?>location_select.js"></script>
<?php require_once(VIEWS_PATH . "footer.php") ?>