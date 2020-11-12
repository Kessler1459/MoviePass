<?php 
    include_once("movie_details.php");
?>
    <section>
        <form action="<?php echo FRONT_ROOT ?>Projection/showProjectionByCity" method="GET">
            <Label>City</Label>
            <select name="city" id="city_select">
                <?php 
                    foreach ($cinemas as $key => $value) {
                        if (isset($cityId) && ($cityId == $key->getId()))
                        {
                            echo "<option value='$key' selected>$key</option>";
                        }
                        else
                        {
                            echo "<option value='$key' >$key</option>";
                        }
                    }
                ?>
            </select>
            <label for="date">Select Date <span>Si no selecciona, se mostrarán las del día de la fecha<span></label>
            <input type="date" name="date" id="fecha">
            <button type="submit">Seleccionar ciudad</button>
        </form>
    </section>