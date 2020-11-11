<?php

namespace Controllers;
use Models\Compra;
use Models\Ticket;
use Models\DatosTarjeta;
use DAO\TicketDAO;
use DAO\CompraDAO;
use DAO\DatosTarjetaDAO;
use Controllers\LocationController;

class CinemaController{
    private $ticketDao;
    private $compraDao;
    private $datosTarjetaDao;

    public function __construct() {
        $this->ticketDao = new TicketDAO;
        $this->compraDao = new CompraDAO;
        $this->datosTarjetaDao = new DatosTarjetaDAO;
    }

    public function getAll(){
        return $this->cinemaDao->getAll();
    }

    public function getAllSorted(){
        $sorted=$this->cinemaDao->getAll();
        usort($sorted,array("Models\Cinema","compare"));
        return $sorted;
    }

    public function add($name,$provinceId,$cityId,$address){
        $id=time(); //number of seconds since January 1 1970
        $locContro=new LocationController();
        $province=$locContro->getProvinceById($provinceId);
        $city=$locContro->getCityById($cityId);
        $newCinema=new Cinema($name,$id,$province,$city,$address);
        $this->cinemaDao->add($newCinema);
        $this->showCinemasList();
    }

    public function modify($name,$id,$provinceId,$cityId,$address){
        $locContro=new LocationController();
        $province=$locContro->getProvinceById($provinceId);
        $city=$locContro->getCityById($cityId);
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
        
        $locationContr=new LocationController();
        $provinces=$locationContr->getAllProvinces();
        $initCities=$locationContr->getCitiesByProvince(1);  
        require_once VIEWS_PATH."add_cinema.php";
    }

    public function showModifyCinema($id){
        $locContro=new LocationController();
        $cinema=$this->cinemaDao->getById($id);
        $provinces=$locContro->getAllProvinces();
        $initCities=$locContro->getCitiesByProvince(1);  
        require_once VIEWS_PATH."modify_cinema.php";
    }
    public function showBuyTickets()
    {
        
    }

}


?>