<?php

namespace DAO;

use Models\Movie;
use DAO\MoviedbDAO;
use DAO\GenreXMovieDAO;
use Exception;

class MovieDAO{
    private $connection;
    private $genreXMDao;
    private $movieDB;
    private $tableName = "movies";

    public function __construct() {
        $this->genreXMDao =new GenreXMovieDAO();
        $this->movieDB=new MoviedbDAO();
    }

    public function add($movie)
    {
        try
        {
            $query = "INSERT INTO $this->tableName (id_movie,title,length,synopsis,poster_url,video_url,release_date) 
                        VALUES (:id_movie,:title,:length,:synopsis,:poster_url,:video_url,:release_date)";
            $parameters["id_movie"] = $movie->getId();
            $parameters["title"] = $movie->getTitle();
            $parameters["length"] = $movie->getLength();
            $parameters["synopsis"]=$movie->getSynopsis();
            $parameters["poster_url"]= $movie->getPoster();
            $parameters["video_url"]= $movie->getVideo();
            $parameters["release_date"]= $movie->getReleaseDate();
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
            $this->genreXMDao->addGenresArray($movie->getGenres(),$movie->getId());
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function getAll(){
        $moviesList=array();
        try {
            $query = "SELECT * from $this->tableName";
            $this->connection = Connection::getInstance();
            $results=$this->connection->execute($query);
            foreach ($results as $row) {
               $newMovie=new Movie($row["title"],$row["id_movie"],$row["synopsis"],$row["poster_url"],$row["video_url"],$row["length"],[],$row["release_date"]);
               $newMovie->setGenres($this->genreXMDao->getByMovieId($row["id_movie"]));
               $moviesList[]=$newMovie;
            }
           return $moviesList;
        } catch (Exception $ex) {
            throw $ex;
       }
    }

    public function getById($idMovie){
        try{
            $query="SELECT * from movies where id_movie=$idMovie";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            if(!empty($results)){
                $row=$results[0];
                $movie=new Movie($row["title"],$row["id_movie"],$row["synopsis"],$row["poster_url"],$row["video_url"],$row["length"],[],$row["release_date"]);
                $movie->setGenres($this->genreXMDao->getByMovieId($idMovie));
                return $movie;
            }
            else{
                return false;
            }
            
        }catch(Exception $ex){
            throw $ex;
        }
    }

    public function getByGenre($genresArray){ 
        $movies=$this->getAll();
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


    public function searchByName($name){
        $movies=$this->getAll();
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
     * guarda en la db las peliculas del now_playing de la api pero solo hasta la quinta pagina D:
     */
    public function updateNowPlaying(){
        $movieDB=new MoviedbDAO();
        $num=1;
        $moviesArr=$movieDB->getAll("now_playing",1);
        while($num<=5){   
            $moviesArr=$movieDB->getAll("now_playing",$num);
            $num++;
            foreach ($moviesArr as $apiMovie) {
                if ($this->getById($apiMovie->getId())==false) {   //si no la encuentra en la db, lo agrega
                    $detailedMovie=$this->movieDB->getDetailsById($apiMovie->getId());
                    $this->add($detailedMovie);
                }   
            }
        }  
    }

}

?>