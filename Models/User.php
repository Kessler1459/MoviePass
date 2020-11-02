<?php
    namespace Models;

    class User 
    {
        private $email;
        private $password;
        private $firstName;
        private $lastName;
        private $birthdate;
        private $userType;


        public function __construct($email,$password,$firstName,$lastName,$birthdate,$userType){
            $this->email = $email;
            $this->password = $password;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->birthdate = $birthdate;
            $this->userType = $userType;
        }


        //-----------------Getters-----------------

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

        public function getBirthdate(){
            return $this->birthdate;
        }

        public function getUserType(){
            return $this->userType;
        }

        //-----------------Setters-----------------
        
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
    
    }
?>