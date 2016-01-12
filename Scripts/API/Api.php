<?php
require_once("../API/Collection.php");
class Api
{
    private $Collectionpath = "../Collections/Collections.bin";
    private $Artifactpath = "../Artifacts";
    private $Collections = array();
    private $serialized;    

    public function AddCollection($collectionID,$CollectionName,$ParentCollection)
    {
        $this-> Collections = self::GetCollections();
        
        if($this->Collections == false)
        {
            $this->Collections = array();
        }
        
        
        array_push($this->Collections,new Collection($collectionID,$CollectionName,$ParentCollection));
        
        $this->serialized = serialize($this->Collections);
        
        
        
        file_put_contents(self::$Collectionpath, $this->Collections);
    }
    
    public function GetCollections()
    {
        return unserialize(file_get_contents(self::$Collectionpath));
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
}