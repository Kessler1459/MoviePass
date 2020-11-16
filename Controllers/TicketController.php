<?php

namespace Controllers;
include_once(ROOT."Lib/QR/phpqrcode.php");
use Lib\QR\QRcode;
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

    public function getSoldTicketsByProjId($idProj){
        try{
            return $soldTickets = $this->ticketDao->getSoldTicketsByProjId($idProj);
            
        }
        catch(Exception $e){
            $message="Error getting cant SoldTickets.";
            include(VIEWS_PATH."message_view.php");
        }
    }

    public function getByProjId($idProj){
        try{
            $arr =$this->ticketDao->getByProjId($idProj);
            for ($i=0; $i <count($arr) ; $i++) { 
                $arr[$i]=$this->setTicketQr($arr[$i]);
            }
            return $arr;
        }
        catch(Exception $e){
            $message="Error getting tickets.";
            include(VIEWS_PATH."message_view.php");
        }
    }

    public function getByPurchaseId($purchId){
        try{
            $arr =$this->ticketDao->getByPurchaseId($purchId);
            for ($i=0; $i <count($arr) ; $i++) { 
                $arr[$i]=$this->setTicketQr($arr[$i]);
            }
            return $arr;
        }
        catch(Exception $e){
            $message="Error getting tickets.";
            include(VIEWS_PATH."message_view.php");
        }
    }

    public function showTicketsByPurchaseId($purchId){
        $ticketsArray=$this->getByPurchaseId($purchId);
        include VIEWS_PATH."sold_tickets.php";
    }

    private function setTicketQr($ticket){
        session_start();
        $toEncode=$_SESSION["name"].$ticket->getId();
        $path=IMG_PATH.$toEncode.".png";
        QRcode::png($toEncode,$path,3,2,3);
        $ticket->setQr($path);
        return $ticket;
    }

}

?>