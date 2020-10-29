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
            $this->userDao->add($client);
        }

        private function createCinemaOwner($email,$password,$firstName,$lastName,$birthdate,$cinemaId,$userType){
            $id=(string)time();
            $cinemaOwner = new User($id,$email,$password,$firstName,$lastName,$birthdate,$userType,$cinemaId);
            $this->userDao->add($cinemaOwner);
        }

        public function verifySignIn(){
            try{
                $this->userDao->findEmail($email);

                if(){
                    createCinemaOwner($email,$password,$firstName,$lastName,$birthdate,$cinemaId,$userType) 
                }else{
                    createClient($email,$password,$firstName,$lastName,$birthdate,$userType)
                }
                startSession($user);
                include VIEWS_PATH."logIn.php";
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
            $_SESSION['Id'] = $user->getId();
            $_SESSION['name'] = $user->getName();
            $_SESSION['userType'] = $user->getUserType();
            
        }

        private function finishSession(){
            session_destroy();
        }

    }

?>