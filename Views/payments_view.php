<?php
require_once(VIEWS_PATH . "header.php");
require_once(VIEWS_PATH . "nav.php");
?>

<main class="container">
    <form action="" method="post">
        <select name="company" id="cmp" required aria-placeholder="Credit company">
            <?php 
            foreach ($creditAccounts as $comp) {
                echo "<option value=".$comp->getId().">".$comp->getCompany()."</option>";    
            }?>
        </select>
        <i class="fas fa-credit-card">
            <input type="number" name="card" class="form-control" minlength="16" maxlength="16" placeholder="Credit card number" required>
        </i>
        <input type="number" name="code" class="form-control" minlength="3" maxlength="5" placeholder="Security code" required>
    </form>
    <?php if(count($discountsArray)>0){
                echo "<div class='alert alert-success' role='alert'>Today discounts";
                for ($i=0; $i <count($discountsArray) ; $i++) {
                    if ($i>1) {
                        echo ", ";
                    }
                    echo  $discountsArray[$i]->getPercent()."% with ".$discountsArray[$i]->getCreditAccount()->getCompany();
                }
                echo "</div>";
    } ?>
</main>

<?php require_once(VIEWS_PATH . "footer.php") ?>