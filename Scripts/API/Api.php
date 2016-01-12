<?php
require_once("Collection.php");

class Api
{
    private static $Collectionpath = "../Collections/Collections.bin";
    private $Artifactpath = "../Artifacts";
    private $Collections = array();
    private $serialized;    
    private $errormessage;
    //$CollectionName

    public function AddCollection($collectionID,$CollectionName,$ParentCollection)
    {
        $errormessage = "TEST";
        $this-> Collections = self::GetCollections();
        
        if($this->Collections == false)
        {
            $this->Collections = array();
        }
        
        //$CollectionName
        array_push($this->Collections,new Collection($collectionID,$CollectionName,$ParentCollection));
        
        $this->serialized = serialize($this->Collections);
        
        
        $this->errormessage = $collectionID;
        file_put_contents(self::$Collectionpath, $this->serialized);
    }
    
    private function GetCollections()
    {
        return unserialize(file_get_contents(self::$Collectionpath));
    }
    
    public function getCollection($IDtoval)
    {
        foreach ($this->GetCollections() as $c) {
                
                if($c->getCollectionID() == $IDtoval)
                {
                  return $c;
                }
            }
    }
    
    public function DeleteCollection()
    {
        
    }
    
    public function AddArtifact()
    {
        
    }
    
    public function UpdateArtifact()
    {
        
    }
    
    public function DeleteArtifact()
    {
        
    }
    
    public function geterror()
    {
        return $this->errormessage;
    }
}