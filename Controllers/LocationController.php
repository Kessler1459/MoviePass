<?php
namespace Controllers;

use DAO\CityDAO;
use DAO\ProvinceDAO;
use Models\Province;
use Models\City;

class LocationController{
    private $provinceDao;
    private $cityDao;

    public function __construct() {
        $this->provinceDao=new ProvinceDAO();
        $this->cityDao=new CityDAO();
    }

    public function getAllProvinces(){
        return $this->provinceDao->GetAll();
    }

    public function getProvinceById($id){
        return $this->provinceDao->getById($id);
    }

    public function getCityById($id){
        return $this->cityDao->getById($id);
    }

    public function getCitiesByProvince($idProvince){
        return $cities=$this->cityDao->getByProvinceId($idProvince);
    }

    public function updateCitiesSelect($provinceId){
        $cities=$this->getCitiesByProvince($provinceId);
        foreach ($cities as $c) {
            $obj["id"]=$c->getId();
            $obj["name"]=$c->getName();
            $toEncode[]=$obj;
        }
        echo json_encode($toEncode,1);
    }
}

?>