<?php

namespace Models;

class Cinema{
    private $name;
    private $id;
    private $province;
    private $city;
    private $address;
    private $rooms;

    public function __construct($name,$id,$province,$city,$address,$rooms=[]) {
        $this->name=$name;
        $this->id=$id;
        $this->province=$province;
        $this->city=$city;
        $this->address=$address;
        $this->rooms=$rooms;
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

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of province
     */ 
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set the value of province
     *
     * @return  self
     */ 
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get the value of rooms
     */ 
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set the value of rooms
     *
     * @return  self
     */ 
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }
}

?>