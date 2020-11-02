<?php

namespace Controllers;

use DAO\ProjectionDAO;
use DAO\MovieDAO;
use DAO\GenreDAO;
use DAO\CinemaDAO;
use Models\Projection;

class ProjectionController
{
    private $projDao;
    private $movieDao;
    private $genreDao;
    private $cinemaDao;

    public function __construct()
    {
        $this->projDao = new ProjectionDAO();
        $this->movieDao = new MovieDao();
        $this->genreDao = new GenreDAO();
        $this->cinemaDao = new CinemaDAO();
        
    }


    /**
     * este es cartelera jeje
     */

    public function showProjectionsByGenre($genresArray){
        $movies=$this->projDao->getByGenre($genresArray);
        include(VIEWS_PATH."");//aca jeje
    }

    public function showProjectionsSearch($search){
        $movies=$this->projDao->searchByName($search);
        include(VIEWS_PATH."");//aca jeje
    }

    public function showProjectionsByRoom($roomId){
        $projs=$this->projDao->getArrayByRoomId($roomId);
        include(VIEWS_PATH."projection_admin.php");
    }
    public function showAddProjection($actualCinema = 0)
    {
        $actualCinema = $this->cinemaDao->getById(1604015782);
        $genres = $this->genreDao->getAll();
        $movieList = $this->movieDao->getAll();
        include VIEWS_PATH."add_projection.php";
    }
    public function showProjectionsList()
    {
        $movieList = $this->projDao->getAllMovies();
        $genres = $this->genreDao->getAll();
        $projections = $this->projDao->getAll();
        include VIEWS_PATH."show_projections.php";
    }

    public function add($date, $time, $id_movie)
    {
        $movie = $this->movieDao->getById($id_movie);
        $id=time(); //number of seconds since January 1 1970
        $proj=new Projection($id,$movie,$date,$time);
        $this->projDao->add($proj);
    }

    public function addFromList($roomId){
        
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
