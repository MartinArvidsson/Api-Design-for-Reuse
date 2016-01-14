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
            $NewChild = new Collection($this->collectionID,$CollectionName);
            //$ParentCollection->addChild($this->collectionID,$CollectionName);
            array_push($this->Collections,$NewChild);
            $ParentID = $ParentCollection->getCollectionID();
            $ParentName = $ParentCollection->getCollectionName();
            $ChildNArray =  $ParentCollection->getChildNames();
            $ChildIArray = $ParentCollection->getChildIDs();
            array_push($ChildNArray,$CollectionName);
            array_push($ChildIArray,$this->collectionID);
            
            if (($key = array_search($ParentCollection, $this->Collections)) !== false) 
            {
                unset($this->Collections[$key]);
            }
            $newParent = new Collection($ParentID,$ParentName);
            $newParent->addChild($ChildIArray,$ChildNArray);
            array_push($this->Collections,$newParent);
            //Pusha in updaterade parentcollection.
        }
        else 
        {
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
                        $childnames = $c->getChildNames();
                        $ParentName = $c->getCollectionName();
                        foreach ($childarray as $ids) 
                        {
                            // code...
                             if (array_search($ids,self::GetCollections()) == false) 
                            {
                                unset($childarray[$ids]);
                            }
                        }
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
                //Hämta alla undercollections, lägg i array, kör array_Search genom hela den arrayen också för att ta bort undercolelctions...
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