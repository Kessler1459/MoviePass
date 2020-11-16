<?php 

class Ticket{
    private $id;
    private $num;
    private $qr;

    public function __construct($id,$num,$qr) {
        $this->id = $id;
        $this->num = $num;
        $this->qr = $qr;
    }

    /**
     * Get the value of num
     */ 
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set the value of num
     *
     * @return  self
     */ 
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }
}

?>