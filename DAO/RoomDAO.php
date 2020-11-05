<?php

namespace DAO;

use Models\Room;
use Exception;

class RoomDAO
{
    private $connection;
    private $tableName = "rooms";

    
    public function add($room, $cinemaId)
    {
        $query = "INSERT INTO $this->tableName (id_room,id_cinema,capacity,ticket_price,descript) 
                        VALUES (:id_room,:id_cinema,:capacity,:ticket_price,:descript)";
        $parameters["id_room"] = $room->getId();
        $parameters["id_cinema"] = $cinemaId;
        $parameters["capacity"] = $room->getCapacity();
        $parameters["ticket_price"] = $room->getTicketPrice();
        $parameters["descript"] = $room->getDescription();
        try {
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function remove($id)
    {
        $query = "DELETE FROM rooms 
            WHERE id_room=$id";
        try {

            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function modify($modifiedRoom)
    {
        $id = $modifiedRoom->getId();
        $query = "UPDATE rooms set capacity=:capacity,ticket_price=:ticket_price,descript=:descript WHERE id_room=$id";
        $params["capacity"] = $modifiedRoom->getCapacity();
        $params["ticket_price"] = $modifiedRoom->getTicketPrice();
        $params["descript"] = $modifiedRoom->getDescription();
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($query, $params);
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function getArrayByCinemaId($cinemaId)
    {
        $query = "SELECT * from $this->tableName where id_cinema=$cinemaId";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        $roomList=array();
        foreach ($results as $room) {
            $roomList[] = new Room(
                $room["id_room"],
                $room["capacity"],
                $room["ticket_price"],
                $room["descript"]
            );
        }
        return $roomList;
    }

    public function getById($id)
    {
        $query = "SELECT * from $this->tableName where id_room=$id";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        $row = $results[0];
        $room = new Room(
            $row["id_room"],
            $row["capacity"],
            $row["ticket_price"],
            $row["descript"]
        );
        return $room;
    }
}
