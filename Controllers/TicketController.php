<?php

namespace Controllers;

use DAO\TicketDAO;
use \Exception as Exception;

class TicketController{
    private $ticketDao;

    public function __construct() {
        $this->ticketDao = new TicketDAO();
    }

    public function add($num,$idProj,$idPurchase){
        try{
            return $this->ticketDao->add($num, $idProj, $idPurchase);
        }
        catch(Exception $e){
            $message="Ticket not added.";
            include(VIEWS_PATH."message_view.php");
        }
    }

    public function getByProjId($idProj){
        try{
            return $this->ticketDao->getByProjId($idProj);
        }
        catch(Exception $e){
            $message="Error getting tickets.";
            include(VIEWS_PATH."message_view.php");
        }
    }
}

?>