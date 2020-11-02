<?php

namespace Controllers;

use DAO\ProjectionDAO;

class ProjectionController
{
    private $projDao;

    public function __construct()
    {
        $this->projDao = new ProjectionDAO();
    }

    /**
     * este es cartelera jeje
     */
    public function showProjectionsList(){
        $movies=$this->projDao->getAllMovies();
        include(VIEWS_PATH."");//aca jeje
    }

    public function showProjectionsByGenre($genresArray){
        $movies=$this->projDao->getByGenre($genresArray);
        include(VIEWS_PATH."");//aca jeje
    }

    public function showProjectionsSearch($search){
        $movies=$this->projDao->searchByName($search);
        include(VIEWS_PATH."");//aca jeje
    }

    public function showProjections($roomId){
        $projs=$this->projDao->getArrayByRoomId($roomId);
        include(VIEWS_PATH."projections_list.php");
    }

    public function add($proj)
    {
        $this->projDao->add($proj);
    }

    public function addFromList($roomId){
        
    }

    public function remove($idProj,$roomId){
        $this->projDao->remove($idProj);
        $this->showProjections($roomId);
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

    public function showProjections($roomId)
    {
        $projectionsList = $this->getArrayByRoomId($roomId);
        include_once VIEWS_PATH."projection_admin.php";

    }

 
    public function modify($id,$movie,$date,$hour,$roomId){
        
        $this->projDao->modify(new Projection($id,$movie,$date,$hour));
        //$this->showRoom($cinemaId);
    }
}
