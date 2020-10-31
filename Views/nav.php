<nav class="navbar navbar-expand-lg  navbar-dark bg-dark fixed-top" >

     <button class="btn btn-dark " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          <span class="lead">Search </span> <i class="fas fa-angle-down"></i>
     </button>

     <ul class="nav justify-content-center">
          <span class="navbar-text">
               <h4>Welcome <strong> <?php 
               if (isset($_SESSION['name'])) { echo $_SESSION['name'];} ?> </strong> </h4>
          </span>
     </ul>
     
     <ul class="navbar-nav ml-auto">

          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Cinema/showCinemasList">Add cinema</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Movie/showMoviesList">Movies list</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>Movie/updateNowPlaying">Update movies list</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>User/logIn">LogIn</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href=" <?php echo FRONT_ROOT ?>User/signIn">SignIn</a>
          </li>
     </ul>
</nav>

