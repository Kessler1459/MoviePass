<?php 

namespace DAO;

use DAO\Connection;
use Models\Ticket;
use \Exception as Exception;


class TicketDAO{
    private $connection;
    private $tableName = "tickets";

    public function add($num,$idProj,$idPurchase){
        $query="INSERT INTO $this->tableName (nro_ticket,id_proj,id_purchase) VALUES(:nro_ticket,:id_proj,:id_purchase)";
        $params["nro_ticket"]=$num;
        $params["id_proj"]=$idProj;
        $params["id_purchase"]=$idPurchase;
        try {
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query,$params);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getByProjId($idProj){
        $query="SELECT count(*) as count from $this->tableName where id_proj=$idProj";
        try {
            $this->connection = Connection::getInstance();
            $results=$this->connection->execute($query);
        } catch (Exception $ex) {
            throw $ex;
        }
        return $results[0]["count"];
    }



}

?>