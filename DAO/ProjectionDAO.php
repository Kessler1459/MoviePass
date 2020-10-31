<?php

namespace DAO;

use Models\Projection;
use Models\Room;
use Models\Movie;
use DAO\GenreXMovieDAO;
use DAO\Connection;
use Exception;

class ProjectionDAO {
    private $connection;
    private $genrexM;
    private $tableName = "projections";

    public function __construct() {
        $this->genrexM=new GenreXMovieDAO();
    }

    public function add($projection)
    {
        try
        {
            $query = "INSERT INTO $this->tableName (id_proj,id_room,id_movie,proj_date,proj_time) 
                        VALUES (:id_proj,:id_room,:id_movie,:proj_date,:proj_time);";
            $room=$projection->getRoom();
            $movie=$projection->getMovie();
            $parameters["id_proj"] = $projection->getId();
            $parameters["id_room"] =$room->getId();
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
 


    public function getArrayByRoomId($roomId){
        $projectionList=array();
        try{
            $query="SELECT p.id_proj,p.id_room,p.proj_date,p.proj_time,m.id_movie,m.title,m.length,m.synopsis,m.poster_url,m.video_url,m.release_date 
                    from projections p
                    inner join movies m on m.id_movie=p.id_movie
                    where p.id_room=$roomId";
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

}
?>
