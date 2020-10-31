<?php

namespace DAO;


use Models\Genre;
use Exception;

class GenreDAO {
    private $connection;
    private $tableName = "genres";
    
    public function add($genre)
    {
        try
        {
            $query = "INSERT INTO $this->tableName (id_genre,genre_name) VALUES (:id_genre,:genre_name)";
            $parameters["id_genre"] = $genre->getId();
            $parameters["genre_name"] =$genre->getName();
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    public function getAll()
    {
        try {
            $genresList=array();
            $query = "SELECT * from $this->tableName";
            $this->connection = Connection::getInstance();
            $results=$this->connection->execute($query);
            foreach ($results as $row) {
               $newGenre=new Genre($row["id_genre"],$row["genre_name"]);
               $genresList[]=$newGenre;
            }
           return $genresList;
        } catch (Exception $ex) {
            throw $ex;
       }
    }

    public function getById($id){
        try{
            $query="SELECT * from genres where id_genre=$id";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            $row=$results[0];
            $genre=new Genre($row["id_genre"],$row["genre_name"]);
            return $genre;
        }catch(Exception $ex){
            throw $ex;
        }
    }
}

?>