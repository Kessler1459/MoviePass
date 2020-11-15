<?php

namespace DAO;


use Models\DatosTarjeta;
use DAO\Connection;
use \Exception as Exception;

class DatosTarjetaDAO
{
    private $connection;
    private $tableName = "tarjeta";

    public function __construct()
    {
        
    }
    
    public function add($docType,$docNumber,$transactionAmount,$token,$paymentMethodId)
    {
        $query = "INSERT INTO $this->tableName (doc_type,doc_number,transaction_amount,payment_method,token) VALUES (:doc_type,:doc_number,:transaction_amount,:payment_method,:token);
        ";
        $parameters["doc_type"] = $docType;
        $parameters["doc_number"] = $docNumber;
        $parameters["transaction_amount"] = $transactionAmount;
        $parameters["payment_method"] = $paymentMethodId;
        $parameters["token"] = $token;
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
                $row["doc_type"],
                $row["doc_number"],
                $row["transaction_amount"],
                $row["token"],
                $row["payment_method_id"]

            );
            $datosTarjetaList[] = $tarjeta;
        }
        return $datosTarjetaList;
    }

    /* public function modify($modifiedTarjeta)
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
    } */

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
        $tarjeta = new DatosTarjeta(
                $row["doc_type"],
                $row["doc_number"],
                $row["transaction_amount"],
                $row["token"],
                $row["payment_method_id"]

            );
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