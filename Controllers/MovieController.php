<?php

    namespace Controllers;
    use DAO\MovieDAO;


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
        
        public function filterByGenre($genresArray,$movies){ 
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

    }
?>