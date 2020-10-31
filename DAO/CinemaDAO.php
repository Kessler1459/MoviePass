<?php

namespace DAO;

use Models\Cinema;

//a json
class CinemaDAO{
    private $cinemas=array();
    private $filename;

    public function __construct() {
        $this->filename = ROOT."/data/cinemas.json";
    }

    public function add($cinema)
    {
        $this->retrieveData();
        $this->cinemas[]=$cinema;
        $this->saveData();
    }

    public function modify($modifiedCinema){
        $this->remove($modifiedCinema->getId());
        $this->add($modifiedCinema);
    }

    public function remove($id){
        $this->retrieveData();
        $flag=false;
        $i=0;
        while($flag == false && $i<count($this->cinemas)){
            if ($id == $this->cinemas[$i]->getId()) {
                unset($this->cinemas[$i]);
                $this->saveData();
                $flag=true;
            }
            $i++;
        }
        return $flag;
    }

    public function getAll()
    {
        $this->retrieveData();
        return $this->cinemas;
    }

    public function getCinema($id){
        $this->retrieveData();
        $flag=false;
        $i=0;
        $cinema=false;
        while ($flag==false && $i<count($this->cinemas)) {
            if ($this->cinemas[$i]->getId() == $id) {
                $cinema=$this->cinemas[$i];
                $flag=true;
            }
            $i++;
        }
        return $cinema;
    }

    private function saveData(){
        $toEncode=array();
        foreach ($this->cinemas as $value) {
            $valueArr["name"]=$value->getName();
            $valueArr["id"]=$value->getId();
            $valueArr["address"]=$value->getAddress();
            $valueArr["maxCapacity"]=$value->getMaxCapacity();
            $valueArr["ticketPrice"]=$value->getTicketPrice();
            $toEncode[]=$valueArr;
        }
        $jsonContent=json_encode($toEncode,JSON_PRETTY_PRINT);
        file_put_contents($this->filename,$jsonContent);
    }


    private function retrieveData()
    {
        $this->cinemas=array();
        if (file_exists($this->filename)) {
            $jsonContent=file_get_contents($this->filename);
            $array=($jsonContent)?json_decode($jsonContent,true):array();  
            foreach ($array as $cinema) {
                $newCinema=new Cinema($cinema["name"],$cinema["id"],$cinema["address"],$cinema["maxCapacity"],$cinema["ticketPrice"]);
                $this->cinemas[]=$newCinema;
            }
        }
    }
}

?>