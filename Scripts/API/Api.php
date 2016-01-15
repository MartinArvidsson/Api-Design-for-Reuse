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

    //$CollectionName,
    public function AddCollection($ParentCollection)
    {
        $this->Collections = self::GetCollections();
        if($this->Collections == false)
        {
            $this->Collections = array();
        }
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) 
        {
            $this->collectionID .= $characters[rand(0, $charactersLength - 1)];
        }
        if($ParentCollection != null)
        {
            //,$CollectionName
            $NewChild = new Collection($this->collectionID);
            //$ParentCollection->addChild($this->collectionID,$CollectionName);
            array_push($this->Collections,$NewChild);
            $ParentID = $ParentCollection->getCollectionID();
            //$ParentName = $ParentCollection->getCollectionName();
            //$ChildNArray =  $ParentCollection->getChildNames();
            $ChildIArray = $ParentCollection->getChildIDs();
            //array_push($ChildNArray,$CollectionName);
            array_push($ChildIArray,$this->collectionID);
            
            if (($key = array_search($ParentCollection, $this->Collections)) !== false) 
            {
                unset($this->Collections[$key]);
            }
            //,$ParentName
            $newParent = new Collection($ParentID);
            //,$ChildNArray
            $newParent->addChild($ChildIArray);
            array_push($this->Collections,$newParent);
            //Pusha in updaterade parentcollection.
        }
        else 
        {
            //,$CollectionName
            array_push($this->Collections,new Collection($this->collectionID));   
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
        if($IDtoval != null)
        {
            foreach (self::GetCollections() as $c) 
            {
                if($c != null)
                {
                 if($c->getCollectionID() == $IDtoval)
                    {
                        $ParentID = $c->getCollectionID();
                        $childarray = $c->getChildIDs();
                        //$childnames = $c->getChildNames();
                        //$ParentName = $c->getCollectionName();
                        foreach ($childarray as $ids) 
                        {
                            // code...
                            if (array_search($ids,self::GetCollections()) == false) 
                            {
                                unset($childarray[$ids]);
                            }
                        }
                        $newParent = new Collection($ParentID);
                        $newParent->addChild($childarray);
                        array_push($this->Collections,$newParent);
                        
                        return $newParent;
                    }   
                }
            }
            //När den hämtas kolla att alla saker i listan med undercollections finns, annars ta bort elementet.
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
        foreach ($this->todelete->getChildIDs() as $childs) {
            if (($key = array_search($childs, $this->todelete->getChildIDs())) !== false) 
            {
                unset($this->Collections[$key]);
            }
        }
        if (($key = array_search($this->todelete, $this->Collections)) !== false) 
        {
            unset($this->Collections[$key]);
        }
        
        $this->serialized = serialize($this->Collections);
        file_put_contents(self::$Collectionpath, $this->serialized);
    }
    
    public function AddArtifact($Artifact,$CollectionID)
    {
        
    }
    
    public function UpdateArtifact($Artifact,$CollectionID)
    {
        
    }
    
    public function DeleteArtifact($Artifact,$CollectionID)
    {
        
    }
}