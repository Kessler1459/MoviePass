<?php

    namespace Controllers;
    use Models\Movie;
    use DAO\MovieDAO;
    use Controllers\GenreController;


    class MovieController{
        private $movieDao;
    
        public function __construct() {
            $this->movieDao = new MovieDAO();
        }
        //todo adaptar estos 3 metodos
        public function searchByName($name)
        {
            $moviesFinded=$this->movieDao->searchByName($name);
            return $moviesFinded;
        }

        public function updateNowPlaying(){
            $this->movieDao->updateNowPlaying();
            $this->showMoviesList();
        }

        public function showMoviesList(){
            $movies=$this->movieDao->getAll();
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

        public function showMoviesSearch($search){
            $movies=$this->searchByName($search);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

        public function showMoviesByGenre($genArr){
            $movies=$this->movieDao->getByGenre($genArr);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

    }
?>
