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

        public function getAll(){
            return $this->movieDao->getAll();
        }

        public function getById($id){
            return $this->movieDao->getById($id);
        }
        public function getByGenre($genresArray){
            return $this->movieDao->getByGenre($genresArray);
        }

        //todo adaptar estos 3 metodos
        public function searchByName($name)
        {
            $moviesFinded=$this->movieDao->searchByName($name);
            return $moviesFinded;
        }

        public function updateNowPlaying(){
            $this->movieDao->updateNowPlaying();
        }

        public function showMoviesList(){
            $movieList=$this->movieDao->getAll();
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

        public function showMoviesSearch($search){
            $movieList=$this->searchByName($search);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

        public function showMoviesByGenre($genArr){
            $movieList=$this->movieDao->getByGenre($genArr);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

    }
?>

