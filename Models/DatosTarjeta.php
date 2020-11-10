<?php
    namespace Models;

    class DatosTarjeta{
        private $numeroTarjeta;
        private $tipoTarjeta;
        private $nombreEmpresa;
        public function __construct($numeroTarjeta,$tipoTarjeta,$nombreEmpresa)
        {
            $this->numeroTarjeta = $numeroTarjeta;
            $this->tipoTarjeta = $tipoTarjeta;
            $this->nombreEmpresa = $nombreEmpresa;
        }
        /* getters */
        public function getNumeroTarjeta()
        {
            return $this->numeroTarjeta;
        }
        public function getTipoTarjeta()
        {
            return $this->numeroTarjeta;
        }
        public function getNombreEmpresa()
        {
            return $this->nombreEmpresa;
        }
        /* setters */
        public function setNumeroTarjeta($numeroTarjeta)
        {
            $this->numeroTarjeta = $numeroTarjeta;
        }
        public function setTipoTarjeta($tipoTarjeta)
        {
            $this->tipoTarjeta = $tipoTarjeta;
        }
        public function setNombreEmpresa($nombreEmpresa)
        {
            $this->nombreEmpresa = $nombreEmpresa;
        }
    }
?>