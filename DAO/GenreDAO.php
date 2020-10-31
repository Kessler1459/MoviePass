<?php

namespace DAO;

use Models\Genre;

class GenreDAO{
    private $genres=array();
    private $filename;

    public function __construct() {
        $this->filename = ROOT."/data/genres.json";
    }

    public function add($genre)
    {
        $this->retrieveData();
        $this->genres[]=$genre;
        $this->saveData();
    }

    public function getById($id){
        $this->retrieveData();
        $flag=false;
        $i=0;
        while($flag == false && $i<count($this->genres)){
            if ($this->genres[$i]->getId() == $id) {
                $flag=true;
                $genreName=$this->genres[$i]->getName();
            }
            $i++;
        }
        if ($flag == false) {
            return false;
        }
        else{
            $newGenre=new Genre($id,$genreName);
            return $newGenre;
        }
    }

    public function getAll()
    {
        $this->retrieveData();
        return $this->genres;
    }

    private function saveData(){
        $toEncode=array();
        foreach ($this->genres as $value) {
            $valueArr["name"]=$value->getName();
            $valueArr["id"]=$value->getId();
            $toEncode[]=$valueArr;
        }
        $jsonContent=json_encode($toEncode,JSON_PRETTY_PRINT);
        file_put_contents($this->filename,$jsonContent);
    }


    private function retrieveData()
    {
        $this->genres=array();
        if (file_exists($this->filename)) {
            $jsonContent=file_get_contents($this->filename);
            $array=($jsonContent)?json_decode($jsonContent,true):array();  
            foreach ($array as $genre) {
                $newGenre=new Genre($genre["id"],$genre["name"]);
                $this->genres[]=$newGenre;
            }
            
        }
    }
}

?>