<?php
    namespace Controllers;
    
    class CreditAccountController
    {
        private $creditAccountDao;

        public function __construct() {
            $this->creditAccountDao;
        }

        
        public function getAll(){
            try{
                return $this->creditAccountDao->getAll();
            }
            catch(Exception $e){
                $message="Error getting the accounts.";
                include(VIEWS_PATH."message_view.php");
            }
        }
    
        public function getById($idAccount){
            try{
                return $this->creditAccountDao->getById($idAccount);
            }
            catch(Exception $e){
                $message="Error getting the account.";
                include(VIEWS_PATH."message_view.php");
            }
        }
        
    }
    

?>

