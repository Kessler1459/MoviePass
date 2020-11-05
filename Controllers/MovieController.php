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
            $movies=$this->getAll();
                $newArray=array();
                foreach ($movies as $movie) {
                    $jaja=0;
                    $genresMovie=$movie->getGenres();
                    foreach ($genresMovie as $genM) {
                        foreach ($genresArray as $strGen) {
                            if ($strGen ==$genM->getName()){
                                $jaja++;
                            }
                        }
                    }     
                    if ($jaja==count($genresArray)) {
                        $newArray[]=$movie;
                    }
                }
                return $newArray;
        }

        public function searchByName($name){
            $movies=$this->getAll();
            $arrayFinded = array();
            foreach ($movies as $value) {
                if (stripos($value->getTitle(),$name)!==false)
                {
                    array_push($arrayFinded,$value);
                }
            }
            return $arrayFinded; 
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
            $movieList=$this->getByGenre($genArr);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

    }
?>
