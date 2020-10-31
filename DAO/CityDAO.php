<?php
namespace DAO;

use DAO\Connection;
use Models\City;
use Exception;

class CityDAO{
    private $connection;
    private $tableName = "ciudad";

    public function getById($id){
        try
            {
                $query = "SELECT ciudad_nombre FROM ".$this->tableName." where id=$id";
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
                $city = new City($id,$resultSet[0]["ciudad_nombre"]);
                return $city;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
    }

    public function getAll(){
        try
        {
            $citiesList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query);
                
            foreach ($resultSet as $row)
            {                
                $city = new City($row["id"],$row["ciudad_nombre"]);
                array_push($citiesList, $city);
            }

            return $citiesList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function getByProvinceId($id){
        try{
            $query="SELECT id,ciudad_nombre from ciudad where provincia_id=:id order by ciudad_nombre asc;";
            $param["id"]=$id;
            $this->connection=Connection::GetInstance();
            $results=$this->connection->execute($query,$param);
            foreach ($results as $row) {
                $cities[]=new City($row["id"],$row["ciudad_nombre"]);
            }
            return $cities;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }
}
