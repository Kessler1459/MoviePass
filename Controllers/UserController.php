<?php
    namespace Controllers;

    use Models\User;
    use DAO\UserDAO;
    
    class UserController{
        private $userDao;

        public function __construct() {
            $this->userDao;
        }
   
    

        public function logIn(){
            include VIEWS_PATH."logIn.php";
        }
        
        public function signIn(){
            include VIEWS_PATH."signIn.php";
        }


        private function startSession($user){
            session_start();
            $_SESSION['user'] = $user;
        }

        private function finishSession(){
            session_destroy();
        }

    }

?>