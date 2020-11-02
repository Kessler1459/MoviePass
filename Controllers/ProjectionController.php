<?php

namespace Controllers;

use DAO\ProjectionDAO;
use Controllers\MovieController;
use Controllers\GenreController;
use Models\Projection;

class ProjectionController
{
    private $projDao;
    private $movieContr;

    public function __construct()
    {
        $this->projDao = new ProjectionDAO();
        $this->movieContr = new MovieController();
    }

    /**
     * este es cartelera jeje
     */
    public function showProjectionsList(){
        $movieList=$this->projDao->getAllMovies();
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."movies_list.php");
    }

    public function showProjectionsByGenre($genresArray){
        $movieList=$this->projDao->getByGenre($genresArray);
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."movies_list.php");
    }

    public function showProjectionSearch($search){
        $movieList=$this->projDao->searchByName($search);
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."movies_list.php");
    }
    /*---------------------------------*/

    public function showProjections($roomId){
        $projs=$this->projDao->getArrayByRoomId($roomId);
        include(VIEWS_PATH."projection_admin.php");
    }

    public function add($roomId,$movieId,$date,$time)
    {
        $movie=$this->movieContr->getById($movieId);
        $proj=new Projection(time(),$movie,$date,$time);
        $this->projDao->add($proj,$roomId);
        $this->showProjections($roomId);
    }

    public function addFromList($roomId){
        $movieList=$this->movieContr->getAll();
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."add_projection.php");
    }

    public function addFromListByGenre($genresArray,$roomId){
        $movieList=$this->movieContr->getByGenre($genresArray);
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."add_projection.php");
    }

    public function addFromListSearch($search,$roomId){
        $movieList=$this->movieContr->searchByName($search);
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."add_projection.php");
    }

    public function updateMoviesList($roomId){
        $this->movieContr->updateNowPlaying();
        $this->addFromList($roomId);
    }

    /**
     * retorna todas las peliculas que tengan una funcion activa en el futuro sin repetirse.(cartelera hehe)
     */
    public function getAllMovies()
    {
        return $this->projDao->getAllMovies();
    }

    public function getById($id)
    {
        return $this->projDao->getById($id);
    }


    public function searchByName($name){
        $movies=$this->getAllMovies();
        $arrayFinded = array();
        foreach ($movies as $value) {
            if (stripos($value->getTitle(),$name)!==false)
            {
                array_push($arrayFinded,$value);
            }
        }
        return $arrayFinded; 
    }

    /**
     * devuelve todo el array de funciones futuras de una sala
     */
    public function getArrayByRoomId($id)
    {
        return $this->projDao->getArrayByRoomId($id);
    }

    public function remove($id,$roomId)
    {
        if ($this->projDao->remove($id)>0) {
            $this->showProjections($roomId);
        }

    }
}
