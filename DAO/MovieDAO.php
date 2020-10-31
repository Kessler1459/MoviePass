<?php

namespace DAO;

use Models\Movie;
use DAO\MoviedbDAO;
use DAO\GenreXMovieDAO;
use Exception;

class MovieDAO{
    private $connection;
    private $genreXMDao;
    private $roomDao;
    private $movieDB;
    private $tableName = "movies";

    public function __construct() {
        $this->genreXMDao =new GenreXMovieDAO();
        $this->movieDB=new MoviedbDAO();
    }

    public function add($movieId)
    {
        $movie=$this->movieDB->getDetailsById($movieId);
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
            $this->genreXMDao->addGenresArray($movie->getGenres(),$movieId);
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
            $row=$results[0];
            $movie=new Movie($row["title"],$row["id_movie"],$row["synopsis"],$row["poster_url"],$row["video_url"],$row["length"],$row["release_date"]);
            $movie->setGenres($this->genreXMDao->getByMovieId($idMovie));
            return $movie;
        }catch(Exception $ex){
            throw $ex;
        }
    }

/*
    public function updateNowPlaying(){
        $this->retrieveData();
        $movieDB=new MoviedbDAO();
        $num=1;
        $moviesArr=$movieDB->getAll("now_playing",1);
        while($num<=$movieDB->getTotalPages()){
            $moviesArr=$movieDB->getAll("now_playing",$num);
            $num++;
            foreach ($moviesArr as $apiMovie) {
                $bool=false;
                $i=0;
                while ($bool==false && $i<count($this->movies)) {
                    if ($apiMovie->getId()==$this->movies[$i]->getId()) {
                        $bool=true;
                    }
                    $i++;
                }
                if ($bool == false) {
                    $this->movies[]=$apiMovie;
                }
            }
        }
        $this->saveData();
    }
*/
    
    /*
                                            ESTAS VAN EN PROJECTIONS
    public function getByGenre($genresArray){ 
     $this->retrieveData();
        $newArray=array();
        foreach ($this->movies as $movie) {
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

        public function searchByName($name)
    {
        $this->retrieveData();
        $arrayFinded = array();
        foreach ($this->movies as $value) {
            if (stripos($value->getTitle(),$name)!==false)
            {
                array_push($arrayFinded,$value);
            }
        }
        return $arrayFinded;
        
    }
*/

/*
    private function genreGenerator($arrayGenre)
    {
        $robertoPetinato = array();
        foreach ($arrayGenre as $value) {
            array_push($robertoPetinato,new Genre($value["id"],$value["name"]));
        }
        return $robertoPetinato;
    }*/
}

?>