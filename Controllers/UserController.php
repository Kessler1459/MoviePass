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

        private function createClient($email,$password,$firstName,$lastName,$birthdate,$userType){
            $id=(string)time();
            $client = new User($id,$email,$password,$firstName,$lastName,$birthdate,$userType,null);
            //$this->userDao->add($client);

            return $client;
        }

        private function createCinemaOwner($email,$password,$firstName,$lastName,$birthdate,$cinemaId,$userType){
            $id=(string)time();
            $cinemaOwner = new User($id,$email,$password,$firstName,$lastName,$birthdate,$userType,$cinemaId);
            $this->userDao->add($cinemaOwner);

            return $cinemaOwner;
        }

        public function verifySignIn($email,$password,$firstName,$lastName,$birthdate,$cinemaId = " ",$userType = 1){
            $user = null;
            //try{
                //$this->userDao->findEmail($email);

                if($userType == 2)
                    $user = $this->createCinemaOwner($email,$password,$firstName,$lastName,$birthdate,$cinemaId,$userType);
                else
                    $user = $this->createClient($email,$password,$firstName,$lastName,$birthdate,$userType);

                $this->startSession($user);
                include VIEWS_PATH."home_page.php";
            //}
            //catch () { }
        }

        public function verifyLogIn($email,$password){
            //try{
                $user = $this->userDao->findUser($email,$password);
                $this->startSession($user);
                
            //}
            //catch () { }
        }

        private function startSession($user){
            session_start();
            $_SESSION['Id'] = $user->getId();
            $_SESSION['name'] = $user->getName();
            $_SESSION['userType'] = $user->getUserType();
            
        }

        private function finishSession(){
            session_destroy();
        }

    }

?>