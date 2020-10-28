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

        private function createClient($email,$password,$firstName,$lastName,$birthdate){
            $id=(string)time();
            $client = new User($id,$email,$password,$firstName,$lastName,$birthdate,1,null);
            $this->userDao->add($client);
        }

        private function createCinemaOwner($email,$password,$firstName,$lastName,$birthdate,$cinemaId){
            $id=(string)time();
            $cinemaOwner = new User($id,$email,$password,$firstName,$lastName,$birthdate,2,$cinemaId);
            $this->userDao->add($cinemaOwner);
        }

        public function verifySignIn(){
            try{
                $this->userDao->findEmail($email);
                
            }
            catch (\Throwable $th) {
                //throw $th;
            }
        }

        public function verifyLodIn(){
            try{
                $user = $this->userDao->findUser($email,$password);
                startSession($user);
            }
            catch (\Throwable $th) {
                //throw $th;
            }
        }

        private function startSession($user){
            session_start();
            $_SESSION['name'] = $user->getName();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['birthdate'] = $user->getBirthdate();
            $_SESSION['userType'] = $user->getUserType();
            $_SESSION['cinemaId'] = $user->getCinemaId();
      
        }

        private function finishSession(){
            session_destroy();
        }

    }

?>