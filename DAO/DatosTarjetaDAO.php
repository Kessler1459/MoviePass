<?php

namespace DAO;


use Models\DatosTarjeta;
use DAO\Connection;
use \Exception as Exception;

class CinemaDAO
{
    private $connection;
    private $tableName = "tarjeta";

    public function __construct()
    {
        
    }

    public function add($tarjeta)
    {
        $query = "INSERT INTO $this->tableName (nro_tarjeta,tipo_tarjeta,empresa_credito) VALUES (:nro_tarjeta,:tipo_tarjeta,:empresa_credito);
        ";
        $parameters["nro_tarjeta"] = $cinema->getNroTarjeta();
        $parameters["tipo_tarjeta"] = $cinema->getTipoTarjeta();
        $parameters["empresa_credito"] = $cinema->getEmpresaCredito();
        try {
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getAll()
    {
        $query = "SELECT * from $this->tableName;";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        $datosTarjetaList = array();
        foreach ($results as $row) {
            $tarjeta = new DatosTarjeta(
                $row["nro_tarjeta"],
                $row["tipo_tarjeta"],
                $row["empresa_credito"]
            );
            $datosTarjetaList[] = $tarjeta;
        }
        return $datosTarjetaList;
    }

    public function modify($modifiedTarjeta)
    {
        $query = "UPDATE tarjeta set nro_tarjeta=:nro_tarjeta, tipo_tarjeta=:tipo_tarjeta, empresa_credito=:empresa_credito;";
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
    }

    public function getById($id)
    {
        $query = "SELECT * from tarjeta where tarjeta_number = $id;";
        try {
            $this->connection = Connection::getInstance();
            $results = $this->connection->execute($query);
            
        } catch (Exception $ex) {
            throw $ex;
        }
        $row = $results[0];
        $tarjeta = new DatosTarjeta($row["tarjeta_number"], $row["tipo_tarjeta"], $row["empresa_credito"]);
        return $tarjeta;
    }

    public function remove($id)
    {
        $query = "DELETE FROM tarjeta WHERE tarjeta_number=$id";
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}