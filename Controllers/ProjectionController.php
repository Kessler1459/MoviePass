<?php

namespace Controllers;

use DAO\ProjectionDAO;
use Controllers\RoomController;
use Controllers\MovieController;
use Controllers\GenreController;
use DateTime;
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
        $locContro=new LocationController();
        $gencontr=new GenreController();
        $genres=$gencontr->getAll();
        $provinces=$locContro->getAllProvinces();
        $initCities=$locContro->getCitiesByProvince(1);
        include(VIEWS_PATH."movies_list.php");
    }

    public function projectionFilters($cityId,$date,$genresJsonArray){
        $params["id_city"]=$cityId;
        $params["proj_date"]=$date;
        $projectionList=$this->projDao->projectionFilters($params);
        $projectionList=$this->filterByGenre(json_decode($genresJsonArray),$projectionList);
        echo json_encode($projectionList,1);
    }

    public function showProjectionSearch($search){
        $projectionList=$this->searchByName($search);
        echo json_encode($projectionList,1);
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

    public function addFromListFiltered($genresJsonArray){
        $movies=$this->movieContr->getAll();
        $movies=$this->movieContr->filterByGenre(json_decode($genresJsonArray),$movies);
        echo json_encode($movies,1);
    }

    public function addFromListSearch($search){
        $movieList=$this->movieContr->searchByName($search);
        echo json_encode($movieList,1);
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
    public function filterByGenre($genresArray,$projectionList)
    {
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

    /**
     * valida si se respetan los 15min antes de cada funcion y no existe otra funcion de la pelicula en otro sala u cine el mismo dia
     */
    public function validateProjection($roomId,$movieId,$date,$time){
        if($this->projDao->existByDate($date,$movieId,$roomId)==0){         //si la pelicula no esta registrada en una funcion en ninguna otra sala de ningun otro cine el mismo dia
            $newMovie=$this->movieContr->getById($movieId);
            $projList=$this->projDao->getByDateRoom($date,$roomId);
            $initTime=new DateTime($date." ".$time);         //hora de inicio de funcion a crear
            $endTime=new DateTime($date." ".$time); 
            $endTime=$endTime->modify("+".$newMovie->getLength()." minutes");  //hora de finalizacion
            foreach ($projList as $value) {
                $datetime=$value->getDate()." ".$value->getHour();
                $initTime2=new DateTime($datetime);  
                $endTime2=new DateTime($datetime);               //hora de inicio de las funciones existentes
                $endTime2=$initTime->modify("+".$value->getMovie()->getLength()." minutes");       //hora de fin
                if(($initTime<=$endTime2->modify("+15 minutes")) && ($endTime>=$initTime2->modify("-15 minutes"))){
                    $msg["msg"]="This time is not available";
                } 
            }
            if (!isset($msg["msg"])) {
                $msg["msg"]="Ok"; //si se puede insertar la nueva
            }
        }
        else {
            $msg["msg"]="This movie is already in another room or cinema";
        }
        echo json_encode($msg,1);
    }
}
