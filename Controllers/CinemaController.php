<?php

namespace Controllers;
use Models\Cinema;
use DAO\CinemaDAO;
use Controllers\LocationController;

class CinemaController{
    private $cinemaDao,$provinces,$initCities;

    public function __construct() {
        $this->cinemaDao=new CinemaDAO();
        $locationContr=new LocationController();
        $this->provinces=$locationContr->getAllProvinces();
        $this->initCities=$locationContr->getCitiesByProvince(1);  
    }

    /**
     * muestra todos si sos admin, sino muestra solo los cines del usuario dueño
     */
    public function getAll(){
        if(session_status () != 2){
            session_start();  
        }
        
        if ($_SESSION["userType"]==3) {
            return $this->cinemaDao->getAll();
        }
        else{
            return $this->getAllByUserId($_SESSION["Id"]);
        }
    }

    public function getAllByUserId($userId){
        return $this->cinemaDao->getAllByUserId($userId);
    }

    public function getAllSorted(){
        $sorted=$this->getAll();
        usort($sorted,array("Models\Cinema","compare"));
        return $sorted;
    }

    public function add($name,$provinceId,$cityId,$address){
        session_start();
        $userId=$_SESSION["Id"];
        $this->cinemaDao->add($name,$provinceId,$cityId,$address,$userId);
        $this->showCinemasList();
    }

    public function modify($name,$id,$provinceId,$cityId,$address){
        $province=$this->locContro->getProvinceById($provinceId);
        $city=$this->locContro->getCityById($cityId);
        $this->cinemaDao->modify(new Cinema($name,$id,$province,$city,$address));
        $this->showCinemasList();
    }

    public function remove($id){
        if ($this->cinemaDao->remove($id)>0) {
            $this->showCinemasList();
        }
        
    }

    public function showCinemasList(){
        $cinemas=$this->getAll();
        require_once VIEWS_PATH."cinema_list.php";
    }

    public function showAddCinema(){
        require_once VIEWS_PATH."add_cinema.php";
    }


}


?>