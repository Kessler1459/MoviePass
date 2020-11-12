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

        //todo adaptar estos 3 metodos
        public function searchByName($name)
        {
            $moviesFinded=$this->movieDao->searchByName($name);
            return $moviesFinded;
        }

        public function updateNowPlaying(){
            $this->movieDao->updateNowPlaying();
        }

        public function showMoviesSearch($search){
            $movieList=$this->searchByName($search);
            $gencontr=new GenreController();
            $genres=$gencontr->getAll();
            include VIEWS_PATH."movies_list.php";
        }

    }
?>

