<?php
    namespace Controllers;

    use Models\User as User;
    use Models\UserProfile as UserProfile;
    use Models\UserRole as UserRole;
    use DAO\UserDAO as UserDAO;
    use Controllers\HomeController as HomeController;
    use Controllers\CinemaController as CinemaController;
    
    class UserController{
        private $userDao;

        public function __construct() {
            $this->userDao = new UserDao();
        }
   
    

        public function logIn($message = ""){
            include VIEWS_PATH."logIn.php";
        }
        
        public function signIn($message = ""){
            include VIEWS_PATH."signIn.php";
        }

        public function signInCinemaOwner($message = ""){
            include VIEWS_PATH."signIn_cinemaOwner.php";
        }


        private function createClient($email,$password,$firstName,$lastName,$dni,$userType){
            $id=(string)time();
            $userProfile = new UserProfile($firstName,$lastName,$dni);
            $userRole = new UserRole($userType,"Client");
            $client = new User($id,$email,$password,$userProfile,$userRole);
            try{
                $this->userDao->add($client);
            }
            catch (\Exception $ex) {
                throw $ex;
            }

            return $client;
        }

        private function createCinemaOwner($email,$password,$firstName,$lastName,$dni,$userType){
            $id=(string)time();
            $userProfile = new UserProfile($firstName,$lastName,$dni);
            $userRole = new UserRole($userType,"Cinema Owner");
            $cinemaOwner = new User($id,$email,$password,$userProfile,$userRole);
            
            try{
                $this->userDao->add($cinemaOwner);
            }
            catch (\Exception $ex) {
                throw $ex;
            }
            

            return $cinemaOwner;
        }

        public function verifySignIn($email,$password,$firstName,$lastName,$dni,$userType = 9){            
            $user = null;
            try{
                
                if($userType == 2){
                    $user = $this->createCinemaOwner($email,$password,$firstName,$lastName,$dni,$userType);
                    $this->startSession($user);

                    $cinemaController = new CinemaController();
                    $cinemaController->showAddCinema();
                    
                }else{
                    $user = $this->createClient($email,$password,$firstName,$lastName,$dni,$userType);
                    $this->startSession($user);
                    $homeController = new HomeController();
                    $homeController->showHome();
                }
                    

                
                    
            }
            catch (\Exception $ex) {
                $message = "This email is already used";
                
                if ($userType == 1) {
                    $this->signIn($message);
                } else {
                    $this->signInCinemaOwner($message);
                }
                
                
            }
        }

        public function verifyLogIn($email,$password){
            $user = null;
            try{
                $user = $this->userDao->findUser($email,$password);
                if ($user == null) {
                    $message = "The username or password is incorrectly.Try again";
                    $this->logIn($message);
                } else {
                    $this->startSession($user);
                    $this->homeController->showHome(); 
                }   
            }
            catch (\Exception $ex) {
                $message = "An unknown error has occurred";
                $this->logIn($message);
            }
        }

        private function startSession($user){
            $this->finishSession();
            session_start();
            $_SESSION['Id'] = $user->getId();
            $_SESSION['name'] = $user->getUserProfile()->getName();
            $_SESSION['userType'] = $user->getUserRole()->getUserType();
            
        }

        private function finishSession(){
            if(session_status () != 2){
                session_start();  
              }
            session_destroy();
        }

    }

?>