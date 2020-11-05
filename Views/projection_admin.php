<?php 
require_once(VIEWS_PATH."header.php");
require_once(VIEWS_PATH."nav.php");
?>
<main class="container">
    <h1>Projections</h1>
    <div class="custom-scrollbar table-wrapper-scroll-y">
        <input type="text" id="input" onkeyup="myFunction()" class="form-control" placeholder="Search for title..">
        <table id="table" class="table text-center table-hover table-striped table-cinemas" >
            <thead>
                <tr class="th-pointer">
                    <th class="th-pointer">Movie</th>
                    <th>Length</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projs as $projection) {
                    $movie=$projection->getMovie();   
                    ?>
                    <tr>         
                        <td><?php echo $movie->getTitle()?></td>
                        <td><?php echo $movie->getLength()?></td>
                        <td><?php echo $projection->getDate()?></td>
                        <td><?php echo $projection->getHour()?></td>
                        <td>                 
                        </td>
                        <td>                       
                            <form action="<?php echo FRONT_ROOT ?>Projection/remove" method="post">
                                <input type="hidden" name="id" value=<?php echo $projection->getId() ?>>
                                <input type="hidden" name="rooId" value=<?php echo $roomId?>>                               
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
    <form action="<?php echo FRONT_ROOT ?>Projection/addFromList" method="POST" >
                    <input type="hidden" name = "roomId" value=<?php echo $roomId ?>> 
                    <button type="submit" class="submit button-a" >Add Projection</button>
                 </form>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>cinema.table.js"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<?php require_once(VIEWS_PATH."footer.php")?>