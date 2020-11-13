<?php 
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");
?>
<main class="container">
    
    <h1>Sign In <br> Cinema Owner</h1>
    
    <form action="<?php echo FRONT_ROOT ?>User/verifySignIn" method="POST">
        
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
            <input type="password" class="form-control" id="pass1" name="password" required>
        </div>
        <div>
            <label for="pass2">Confirm password</label>
            <input type="password" class="form-control" id="pass2" required>
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
        <input type="hidden" name="userType" value="2">  
        <button type="submit" id="signIn"  class="btn btn-primary btn-lg">Sign In</button>

    </form>
        
</main>