<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>

<main class="container">
    <h1 class="title_"><?php echo $optionsArray[0]->getMovie()->getTitle() ?></h1>
    <form action="<?php echo FRONT_ROOT ?>Purchase/selectProj" method="POST">
        <div class="align-Projs-table">
            <table id="table" class="table text-center table-hover  table-striped table-cinemas">
                    <thead>
                        <tr class="th-pointer table-font">
                            <th>Cinema</th>
                            <th>Province</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Room</th>
                            <th>Price</th>
                            <th>Seats left</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($optionsArray as $proj) {
                                $ticketsLeft=$proj->getRoom()->getCapacity()-$ticketContr->getByProjId($proj->getId());
                                if($ticketsLeft>0){
                                    $room=$proj->getRoom();
                                    $cinema=$room->getCinema();
                                    $movie=$proj->getMovie();
                                    ?>
                                <tr class="table-font-alt">
                                    <td><?php echo $cinema->getName() ?></td>
                                    <td><?php echo $cinema->getProvince()->getName() ?></td>
                                    <td><?php echo $cinema->getCity()->getName() ?></td>
                                    <td><?php echo $cinema->getAddress() ?></td>
                                    <td><?php echo $room->getDescription() ?></td>
                                    <td><?php echo $room->getTicketPrice() ?></td>
                                    <td><?php echo $ticketsLeft ?></td>
                                    <td><?php echo $proj->getDate() ?></td>
                                    <td><?php echo $proj->getHour() ?></td>
                                    <td><input type="radio" name="selected" value="<?php echo $proj->getId() ?>" required></td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
            <button type="submit" class="button-a">Payments</button>
        </div>
    </form>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>cinema.table.js"></script>
<?php require_once(VIEWS_PATH . "footer.php") ?>