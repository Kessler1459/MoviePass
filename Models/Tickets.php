<?php
    namespace Models;
    class Tickets
    {
        private $id;
        private $nroEntrada;
        public function __construct($id,$nroEntrada)
        {
            $this->id = $id;
            $this->nroEntrada = $nroEntrada;
        }
        /* getters */
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
    }
?>