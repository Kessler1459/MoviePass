<?php

namespace DAO;

use DAO\ProjectionDAO;
use Models\Room;
use Exception;

class RoomDAO {
    private $connection;
    private $projDao;
    private $tableName = "rooms";
    
    public function __construct() {
        $this->projDao = new ProjectionDAO();
    }

    public function add($room,$cinemaId)
    {
        try
        {
            $query = "INSERT INTO $this->tableName (id_room,id_cinema,capacity,ticket_price,descript) 
                        VALUES (:id_room,:id_cinema,:capacity,:ticket_price,:descript)";           
            $parameters["id_room"] =$room->getId();
            $parameters["id_cinema"] =$cinemaId;
            $parameters["capacity"] =$room->getCapacity();
            $parameters["ticket_price"] =$room->getTicketPrice();
            $parameters["descript"] =$room->getDescription();
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function getArrayByCinemaId($cinemaId){
        $roomList=array();
        try{
            $query="SELECT * from $this->tableName where id_cinema=$cinemaId";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            foreach ($results as $room) {
                $roomList[]=new Room($room["id_room"],
                    $room["capacity"],
                    $room["ticket_price"],
                    $room["descript"],
                    $this->projDao->getArrayByRoomId($room["id_room"]));
            }
            return $roomList;
        }catch(Exception $ex){
            throw $ex;
        }
    }

    public function getById($id){
        try{
            $query="SELECT * from $this->tablename where id_room=$id";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            $row=$results[0];
            $room=new Room($row["id_room"],
                    $row["capacity"],
                    $row["ticket_price"],
                    $row["descript"],
                    $this->projDao->getArrayByRoomId($row["id_room"]));
            return $room;
        }catch(Exception $ex){
            throw $ex;
        }
    }
}

?>