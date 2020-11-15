<?php
    namespace Models;
    class Ticket
    {
        private $id;
        private $nroEntrada;
        private $idProjection;
        private $qr;
        public function __construct($id="",$nroEntrada,$idProjection, $qr)
        {
            $this->id = $id;
            $this->nroEntrada = $nroEntrada;
            $this->idProjection;
            $this->qr = $qr;
        }
        /* getters */
        public function getIdProyection()
        {
            return $this->idProjection;
        }
        public function getId()
        {
            return $this->id;
        }
        public function getNroEntrada()
        {
            return $this->nroEntrada;
        }
        public function getQr()
        {
            return $this->qr;
        }
        /* setters */
        public function setId($id)
        {
            $this->id = $id;
        }
        public function setNroEntrada($nroEntrada)
        {
            $this->nroEntrada = $nroEntrada;
        }
        public function setIdProyection($idProjection)
        {
            $this->idProjection = $idProjection;
        }
        public function setQR($qr)
        {
            $this->qr = $qr;
        }
    }
?>