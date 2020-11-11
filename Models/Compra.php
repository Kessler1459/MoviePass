<?php 
    namespace Models;

    class Compra
    {
        private $id;
        private $idUser;
        private $tickets;
        private $datosTarjeta;
        private $total;
        public function __construct($id, $idUser, $tickets, $datosTarjeta, $total)
        {
            $this->id = $id;
            $this->idUser = $idUser;
            $this->tickets = $tickets;
            $this->datosTarjeta = $datosTarjeta;
            $this->total = $total;
        }
        /* getters */
        public function getIdUser()
        {
            return $this->idUser;
        }
        public function getId()
        {
            return $this->id;
        }
        public function getTickets()
        {
            return $this->tickets;
        }
        public function getDatosTarjeta()
        {
            return $this->datosTarjeta;
        }
        public function getTotal()
        {
            return $this->total;
        }
        
        /* setters */
        public function setIdUser($idUser){
            $this->idUser = $idUser;
        }
        public function setId($id)
        {
            $this->id= $id;
        }
        public function setTickets($tickets)
        {
            $this->tickets = $tickets;
        }
        public function setDatosTarjeta($datosTarjeta)
        {
            $this->datosTarjeta = $datosTarjeta;
        }
        public function setTotal()
        {
            $this->total = $total;
        }
    }
?>