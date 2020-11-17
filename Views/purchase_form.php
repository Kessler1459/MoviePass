<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>

<main class="container-form">
    <div class="formDiv">
        <h1 class="title_"><?php echo $movie->getTitle()?></h1>
        <?php echo (isset($message) && $message!="")? "<div class='alert alert-danger' role='alert'>$message</div>" :""?>
        <form class="align-Projs-table" action="<?php echo FRONT_ROOT ?>Purchase/processPurchase" method="post">
            <table class="table text-center table-hover  table-striped">
                <tr>
                    <th>Cinema:</th>
                    <td><?php echo $cinema->getName()?></td>
                </tr>
                <tr>
                    <th>Room:</th>
                    <td><?php echo $room->getDescription()?></td>
                </tr>
                <tr>
                    <th>Province:</th>
                    <td><?php echo $cinema->getProvince()->getName()?></td>
                </tr>
                <tr>
                    <th>City:</th>
                    <td><?php echo $cinema->getCity()->getName()?></td>
                </tr>
                <tr>
                    <th>Price:</th>
                    <td id="tcPrice"><?php echo $room->getTicketPrice()?></td>
                </tr>
                <tr>
                    <th>Quantity:</th>
                    <td><input class="form-control text-center" type="number" min="1" id="quanty" name="quant" required></td>
                </tr>
                <tr>
                    <th><strong>Total price:</strong></th>
                    <td><strong><input class="form-control text-center" type="float" id="resultPrice" value="0" disabled></strong></td>
                </tr>
            </table>
            <input type="hidden" name="idProj" value="<?php echo $proj->getId()?>">
            <button class="button-a " type="submit">Next</button>
        </form>
</div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>purchaseTotal.js"></script>
<?php require_once(VIEWS_PATH . "footer.php") ?>