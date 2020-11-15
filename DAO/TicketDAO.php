<?php

namespace DAO;
use Models\Ticket;
use DAO\Connection;
use \Exception as Exception;

class TicketDAO
{
    private $connection;
    private $tableName = "entrada";

    public function __construct()
    {

    }

    public function add($ticket)
    {
        $query = "INSERT INTO $this->tableName (id_entrada,nro_entrada) VALUES (:id_entrada,:nro_entrada);
        INSERT INTO entrada_x_funcion (id_entrada,id_funcion) VALUES (:id_entrada,:id_funcion);";
        $parameters["id_entrada"] = $ticket->getId();
        $parameters["nro_entrada"] = $ticket->getNroEntrada();
        $parameters["id_funcion"] = $ticket->getIdProjection();
        try {
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public function sellTickets($tickets)
    {
        foreach($tickets as $key => $value)
        {
            $query = "DELETE FROM entrada_x_compra WHERE id_entrada=$id";
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($query);
        } catch (Exception $ex) {
            throw $ex;
        }    
        }
    }


    public function getAll()
    {
        $query="SELECT * from $this->tableName ";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        
        $ticketList = array();
        foreach ($results as $row) {
            $ticket = new Ticket(
                $row["id_entrada"],
                $row["nro_entrada"],
            );
            $ticketList[] = $ticket;
        }
        return $ticketList;
    }
/* 
    public function modify($modifiedCinema)
    {
        $query = "UPDATE cinemas set name_cinema=:name, id_province=:id_province, id_city=:id_city, address=:address where id_cinema=:id_cinema;";
        $prov = $modifiedCinema->getProvince();
        $city = $modifiedCinema->getCity();
        $params["name"] = $modifiedCinema->getName();
        $params["id_province"] = $prov->getId();
        $params["id_city"] = $city->getId();
        $params["address"] = $modifiedCinema->getAddress();
        $params["id_cinema"] = $modifiedCinema->getId();
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($query, $params);
        } catch (Exception $ex) {
            throw $ex;
        }
    } */
    public function getAllByCompra($id_compra)
    {
        $query = "SELECT * from entradas e
            where e.id_entrada = (select x.id_entrada from entrada_x_compra x where x.id_compra = $id_compra)";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
            
        } catch (Exception $ex) {
            throw $ex;
        }
        $ticketList = array();
        foreach ($results as $row) {
            $ticket = new Ticket(
                $row["id_entrada"],
                $row["nro_entrada"],
            );
            $ticketList[] = $ticket;
        }
        return $ticketList;
    }
    public function getById($id)
    {
        $query = "SELECT * from entrada
            where entrada.id_entrada=$id";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
            
        } catch (Exception $ex) {
            throw $ex;
        }
        $row = $results[0];
        $ticket = new Ticket($row["id_entrada"], "nro_entrada");
        return $ticket;
    }

    public function remove($id)
    {
        $query = "DELETE FROM entrada WHERE id_entrada=$id";
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}