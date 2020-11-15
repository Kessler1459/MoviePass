<?php

namespace DAO;


use Models\Ticket;
use Models\DatosTarjeta;
use DAO\Connection;
use \Exception as Exception;

class CompraDAO
{
    private $connection;
    private $ticketDao;
    private $tableName = "compra";

    public function __construct()
    {
        $this->ticketDao = new TicketDAO();
    }

    public function add($compra)
    {
        $query = "INSERT INTO $this->tableName (id_compra,id_user,id_tarjeta,fecha,descuento,cant_entradas,total) VALUES (:id_compra,:id_user,:id_tarjeta,:fecha,:descuento,:cant_entradas,total);";
        $parameters["id_compra"] = $compra->getId();
        $parameters["id_user"] = $cinema->getIdUser();
        $parameters["id_tarjeta"] = $cinema->get()->getId();
        $parameters["fecha"] = $cinema->getCity()->getId();
        $parameters["descuento"] = $cinema->getAddress();
        $parameters["cant_entradas"] = count($compra->getTickets());
        $parameters["total"] = $compra->getTotal();
        try {
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function getAll()
    {
        $query="SELECT c.id_compra,c.fecha,c.descuento,c.cant_entradas,c.total, u.id_user as id_user, d.*  from $this->tableName c
        inner join (select tarjeta.*, empresa_credito.* from tarjeta inner join empresa_credito on tarjeta.id_empresa_credito = empresa_credito.id_empresa_credito) 
          d on d.tarjeta_number = c.tarjeta_number";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        
        $comprasList = array();
        foreach ($results as $row) {
            $ticketsList = $this->ticketDao->getAllByCompra(["id_compra"]);
            $tarjeta = new DatosTarjeta($row["tarjeta_number"], $row["tipo_tarjeta"],$row["nombre_empresa"]);
            $compra = new Compra(
                $row["id_compra"],
                $row["id_user"],
                $ticketsList,
                $tarjeta,
                $row["total"]
            );
            $comprasList[] = $compra;
        }
        return $comprasList;
    }

    /* public function modify($modifiedCinema)
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

    public function getById($id)
    {
        $query="SELECT c.id_compra,c.fecha,c.descuento,c.cant_entradas,c.total, u.id_user as id_user, d.*  from $this->tableName c
        inner join (select tarjeta.*, empresa_credito.* from tarjeta inner join empresa_credito on tarjeta.id_empresa_credito = empresa_credito.id_empresa_credito) 
          d on d.tarjeta_number = c.tarjeta_number
          where c.id_compra = $id";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        $compra;
        foreach ($results as $row) {
            $ticketsList = $this->ticketDao->getAllByCompra(["id_compra"]);
            $tarjeta = new DatosTarjeta($row["tarjeta_number"], $row["tipo_tarjeta"],$row["nombre_empresa"]);
            $compra = new Compra(
                $row["id_compra"],
                $row["id_user"],
                $ticketsList,
                $tarjeta,
                $row["total"]
            );
            
        }
        return $compra;
    }

    public function remove($id)
    {
        $query = "DELETE FROM compras WHERE id_compra=$id";
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}