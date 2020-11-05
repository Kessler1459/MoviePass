<?php
namespace DAO;

use DAO\Connection;
use Models\Province;
use Exception;

class ProvinceDAO{
    private $connection;
    private $tableName = "provincia";

    public function getById($id){
        try
            {
                $query = "SELECT provincia_nombre FROM ".$this->tableName." where id=$id";
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
                $province = new Province($id,$resultSet[0]["provincia_nombre"]);
                return $province;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
    }
    

    public function getAll()
        {
            try
            {
                $provincesList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $province = new Province($row["id"],$row["provincia_nombre"]);
                    array_push($provincesList, $province);
                }

                return $provincesList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }
}

?>