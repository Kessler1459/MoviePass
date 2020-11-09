<?php
    namespace Controllers;

    use Models\User as User;
    use Models\UserProfile as UserProfile;
    use Models\UserRole as UserRole;
    use DAO\UserDAO as UserDAO;
    
    class UserController{
        private $userDao;

        public function __construct() {
            $this->userDao = new UserDao();
        }
   
    

        public function logIn(){
            include VIEWS_PATH."logIn.php";
        }
        
        public function signIn(){
            include VIEWS_PATH."signIn.php";
        }

        private function createClient($email,$password,$firstName,$lastName,$dni,$userType){
            $id=(string)time();
            $userProfile = new UserProfile($firstName,$lastName,$dni);
            $userRole = new UserRole($userType,'Client');
            $client = new User($id,$email,$password,$userProfile,$userRole);
            try{
                $this->userDao->add($client);
            }
            catch (Exception $ex) {
                throw $ex;
            }

            return $client;
        }

        private function createCinemaOwner($email,$password,$firstName,$lastName,$dni,$userType){
            $id=(string)time();
            $userProfile = new UserProfile($firstName,$lastName,$dni);
            $userRole = new UserRole($userType,'Cinema Owner');
            $cinemaOwner = new User($id,$email,$password,$firstName,$lastName,$dni,$userType);
            try{
                $this->userDao->add($cinemaOwner);
            }
            catch (Exception $ex) {
                throw $ex;
            }
            

            return $cinemaOwner;
        }

        public function verifySignIn($email,$password,$firstName,$lastName,$dni,$userType = 1){
            $user = null;
            $exist = false;
            try{
                //$exist = $this->userDao->findEmail($email);
                if ($exist == false) {

                    if($userType == 2)
                        $user = $this->createCinemaOwner($email,$password,$firstName,$lastName,$dni,$userType);
                    else
                        $user = $this->createClient($email,$password,$firstName,$lastName,$dni,$userType);

                    $this->startSession($user);
                    include VIEWS_PATH."home_page.php"; 

                } else {
                    $message = "This email is already used";
                    $this->signIn();
                }
                
                    
            }
            catch (Exception $ex) { 
                $message = "This email is already used";
                $this->signIn();
            }
        }

        public function verifyLogIn($email,$password){
            $user = null;
            try{
                $user = $this->userDao->findUser($email,$password);
                $this->startSession($user);
                
            }
            catch (Exception $ex) { }
        }

        private function startSession($user){
            session_start();
            $_SESSION['Id'] = $user->getId();
            $_SESSION['name'] = $user->getUserProfile()->getName();
            $_SESSION['userType'] = $user->getUserRole()->getUserType();
            
        }

        private function finishSession(){
            session_destroy();
        }

    }

?>