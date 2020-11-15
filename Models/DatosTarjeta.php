<?php
    namespace Models;

    class DatosTarjeta{
        private $docType;
        private $docNumber;
        private $transactionAmount;
        private $paymentMethodId;
        private $token;
        public function __construct($docType, $docNumber, $transactionAmount, $token, $paymentMethodId)
        {
            $this->docType = $docType;
            $this->docNumber = $docNumber;
            $this->transactionAmount = $transactionAmount;
            $this->token = $token;
            $this->paymentMethodId = $paymentMethodId;
        }
        /* getters */
        public function getDocType(){return $this->docType;}
        public function getDocNumber(){return $this->docNumber;}
        public function getTransactionAmount(){return $this->transactionAmount;}
        public function getPaymentMethodId(){return $this->paymentMethodId;}
        public function getToken(){return $this->token;}

        /* setters */
        public function setDocType($docType){$this->docType = $docType;}
        public function setDocNumber($docNumber){$this->docNumber = $docNumber;}
        public function setTransactionAmount($transactionAmount){$this->transactionAmount = $transactionAmount;}
        public function setPaymentMethodId($paymentMethodId){$this->paymentMethodId = $paymentMethodId;}
        public function setToken($token){ $this->token = $token;}
    }
?>