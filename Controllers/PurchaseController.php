<?php

    namespace Controllers;

    use DAO\PurchaseDAO as UserDAO;
    use Controllers\TicketController as TicketController;
    use Controllers\ProjectionController as ProjectionController;
    use Models\Projection as Projection;
    use Models\Movie as Movie;
    use Models\Room as Room;
    use Models\Cinema as Cinema;
    class PurchaseController{
        private $purchaseDAO;

        public function __construct() {
            $this->purchaseDao = new PurchaseDao();
        }
        


        public function selectProj($id_proj){
            $projectionController = new ProjectionController();
            $result = $projectionController->getById($id_proj);
            
            $proj = $result;
            $room = $result->getRoom();
            $movie = $result->getMovie();
            $cinema = $room->getCinema();
            
            include VIEWS_PATH."purchase_form.php";
        }

        public function add($quantity_tickets,$discount,$date,$total) {
            if(session_status () != 2){
                session_start();  
            }
            $id_user = $_SESSION['Id'];
            try
            {   
                $id_purchase = $this->add($id_user,$quantity_tickets,$discount,$date,$total);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
            $ticketController = new TicketController();
            for ($i=0; $i <  $quantity_tickets; $i++) { 
                $ticketController->add($num,$idProj,$id_purchase);
            }    
                
            
        }

        public function getById($id_ticket){
            $id_purchase = ;// con el ticket se busca id compra y se pasa por aca
            
            try
            {
                $this->getById($id_purchase);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }

        }        
        

    }

?>