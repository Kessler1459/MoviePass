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

    public function add($proj)
    {
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
}
