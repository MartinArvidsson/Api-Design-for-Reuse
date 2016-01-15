<?php
require_once("Collection.php");

class Api
{
    private static $Collectionpath = "../Collections/Collections.bin";
    private $Artifactpath = "../Artifacts";
    private $Collections = array();
    private $serialized;
    private $collectionID;
    private $todelete;
    //$CollectionName
    
    public function __construct()
    {
        $this->Collections = $this->GetCollections();
        if($this->Collections == false)
        {
            $this->Collections = array();
        }
    }
    
    //$CollectionName,
    public function AddCollection($name, $ParentID = null)
    {
        
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) 
        {
            $this->collectionID .= $characters[rand(0, $charactersLength - 1)];
        }
        if($ParentID != null)
        {
            $NewChild = new Collection($name,$this->collectionID);
            $parent = $this->getCollection($ParentID);
            $parent->AddChild($NewChild);
            $this->Collections[$this->collectionID] = $NewChild;
        }
        else 
        {
            //,$CollectionName
            $this->Collections[$this->collectionID] = new Collection($name,$this->collectionID);
            
        }
        
        $this->serialized = serialize($this->Collections);
        file_put_contents(self::$Collectionpath, $this->serialized);
        return $this->collectionID;
    }
    
    private function GetCollections()
    {
        return unserialize(file_get_contents(self::$Collectionpath));
    }
    
    public function getCollection($Id)
    {
        if (isset($this->Collections[$Id]))
        {
            return $this->Collections[$Id];
        }
        else
        {
            throw new Exception("No collection with that ID");
        }
    }
    
    public function DeleteCollection($collectionID)
    {
        if (isset($this->Collections[$collectionID]))
        {
            $this->_deleteCollection($this->Collections[$collectionID]);
        }
        
        $this->serialized = serialize($this->Collections);
        file_put_contents(self::$Collectionpath, $this->serialized);
    }
    
    private function _deleteCollection($collection)
    {
        $children = $collection->getChilds();
        foreach ($children as $child) {
            $this->_deleteCollection($child);
            unset($children[$child->getCollectionID()]);
        }
        unset($this->Collections[$collection->getCollectionID()]);
    }
    
    public function AddArtifact($CollectionID, $Artifact)
    {
        if (isset($this->Collections[$CollectionID]))
        {
            var_dump($Artifact);
            die();
            //Hantera fil
            //Spara objectet i Artifacts.
            //Spara namnet på Collectionen.
            //Lägg till på Collectionobjectet.
            $collection = $this->getCollection($CollectionID);
            $collection->addArtifact($Artifact);
        }
        else
        {
            throw new Exception("No collection with that ID");
        }
    }
    
    public function UpdateArtifact($CollectionID,$Artifact)
    {
        
    }
    
    public function DeleteArtifact($CollectionID,$Artifact)
    {
        
    }
}