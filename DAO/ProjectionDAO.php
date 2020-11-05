<?php

namespace DAO;

use Models\Projection;
use Models\Movie;
use DAO\GenreXMovieDAO;
use DAO\Connection;
use Exception;
use Models\Room;

class ProjectionDAO
{
    private $connection;
    private $genrexM;
    private $tableName = "projections";

    public function __construct()
    {
        $this->genrexM = new GenreXMovieDAO();
    }

    public function add($projection)
    {
        $query = "INSERT INTO $this->tableName (id_proj,id_room,id_movie,proj_date,proj_time) 
                        VALUES (:id_proj,:id_room,:id_movie,:proj_date,:proj_time);";
        $movie = $projection->getMovie();
        $parameters["id_proj"] = $projection->getId();
        $parameters["id_room"] = $projection->getRoom()->getId();
        $parameters["id_movie"] = $movie->getId();
        $parameters["proj_date"] = $projection->getDate();
        $parameters["proj_time"] = $projection->getHour();
        try {
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function remove($id)
    {
        $query = "DELETE FROM projections 
                WHERE id_proj=$id";
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * devuelve todo el array de funciones futuras de una sala 
     * 
     */
    public function getArrayByRoomId($roomId)
    {
        $query = "SELECT p.id_proj,p.proj_date,p.proj_time,r.descript,r.id_room,r.capacity,r.ticket_price,m.id_movie,m.title,m.length,m.synopsis,m.poster_url,m.video_url,m.release_date 
                from projections p
                inner join movies m on m.id_movie=p.id_movie
                inner join rooms r on r.id_room=p.id_room
                where p.id_room=$roomId and concat(p.proj_date,' ',p.proj_time) > now()
                order by(concat(p.proj_date,' ',p.proj_time))";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        $projectionList=array();
        foreach ($results as $row) {
            $movie = new Movie($row["title"], $row["id_movie"], $row["synopsis"], $row["poster_url"], $row["video_url"], $row["length"], [], $row["release_date"]);
            $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
            $room = new Room($row["id_room"], $row["capacity"], $row["ticket_price"], $row["descript"]);
            $projectionList[] = new Projection($row["id_proj"], $movie, $row["proj_date"], $row["proj_time"], $room);
        }
        return $projectionList;
    }


    public function getById($id)
    {
        $query = "SELECT p.id_proj,p.proj_date,p.proj_time,r.descript,r.id_room,r.capacity,r.ticket_price,m.id_movie,m.title,m.length,m.synopsis,m.poster_url,m.video_url,m.release_date 
                from projections p
                inner join movies m on m.id_movie=p.id_movie
                inner join rooms r on r.id_room=p.id_room
                where p.id_proj=$id";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        $row = $results[0];
        $movie = new Movie($row["title"], $row["id_movie"], $row["synopsis"], $row["poster_url"], $row["video_url"], $row["length"], [], $row["release_date"]);
        $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
        $room = new Room($row["id_room"], $row["capacity"], $row["ticket_price"], $row["descript"]);
        $projection = new Projection($row["id_proj"], $movie, $row["proj_date"], $row["proj_time"], $room);
        return $projection;
    }


    /**
     * retorna todas las futuras proyecciones 
     */
    public function getAllProjections()
    {
        $query = "SELECT p.id_proj,p.proj_date,p.proj_time,r.descript,r.id_room,r.capacity,r.ticket_price,m.id_movie,m.title,m.length,m.synopsis,m.poster_url,m.video_url,m.release_date 
                from projections p
                inner join movies m on m.id_movie=p.id_movie
                inner join rooms r on r.id_room=p.id_room
                where concat(p.proj_date,' ',p.proj_time) > now()";
        try {

            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        $projectionList=array();
        foreach ($results as $row) {
            $movie = new Movie(
                $row["title"],
                $row["id_movie"],
                $row["synopsis"],
                $row["poster_url"],
                $row["video_url"],
                $row["length"],
                [],
                $row["release_date"]
            );
            $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
            $room = new Room($row["id_room"], $row["capacity"], $row["ticket_price"], $row["descript"]);
            $proj = new Projection($row["id_proj"], $movie, $row["proj_date"], $row["proj_time"], $room);
            $projectionsList[] = $proj;
        }
        return $projectionsList;
    }


    public function getAllProjectionsByDate($date)
    {
        $query = "SELECT p.id_proj,p.proj_date,p.proj_time,r.descript,r.id_room,r.capacity,r.ticket_price,m.id_movie,m.title,m.length,m.synopsis,m.poster_url,m.video_url,m.release_date 
                    from projections p
                    inner join movies m on p.id_movie=m.id_movie
                    where p.proj_date = \"$date\" and concat(p.proj_date,' ',p.proj_time) > now()
                    group by m.id_movie";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        $projectionList=array();
        foreach ($results as $row) {
            $movie = new Movie(
                $row["title"],
                $row["id_movie"],
                $row["synopsis"],
                $row["poster_url"],
                $row["video_url"],
                $row["length"],
                [],
                $row["release_date"]
            );
            $movie->setGenres($this->genrexM->getByMovieId($row["id_movie"]));
            $room=new Room($row["id_room"],$row["capacity"],$row["ticket_price"],$row["descript"]);
            $proj=new Projection($row["id_proj"],$movie,$row["proj_date"],$row["proj_time"],$room);
            $projectionList[] = $proj;
        }
        return $projectionList;
    }
}
