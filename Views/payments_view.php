<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>

<main class="container">
    <section>
        <form action="" method="post">
            <select name="company" id="cmp" required aria-placeholder="Credit company" class="form-control">
                <?php
                foreach ($creditAccounts as $comp) {
                    echo "<option value=" . $comp->getId() . ">" . $comp->getCompany() . "</option>";
                } ?>
            </select>
            <input type="number" name="card" class="form-control" minlength="16" maxlength="16" placeholder="Credit card number" required>
            <input type="number" name="code" class="form-control" minlength="3" maxlength="5" placeholder="Security code" required>
            <br>
            <?php if (count($discountsArray) > 0) {
                echo "<div class='alert alert-success' role='alert'><strong>Today discounts.</strong><br>";
                for ($i = 0; $i < count($discountsArray); $i++) {
                    if ($i > 0) {
                        echo ", ";
                    }
                    echo  $discountsArray[$i]->getPercent() . "% with " . $discountsArray[$i]->getCreditAccount()->getCompany() . " ";
                }
                echo "</div>";
            } ?>
            <input type="hidden" name="quant" value="<?php echo $quantity_tickets ?>">
            <input type="hidden" name="idProj" value="<?php echo $id_proj ?>">
            <button type="submit" class="button-a">Accept</button>
        </form>
    </section>
</main>

<?php require_once(VIEWS_PATH . "footer.php") ?>