<?php

namespace DAO;


use Models\Cinema;
use Models\Province;
use Models\City;
use DAO\Connection;
use Exception;

class CinemaDAO {
    private $connection;
    private $roomDao;
    private $tableName = "cinemas";

    public function __construct() {
        $this->roomDao=new RoomDAO;
    }

    public function add($cinema)
    {
        try
        {
            $query = "INSERT INTO $this->tableName (id_cinema,name_cinema,id_province,id_city,address) VALUES (:id_cinema,:name_cinema,:id_province,:id_city,:address);";
            $parameters["id_cinema"] = $cinema->getId();
            $parameters["name_cinema"] =$cinema->getName();
            $parameters["id_province"] =$cinema->getProvince()->getId();
            $parameters["id_city"]=$cinema->getCity()->getId();
            $parameters["address"]=$cinema->getAddress();
            $this->connection = Connection::getInstance();
            $this->connection->executeNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
    
    public function getAll()
    {
        try {
            $cinemasList=array();
            $query = "SELECT c.id_cinema,c.name_cinema,p.id as province_id,p.provincia_nombre,ciu.id as ciu_id,ciu.ciudad_nombre,c.address
                    from $this->tableName c
                    inner join provincia p on c.id_province=p.id
                    inner join ciudad ciu on ciu.id=c.id_city";
           $this->connection = Connection::getInstance();
           $results=$this->connection->execute($query);
           foreach ($results as $row) {
               $prov=new Province($row["province_id"],$row["provincia_nombre"]);
               $ci=new City($row["ciu_id"],$row["ciudad_nombre"]);
               $cinema=new Cinema($row["name_cinema"],
                                $row["id_cinema"],
                                $prov,
                                $ci,
                                $row["address"]);
                $cinema->setRooms($this->roomDao->getArrayByCinemaId($row["id_cinema"]));
                $cinemasList[]=$cinema;
           }
           return $cinemasList;
        } catch (Exception $ex) {
            throw $ex;
       }
    }

    public function modify($modifiedCinema){
        try {
            $query="UPDATE cinemas set name_cinema=:name, id_province=:id_province, id_city=:id_city, address=:address where id_cinema=:id_cinema;";
            $this->connection=Connection::getInstance();
            $prov=$modifiedCinema->getProvince();
            $city=$modifiedCinema->getCity();
            $params["name"]=$modifiedCinema->getName();
            $params["id_province"]=$prov->getId();
            $params["id_city"]=$city->getId();
            $params["address"]=$modifiedCinema->getAddress();
            $params["id_cinema"]=$modifiedCinema->getId();
            return $this->connection->executeNonQuery($query, $params);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getById($id){
        try{
            $query="SELECT c.name_cinema,c.id_province,p.provincia_nombre,ciu.id as id_city,ciu.ciudad_nombre,c.address from cinemas c
            join  provincia p on p.id=c.id_province
            join ciudad ciu on ciu.id=c.id_city
            where id_cinema=$id";
            $this->connection=Connection::getInstance();
            $results=$this->connection->execute($query);
            $row=$results[0];
            $prov=new Province($row["id_province"],$row["provincia_nombre"]);
            $ciu=new City($row["id_city"],$row["ciudad_nombre"]);
            $cinema=new Cinema($row["name_cinema"],$id,$prov,$ciu,$row["address"]);
            $cinema->setRooms($this->roomDao->getArrayByCinemaId($id));
            return $cinema;
        }catch(Exception $ex){
            throw $ex;
        }
    }
    
    public function remove($id){
        try{
            $query="DELETE FROM cinemas WHERE id_cinema=$id";
            $this->connection=Connection::getInstance();
            return $this->connection->executeNonQuery($query);
        }catch(Exception $ex){
            throw $ex;
        }
    }

}
?>
