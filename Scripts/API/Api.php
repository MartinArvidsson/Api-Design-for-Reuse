<?php
require_once("Collection.php");

class Api
{
    private static $Collectionpath = "../Collections/Collections.bin";
    private $Artifactpath = "../Artifacts";
    private $Collections = array();
    private $serialized;    
    private $errormessage;
    private $collectionID;
    private $todelete;
    //$CollectionName

    public function AddCollection($CollectionName,$ParentCollection)
    {
        $this-> Collections = self::GetCollections();
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) 
        {
            $this->collectionID .= $characters[rand(0, $charactersLength - 1)];
        }
        
        if($this->Collections == false)
        {
            $this->Collections = array();
        }
        
        if(!$parentcollection ="" || !$parentcollection == null)
        {
            $c = self::getCollection($parentcollection);
            $NewChild = new Collection($this->collectionID,$CollectionName);
            $c->addChild();
        }
        else 
        {
            //$CollectionName
            array_push($this->Collections,new Collection($this->collectionID,$CollectionName));   
        }
        $this->serialized = serialize($this->Collections);
        
        file_put_contents(self::$Collectionpath, $this->serialized);
        
        return $this->collectionID;
    }
    
    private function GetCollections()
    {
        return unserialize(file_get_contents(self::$Collectionpath));
    }
    
    public function getCollection($IDtoval)
    {
        foreach (self::GetCollections() as $c) 
        {
            if($c->getCollectionID() == $IDtoval)
            {
              return $c;
            }
        }
    }
    
    public function DeleteCollection($IDtodelete)
    {
        $this->Collections = self::GetCollections();
        
        foreach ($this->Collections as $c) 
        {
            if($c->getCollectionID() == $IDtodelete)
            {
                $this->todelete = $c;
            }
        }
        if (($key = array_search($this->todelete, $this->Collections)) !== false) 
        {
            unset($this->Collections[$key]);
        }
        
        $this->serialized = serialize($this->Collections);
        file_put_contents(self::$Collectionpath, $this->serialized);
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