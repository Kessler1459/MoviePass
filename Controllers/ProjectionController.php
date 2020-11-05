<?php

namespace Controllers;

use DAO\ProjectionDAO;
use Controllers\RoomController;
use Controllers\MovieController;
use Controllers\GenreController;
use Models\Projection;

class ProjectionController
{
    private $projDao;
    private $movieContr;
    private $roomContr;

    public function __construct()
    {
        $this->projDao = new ProjectionDAO();
        $this->movieContr = new MovieController();
        $this->roomContr=new RoomController();
    }

    /**
     * este es cartelera jeje
     */
    public function showProjectionsList(){
        $projectionList=$this->projDao->getAllProjections();
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."movies_list.php");
    }

    public function showProjectionsByGenre($genresArray){
        $projectionList=$this->getByGenre($genresArray);
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."movies_list.php");
    }

    public function showProjectionSearch($search){
        $projectionList=$this->searchByName($search);
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        include(VIEWS_PATH."movies_list.php");
    }

    public function showProjectionDate($date){
        $projectionList=$this->projDao->getAllProjectionsByDate($date);
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
        $room=$this->roomContr->getById($roomId);
        $proj=new Projection(time(),$movie,$date,$time,$room);
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
    public function getAllProjections()
    {
        return $this->projDao->getAllProjections();
    }

    public function getById($id)
    {
        return $this->projDao->getById($id);
    }


    /**
     * busca y devuelve array de proyecciones
     */
    public function searchByName($name){
        $projections=$this->getAllProjections();
        $arrayFinded = array();
        foreach ($projections as $value) {
            $movie=$value->getMovie();
            if (stripos($movie->getTitle(),$name)!==false)
            {
                array_push($arrayFinded,$value);
            }
        }
        return $arrayFinded; 
    }

    /**
     * todo
     * filtro de generos para cartelera 
     */
    public function getByGenre($genresArray)
    {
        $projectionList = $this->getAllProjections();
        $newArray = array();
        foreach ($projectionList as $proj) {
            $jaja = 0;
            $movie=$proj->getMovie();
            $genresMovie = $movie->getGenres();
            foreach ($genresMovie as $genM) {
                foreach ($genresArray as $strGen) {
                    if ($strGen == $genM->getName()) {
                        $jaja++;
                    }
                }
            }
            if ($jaja == count($genresArray)) {
                $newArray[] = $proj;
            }
        }
        return $newArray;
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
