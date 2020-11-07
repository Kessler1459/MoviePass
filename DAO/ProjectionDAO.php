<?php

namespace DAO;

use Models\Projection;
use Models\Movie;
use DAO\GenreXMovieDAO;
use DAO\Connection;
use DAO\MovieDAO;
use Exception;

class ProjectionDAO {
    private $connection;
    private $genrexM;
    private $tableName = "projections";
    private $movieDao;

    public function __construct() {
        $this->genrexM=new GenreXMovieDAO();
        $this->movieDao = new MovieDAO();
    }

    public function add($projection,$roomId)
    {
        try
        {
            $query = "INSERT INTO $this->tableName (id_proj,id_room,id_movie,proj_date,proj_time) 
                        VALUES (:id_proj,:id_room,:id_movie,:proj_date,:proj_time);";
            $movie=$projection->getMovie();
            $parameters["id_proj"] = $projection->getId();
            $parameters["id_room"] =$roomId;
            $parameters["id_movie"] =$movie->getId();
            $parameters["proj_date"]=$projection->getDate();
            $parameters["proj_time"]=$projection->getHour();
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function remove ($id)
    {
        try
        {
            $query = "DELETE FROM projections 
            WHERE id_proj=$id";  
             $this->connection=Connection::getInstance();
             return $this->connection->executeNonQuery($query);
        }
        catch(Exception $ex){
            throw $ex;
        }
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
    public function getArrayByRoomId($roomId){
        $projectionList=array();
        try{
            $query="SELECT p.id_proj,p.id_room,p.proj_date,p.proj_time,m.id_movie,m.title,m.length,m.synopsis,m.poster_url,m.video_url,m.release_date 
                    from projections p
                    inner join movies m on m.id_movie=p.id_movie
                    where p.id_room=$roomId and concat(p.proj_date,' ',p.proj_time) > now()
                    order by(concat(p.proj_date,' ',p.proj_time));";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            foreach ($results as $row) {
                $movie=new Movie($row["title"],$row["id_movie"],$row["synopsis"],$row["poster_url"],$row["video_url"],$row["length"],[],$row["release_date"]);
                $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
                $projectionList[]=new Projection($row["id_proj"],$movie,$row["proj_date"],$row["proj_time"]);
            }
            return $projectionList;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function getById($id){
        try{
            $query="SELECT p.id_proj,p.proj_date,p.proj_time,r.id_room,r.descript,r.capacity,r.ticket_price,m.id_movie,m.title,m.length,m.synopsis,m.poster_url,m.video_url,m.release_date 
                    from projections p
                    inner join movies m on m.id_movie=p.id_movie
                    where p.id_proj=$id";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            $row=$results[0];
            $movie=new Movie($row["title"],$row["id_movie"],$row["synopsis"],$row["poster_url"],$row["video_url"],$row["length"],[],$row["release_date"]);
            $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
            $projection=new Projection($row["id_proj"],$movie,$row["proj_date"],$row["proj_time"]);  
            return $projection;          
        }catch(Exception $ex){
            throw $ex;
        }
    }


    /**
     * retorna todas las peliculas que tengan una funcion activa en el futuro sin repetirse
     */
    public function getAllMovies(){
        $moviesList=array();
        try{
            $query="SELECT m.* from projections p
                    inner join movies m on p.id_movie=m.id_movie
                    where concat(p.proj_date,' ',p.proj_time) > now()
                    group by m.id_movie";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            foreach ($results as $row) {
                $movie=new Movie($row["title"],
                    $row["id_movie"],
                    $row["synopsis"],
                    $row["poster_url"],
                    $row["video_url"],
                    $row["length"],
                    [],
                    $row["release_date"]);
                $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
                $moviesList[]=$movie;
            }
            return $moviesList;          
        }catch(Exception $ex){
            throw $ex;
        }
    }
    public function getAllProjectionsByMovie($movie)
    {
        $idMovie = $movie->getId();
        try{
            $query="SELECT p.id_proj,p.proj_date,p.proj_time,r.id_room,r.descript,r.capacity,r.ticket_price,m.id_movie,m.title,m.length,m.synopsis,m.poster_url,m.video_url,m.release_date 
                    from projections p
                    inner join movies m on m.id_movie=p.id_movie
                    where p.id_movie=$idMovie";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            foreach($results as $row)
            {
                $movie=new Movie($row["title"],$row["id_movie"],$row["synopsis"],$row["poster_url"],$row["video_url"],$row["length"],[],$row["release_date"]);
                $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
                $projection=new Projection($row["id_proj"],$movie,$row["proj_date"],$row["proj_time"]);
            }
            return $projection;
        }catch(Exception $ex){
            throw $ex;
        }
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

    public function getAllMoviesByDate($date){
        $moviesList=array();
        try{
            $query="SELECT m.* from projections p
                    inner join movies m on p.id_movie=m.id_movie
                    where p.proj_date = \"$date\" and concat(p.proj_date,' ',p.proj_time) > now()
                    group by m.id_movie";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            foreach ($results as $row) {
                $movie=new Movie($row["title"],
                    $row["id_movie"],
                    $row["synopsis"],
                    $row["poster_url"],
                    $row["video_url"],
                    $row["length"],
                    [],
                    $row["release_date"]);
                $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
                $moviesList[]=$movie;
            }
            return $moviesList;          
        }catch(Exception $ex){
            throw $ex;
        }
    }    
 
}

?>