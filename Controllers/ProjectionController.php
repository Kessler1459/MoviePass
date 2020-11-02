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

    public function add($newProj)
    {
        $this->movieDao->getById($newProj['movie_id']);
        $id=time(); //number of seconds since January 1 1970
        $time = $newProj['projection_time'];
        $date = $newProj['projection_date'];
        $proj=new Projection($id,$movie,$date,$hour);
        $this->projDao->add($proj);
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

    /**
     * filtro de generos para cartelera
     */
    public function getByGenre($genresArray)
    {
        $moviesList = $this->getAllMovies();
        $newArray = array();
        foreach ($moviesList as $movie) {
            $jaja = 0;
            $genresMovie = $movie->getGenres();
            foreach ($genresMovie as $genM) {
                foreach ($genresArray as $strGen) {
                    if ($strGen == $genM->getName()) {
                        $jaja++;
                    }
                }
            }
            if ($jaja == count($genresArray)) {
                $newArray[] = $movie;
            }
        }
        return $newArray;
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

    public function showAddProjection($actualCinema = 0)
    {
        $actualCinema = $this->cinemaDao->getById(1604015782);
        $genres = $this->genreDao->getAll();
        $movieList = $this->movieDao->getAll();
        include VIEWS_PATH."add_projection.php";
    }
}
