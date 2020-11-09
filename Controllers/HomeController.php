<?php 

    namespace Controllers;

    use Controllers\CinemaController;
    use Controllers\ProjectionController;

    class HomeController{

        public function showCinemasList(){
            $cinemaController=new CinemaController();
            $cinemaController->showCinemasList();
        }

        public function showMoviesList(){
            $projController = new ProjectionController();
            $projController->showProjectionsList();
        }
        public function showHome()
        {
            $movieController = new MovieController();
            $movieController->showHomeList();
        }

    }

?>