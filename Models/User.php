<?php
    namespace Models;

    class User 
    {
        private $id;
        private $email;
        private $password;
        private $userProfile; 
        private $userRole;
        private $cinemaId;


        public function __construct($id,$email,$password,$userProfile,$userRole,$cinemaId){
            $this->id = $id;
            $this->email = $email;
            $this->password = $password;
            $this->userProfile $userProfile; 
            $this->userRole = $userRole; 
            $this->cinemaId = $cinemaId;
        }


        //-----------------Getters-----------------

        public function getId(){
            return $this->id;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getPassword(){
            return $this->password;
        }

        public function getCinemaId(){
            return $this->cinemaId;
        }

        //-----------------Setters-----------------
        
        public function setId($id){
            return $this->id = $id;
        }
        
        public function setEmail($email){
            return $this->email = $email;
        }

        public function setPassword($password){
            return $this->password = $password;
        }

        public function setUserType($userType){
            return $this->userType = $userType;
        }

        public function setCinemaId($cinemaId){
            return $this->cinemaId = $cinemaId;
        }
    
    }
?>