<?php
    namespace Models;
    class Ticket
    {
        private $id;
        private $nroEntrada;
        private $idProjection;
        public function __construct($id="",$nroEntrada,$idProjection)
        {
            $this->id = $id;
            $this->nroEntrada = $nroEntrada;
            $this->idProjection;
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
    }
?>