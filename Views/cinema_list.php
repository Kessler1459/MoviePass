<?php 
require_once(VIEWS_PATH."header.php");
require_once(VIEWS_PATH."nav.php");
?>
<main class="container">
    <h1>Cinemas</h1>
    <div class="custom-scrollbar table-wrapper-scroll-y">
        <input type="text" id="input" onkeyup="myFunction()" class="form-control" placeholder="Search for names..">
        <table id="table" class="table text-center table-hover table-striped table-cinemas" >
            <thead>
                <tr class="th-pointer">
                    <th class="th-pointer">Name</th>
                    <th>Province</th>
                    <th>City</th>
                    <th>Address</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cinemas as $cine) {
                    ?>
                    <tr>
                        <td><?php echo $cine->getName()?></td>
                        <td><?php echo $cine->getProvince()->getName()?></td>
                        <td><?php echo $cine->getCity()->getName()?></td>
                        <td><?php echo $cine->getAddress()?></td>
                        <td><form action="<?php echo FRONT_ROOT ?>Cinema/showModifyCinema" method="post">
                            <input type="hidden" name="id" value=<?php echo $cine->getId()?>>
                            <button type="submit" class="btn" >
                                <img src="/MoviePass/Views/img/wrench-4x.png" alt="trash_icon">     
                            </button>
                        </form></td>
                        <td><form action="<?php echo FRONT_ROOT ?>Cinema/remove" method="post">
                            <input type="hidden" name="id" value=<?php echo $cine->getId() //revisar si esto esta bien ?>>
                            <button type="submit" class="btn">
                                <img src="/MoviePass/Views/img/trash-4x.png" alt="trash_icon">
                            </button>
                        </form></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <a href="<?php echo FRONT_ROOT ?>Cinema/showAddCinema">
        <button class="submit button-a" type="button">Add new cinema</button>
    </a>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>cinema.table.js"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<?php require_once(VIEWS_PATH."footer.php")?>