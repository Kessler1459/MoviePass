<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>
<main class="container">
    <h1>Modify cinema</h1>
    <form class="form-center" action="<?php echo FRONT_ROOT ?>Cinema/modify" method="post">
        <div class="form-group text-center">

            <label for="name"><span>Name</span> </label>
            <input type="text" class="input-cinema" name="name" value=" <?php echo $cinema->getName() ?>" id="name" required>

            <input type="hidden" class="input-cinema" value=<?php echo $cinema->getId() ?> name="id">

            <label for="province"><span>Province</span></label>
            <select name="province" class="form-control" id="province"  required>
                <?php foreach ($provinces as $value) {
                    echo "<option data-id=" . $value->getId() . " value=" . $value->getId() . ">" . $value->getName() . "</option>";
                } ?>
            </select>

            <label for="City"><span>City</span></label>

            <select name="city" class="form-control" id="response" required>
                <?php foreach ($initCities as $c) {
                    $id = $c->getId();
                    $name = $c->getName();
                    echo "<option data-id=$id value='$id'>$name</option>";
                } ?>
            </select>

            <label for="address"><span>Address</span></label>
            <input type="address" class="input-cinema" name="address" id="address" value=" <?php echo $cinema->getAddress() ?>" required>

            <button class="submit button-a" type="submit">Ok</button>
    </form>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>
<script type='text/javascript' src="<?php echo JS_PATH ?>location_select.js"></script>
<?php require_once(VIEWS_PATH . "footer.php") ?>