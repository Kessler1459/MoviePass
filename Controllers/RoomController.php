<?php

namespace Controllers;
use DAO\RoomDAO;
use Models\Room as Room;
class RoomController{
    private $roomDao;

    public function __construct() {
        $this->roomDao = new RoomDAO();
    }

    /**
     * agrega la habitacion, necesita la id del cine al que lo va a agregar
     */
    public function add($room,$cinemaId){
        $this->roomDao->add($room,$cinemaId);
    }

    public function addRoom ($capacity,$ticketPrice,$description,$cinemaId)
    {
        $id = time();
        $room = new Room($id,$capacity,$ticketPrice,$description);
        $this->roomDao->add($room,$cinemaId);
        $this->showRoom($cinemaId);
    }

    public function showAddRoom($cinemaId)
    {
       
        include VIEWS_PATH ."add_room.php";
    }

    public function remove($id,$cinemaId)
    {
        if ($this->roomDao->remove($id)>0) {
            $this->showRoom($cinemaId);
        }

    }

 
    public function modify($capacity,$ticketPrice,$description,$roomId,$cinemaId){
        
        $this->roomDao->modify(new Room($roomId,$capacity,$ticketPrice,$description,[]));
        $this->showRoom($cinemaId);
    }

    /**
     * una sala en especifico
     */
    public function getById($id){
        return $this->roomDao->getById($id);
    }

    public function showRoom($cinemaId)
    {
       
        $rooms=$this->getArrayByCinemaId($cinemaId);
        include VIEWS_PATH."room_admin.php";
    }

    /**
     * todas las salas de un cine
     */
    public function getArrayByCinemaId($cinemaId){
        return $this->roomDao->getArrayByCinemaId($cinemaId);
    }

    public function showModifyRoom($id,$cinemaId){
      
        $room=$this->roomDao->getById($id);
        
        require_once VIEWS_PATH."modify_room.php";
    }

 
}

?>