<?php
namespace Models;

use JsonSerializable;

class Projection implements JsonSerializable
{
    private $id;
    private $movie;
    private $date;
    private $hour;
    private $room;
    private $tickets;

    public function __construct($id,$movie,$date,$hour,$room,$tickets="") {
        $this->id = $id;
        $this->movie = $movie;
        $this->date = $date;
        $this->hour = $hour;
        $this->tickets = $tickets;
    }


    public function getId(){return $this->id;}
    public function getMovie(){return $this->movie;}
    public function getDate(){return $this->date;}
    public function getHour(){return $this->hour;}
    public function getRoom(){return $this->room;}
    public function getTickets(){return $this->tickets;}

    public function setMovie($movie){$this->movie = $movie;}
    public function SetId($id){$this->id = $id;}
    public function setDate($date){$this->date = $date;}
    public function setHour($hour){$this->hour = $hour;}
    public function setRoom($room){$this->room = $room;}
    public function setTickets($tickets){$this->tickets = $tickets;}
    
    public function jsonSerialize()
    {
        $vars=get_object_vars($this);
        return $vars;
    }
    


}

?>