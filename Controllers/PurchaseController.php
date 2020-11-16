<?php

    namespace Controllers;

    use DAO\PurchaseDAO as UserDAO;

    class PurchaseController{
        private $purchaseDAO;

        public function __construct() {
            $this->purchaseDao = new PurchaseDao();
        }

        public function add($quantity_tikets,$discount,$date,$total) {
            try
            {
                $this->add($quantity_tikets,$discount,$date,$total);
            }
            catch(Exception $ex)
            {
                throw $ex;
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