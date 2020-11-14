<?php 
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");
?>
<main class="container">
    
    <h1>Sign In</h1>

    <form id="signIn" onsubmit="validarContraseña(); return false" action="<?php echo FRONT_ROOT ?>User/verifySignIn" method="POST">
        

        <div id="error" class="alert alert-danger ocultar" role="alert">
            Passwords do not match, try again!  
        </div>

        <div id="ok" class="alert alert-success ocultar" role="alert">
            Passwords match! Processing form ...
        </div>

        <?php if($message != ""){ ?>
            <div class="alert alert-danger" role="alert">
               <strong><?php echo $message ?></strong> 
            </div>
        <?php } ?>
        
        

        <div>
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div>
            <label for="pass1">Password</label>
            <input type="password" class="form-control" id="pass1" name="password" maxlength="12" required>
        </div>
        <div>
            <label for="pass2">Confirm password</label>
            <input type="password" class="form-control" id="pass2" maxlength="12" required>
        </div>
        <div>
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
        </div>
        <div>
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required>
        </div>
        <div>
            <label for="dni">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" required>
        </div>

        <br>
        <input type="hidden" name="userType" value="1">  
        <button type="submit" id="signIn"  class="btn btn-primary btn-lg">Sign In</button>

        <a href="<?php echo FRONT_ROOT ?>User/signInCinemaOwner">Trabaja con nosotros</a>

    </form>
        
</main>

<script src="<?php echo JS_PATH ?>verifyPasswords.js"></script>