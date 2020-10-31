<?php

namespace DAO;

use Models\Movie;
use Models\Genre;
use Controllers\GenreController;

// key  7aa6621ccfa43667fe6bb6917d72e075
//todo preguntar sobre donde guardar la key
class MoviedbDAO{
    private $movies;
    private $totalPages;
    private $apiKey;

    public function __construct() {     
        $this->movies=array();
        $this->apiKey="7aa6621ccfa43667fe6bb6917d72e075"; //por ahora la dejo aca
    }

    //si no se aclara se usa region argentina
    public function getAll($query,$page=1,$language="es-AR",$region="US")  //puede ser popular , upcoming, top_rated o now_playing(esta es la de carteleras)
    {
        $filename="https://api.themoviedb.org/3/movie/$query?api_key=$this->apiKey&language=$language&page=$page&region=$region";
        return $this->jsonToArray($filename);
    }

    public function searchMovie($query,$page,$language="es-AR",$region="US"){ //talvez agregarle por año
        $query=str_replace(" ","%20",$query);
        $filename="https://api.themoviedb.org/3/search/movie?api_key=$this->apiKey&language=$language&query=$query&page=$page&include_adult=true";
        return $this->jsonToArray($filename);
    }

    private function jsonToArray($filename){
        $this->movies=array();
        $jsonResults=file_get_contents($filename);
        $array=($jsonResults)?json_decode($jsonResults,true):array();
        $this->setTotalPages($array["total_pages"]);
        $genreContr=new GenreController();
        foreach ($array["results"] as $movie) {               
            $newMovie=new Movie($movie["title"],
                                $movie["id"],
                                $movie["overview"],
                                "https://image.tmdb.org/t/p/original".$movie["poster_path"],
                                "", //esta busqueda no trae duracion 
                                $genreContr->idArrayToObjects($movie["genre_ids"]),//arreglo de objetos genero
                                $movie["release_date"]);
            $this->movies[]=$newMovie;
        }
        return $this->movies;
    }

    public function getDetailsById($id, $language="es-AR"){
        $filename="https://api.themoviedb.org/3/movie/$id?api_key=$this->apiKey&language=$language";
        $this->movies=array();
        $jsonResults=file_get_contents($filename);
        $array=($jsonResults)?json_decode($jsonResults,true):array();
        $genreContr=new GenreController();
        $newMovie= new Movie($array["title"],
                            $id,
                            $array["overview"],
                            "https://image.tmdb.org/t/p/original".$array["poster_path"],
                            $array["runtime"],
                            $array["genres"], // arreglo de objetos genero
                            $array["release_date"]);
        return $newMovie;
    }


    /**
     * Get the value of pages
     */ 
    public function getTotalPages()
    {
        return $this->totalPages;
    }

    /**
     * Set the value of pages
     *
     * @return  self
     */ 
    public function setTotalPages($pages)
    {
        $this->totalPages = $pages;

        return $this;
    }
}
?>