<?php 

    namespace Controllers;

    use Controllers\CinemaController;
    use Controllers\MovieController as MovieController;
    use DAO\MoviedbDAO as MoviedbDAO;

    class HomeController{

        public function showCinemasList(){
            $cinemaController=new CinemaController();
            $cinemaController->showCinemasList();
        }

        public function showMoviesList(){
            $movieController = new MovieController();
            $movieController->showMoviesList();
        }

        public function logIn(){
            $userController = new userController();
            $userController->logIn();
        }

        public function signIn(){
            $userController = new userController();
            $userController->signIn();
        }

        public function logOut(){
            $userController = new userController();
            $userController->finishSession();
        }

        public function showHome()
        {
            $movieController = new MovieController();
            $movieController->showHomeList();
        }

    }

?>