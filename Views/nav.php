<nav class="navbar navbar-expand-sm  fixed-top">
     <a class="navbar-brand" href="<?php echo FRONT_ROOT . "Home/showHome"; ?>">
          <img src="<?php echo IMG_PATH . "MoviePass-Icon.png"; ?>" width="25" height="25" alt="">
          <strong>Movie Pass</strong>
     </a>




     <ul class="navbar-nav ml-auto justify-content-center">
          <li>
               <div class="welcome">
                    <?php
                    if (isset($_SESSION['name'])) {
                         echo "<a class='nav-link'>Welcome <strong>" . $_SESSION['name'] . "</strong> </a>";
                    } else {
                    ?>
               </div>


          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Home/logIn">LogIn</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Home/signIn">SignIn</a>
          </li>
     <?php } ?>
     </li>
     <?php
     if (isset($_SESSION['userType']) && $_SESSION['userType'] != 1) { ?>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Cinema/showCinemasList">Cinemas</a>
          </li>
     <?php }
     if (isset($_SESSION['userType'])) { ?>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Ticket/showTicketsByUserId">My tickets</a>
          </li>
     <?php } ?>
     <?php
     if (isset($_SESSION['userType']) && $_SESSION['userType'] == 3) { ?>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Discount/showModifyDiscounts">Discounts</a>
          </li>
     <?php } ?>


     <li class="nav-item">
          <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Projection/showProjectionsList">Projections list</a>
     </li>
     <?php
     if (isset($_SESSION['name'])) {  ?>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Home/logOut">Logout</a>
          </li>
     <?php } ?>

     </ul>
</nav>