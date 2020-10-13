<?php
namespace Controllers;

use DAO\GenreDAO;

class GenreController{
    private $genreDao;

    public function __construct() {
        $this->genreDao = new GenreDAO();
    }

    public function getAll(){
        return $this->genreDao->getAll();
    }
    
    public function idArrayToObjects($idArray){
        $newArray=array();
        if(!empty($idArray)){
            foreach ($idArray as $value) {
                $newGenre=$this->genreDao->getById($value);
                $newArray[]=$newGenre;
            }
        }
        return $newArray;
    }
}
    
?>