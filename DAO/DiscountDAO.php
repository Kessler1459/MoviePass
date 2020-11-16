<?php 

namespace DAO;
use DAO\Connection;
use \Exception as Exception;

class DiscountDAO{
    private $connection;
    private $tableName = "discounts";

    public function add($percent,$date,$creditAccountId)
    {
        $query = "INSERT INTO $this->tableName (dis_per,dis_date,id_creditAccount) VALUES (:dis_per,:dis_date,:id_creditAccount)";
        $parameters["dis_per"] = $percent;
        $parameters["dis_date"] = $date;
        $parameters["id_creditAccount"] = $creditAccountId;
        try {
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getByDate($date){
        $query="SELECT * from $this->tableName d
                inner join creditAccounts c.id_creditAccount=d.id_creditAccount
                where d.dis_date=\"$date\"";
        try{
            $this->connection = Connection::getInstance();
            $this->connection->execute($query);
        }
        catch (Exception $ex) {
            throw $ex;
        }
    }
}

?>