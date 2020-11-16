<?php

    namespace Controllers;

    use DAO\PurchaseDAO as PurchaseDAO;
    use Controllers\TicketController as TicketController;
    use Controllers\ProjectionController as ProjectionController;
    use Controllers\DiscountController as DiscountController;
    use Controllers\CreditAccountController as CreditAccountController;
    use Models\Projection as Projection;
    use Models\Movie as Movie;
    use Models\Room as Room;
    use Models\Cinema as Cinema;
    use \Exception as Exception;


    class PurchaseController{
        private $purchaseDAO;
        private $ticketController;
        private $projectionController;
        private $discountController;
        private $creditAccountController;

        public function __construct() {
            $this->purchaseDao = new PurchaseDao();
            $this->ticketController = new TicketController();
            $this->projectionController = new ProjectionController();
            $this->discountController = new DiscountController();
            $this->creditAccountController = new CreditAccountController();
        }
        
        public function processPurchse($quantity_tickets,$id_proj){
            $soldTickets = $this->ticketController->getByProjId($idProj);
            $proj = $this->$projectionController->getById($id_proj);
            $capacity = $proj->getRoom()->getCapacity();

            $availableTickets = $capacity - $soldTickets;

            if ($quantity_tickets > 0 && $availableTickets >= $quantity_tickets) {
                $date = date("yy-m-d");

                $discountsArray = $this->discountController->getByDate($date);
                $creditAccounts = $this->creditAccountController->getAll();
                
                if ($discountsArray == null) {
                    $discountsArray = array();
                }
            }
            else {
                if($quantity_tickets = 0){
                    $message = "Error the number of tickets to buy is 0";
                }
                else{
                    $title = $proj->getMovie()->getTitle();
                    $message = "There are only $availableTickets tickets available for $title";
                }
                    
                $this->selectProj($id_proj,$message);
            }
        }

        public function selectProj($id_proj,$message=""){
            $proj = $this->$projectionController->getById($id_proj);
        
            $room = $proj->getRoom();
            $movie = $proj->getMovie();
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
                $message="Error adding the purchase.";
                include(VIEWS_PATH."message_view.php");
            }
            
            for ($i=0; $i <  $quantity_tickets; $i++) { 
                $ticketController->add($num,$idProj,$id_purchase);
            }    
                
            
        }

        public function getById($id_ticket){
            $id_purchase = 0;// con el ticket se busca id compra y se pasa por aca
            
            try
            {
                $this->getById($id_purchase);
            }
            catch(Exception $ex)
            {
                $message="Error getting byId the purchase.";
                include(VIEWS_PATH."message_view.php");
            }

        }        
        

    }

?>