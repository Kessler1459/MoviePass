<?php
    namespace Models;

    class User 
    {
        private $id;
        private $email;
        private $password;
        private $firstName;
        private $lastName;
        private $birthdate;
        private $userType; // 1 - Client / 2 - Cinema owner / 3 - Admin 
        private $cinemaId;


        public function __construct($id,$email,$password,$firstName,$lastName,$birthdate,$userType,$cinemaId){
            $this->id = $id;
            $this->email = $email;
            $this->password = $password;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->birthdate = $birthdate;
            $this->userType = $userType;
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

        public function getFirstName(){
            return $this->firstName;
        }

        public function getLastName(){
            return $this->lastName;
        }

        public function getName(){
            return $this->firstName." ".$this->lastName;
        }

        public function getBirthdate(){
            return $this->birthdate;
        }

        public function getUserType(){
            return $this->userType;
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

        public function setFirstName($firstName){
            return $this->firstName = $firstName;
        }

        public function setLastName($lastName){
            return $this->lastName = $lastName;
        }

        public function setBirthdate($birthdate){
            return $this->birthdate = $birthdate;
        }

        public function setUserType($userType){
            return $this->userType = $userType;
        }

        public function setCinemaId($cinemaId){
            return $this->cinemaId = $cinemaId;
        }
    
    }
?>