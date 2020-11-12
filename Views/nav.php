<nav class="navbar navbar-expand-lg  navbar-dark bg-dark fixed-top" >
     <button class="btn btn-dark " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          <span class="lead">Search </span> <i class="fas fa-angle-down"></i>
     </button>

     <ul class="nav justify-content-center">
          <span class="navbar-text">
          <?php 
               if (isset($_SESSION['name'])) { echo "<h4>Welcome <strong>".$_SESSION['name']."</strong> </h4>";} ?> 
          </span>
     </ul>

     <ul class="navbar-nav ml-auto"> 
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Cinema/showCinemasList">Cinemas</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Projection/showProjectionsList">Projections list</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Home/logIn">LogIn</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Home/signIn">SignIn</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Home/showHome">Home</a>
          </li>
     </ul>
</nav>
