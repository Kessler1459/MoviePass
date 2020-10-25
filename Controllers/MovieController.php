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
        
        public function searchByName($name)
        {
            $moviesFinded=$this->movieDao->searchByName($name);
            return $moviesFinded;
        }

        private function getByGenre($genreArray){
            return $this->movieDao->getByGenre($genreArray);
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
            $movies=$this->getByGenre($genArr);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

        public function showHomeList()
        {
            $movies=$this->movieDao->getAll();
            include VIEWS_PATH."home_page.php";
        }

    }
?>
