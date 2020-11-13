<?php 
    require_once(VIEWS_PATH."header.php");
    require_once(VIEWS_PATH."nav.php");
?>

<main class="container">

    <h1>Log In</h1>

    <form action="<?php echo FRONT_ROOT ?>User/verifyLogIn" method="POST">
        
        <?php if($message != ""){ ?>
            <div class="alert alert-danger" role="alert">
               <strong><?php echo $message ?></strong> 
            </div>
        <?php } ?>
        
        <div>
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div>
            <label for="pass">Password</label>
            <input type="password" class="form-control" id="pass" name="password" required>
        </div>

        <br>
        
        <button type="submit" id="login" class="btn btn-primary btn-lg">Log In</button>
    </form>
    
    <div>
        <img src="<?php echo IMG_PATH?>person-4x.png"  style="float:left; margin:10px;" alt="trash_icon">
        <a class="nav-link" href=" <?php echo FRONT_ROOT?>User/signIn">Not a member? Sign in now</a>
    </div>
    
       
</main>
