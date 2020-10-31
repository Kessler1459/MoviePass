<?php

namespace Models;

class Cinema{
    private $name;
    private $id;
    private $address;
    private $maxCapacity;
    private $ticketPrice;

    public function __construct($name,$id,$address,$maxCapacity,$ticketPrice) {
        $this->name=($name);
        $this->id=($id);
        $this->address=($address);
        $this->maxCapacity=($maxCapacity);
        $this->ticketPrice=($ticketPrice);
    }

    public static function compare($a, $b) {
        return strcmp($a->getName(), $b->getName());
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of maxCapacity
     */ 
    public function getMaxCapacity()
    {
        return $this->maxCapacity;
    }

    /**
     * Set the value of maxCapacity
     *
     * @return  self
     */ 
    public function setMaxCapacity($maxCapacity)
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    /**
     * Get the value of ticketPrice
     */ 
    public function getTicketPrice()
    {
        return $this->ticketPrice;
    }

    /**
     * Set the value of ticketPrice
     *
     * @return  self
     */ 
    public function setTicketPrice($ticketPrice)
    {
        $this->ticketPrice = $ticketPrice;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}

?>