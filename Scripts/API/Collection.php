<?php
class Collection
{
    private $collectionID;
    //private $CollectionName;
    private $ParentCollection;
    //private $ChildCollectionNames = array();
    private $ChildCollectionIDs = array();
    private $Arifacts = array();
    private $todelete;
    //$CollectionName
    //,$CollectionName
    public function __construct($collectionID)
    {
        $this->collectionID = $collectionID;
        //$this->CollectionName = $CollectionName;
    }
    
    public function getCollectionID()
    {
        return $this->collectionID;
    }
    
    // public function getCollectionName()
    // {
    //     return $this->CollectionName;
    // }
    // public function getChildNames()
    // {
    //     return $this->ChildCollectionNames;
    // }
    public function getChildIDs()
    {
        return $this->ChildCollectionIDs;
    }
    //,$CollectionNames
    public function addChild($collectionIDs)
    {
        foreach($collectionIDs as $Id)
        {
            if(!in_array($Id,$this->ChildCollectionIDs))
            {
                array_push($this->ChildCollectionIDs,$Id);
            }
        }
        // foreach($CollectionNames as $Names)
        // {
        //     if(!in_array($Names,$this->ChildCollectionNames))
        //     {
        //         array_push($this->ChildCollectionNames,$Names);
        //     }
        // }
    }
    public function addArtifact($Artifactname)
    {
        array_push($this->Artifacts,$Artifactname);
    }
    private function getArtifacts()
    {
        return $this->Artifacts();
    }
    
    public function removeArtifact($Artifactname)
    {
        foreach (self::getArtifacts() as $art) 
        {
            if($Artifactname == $art)
            {
                $this->todelete = $art;
            }
        }
        if (($key = array_search($this->todelete, self::getArtifacts())) !== false) 
        {
            unset($this->Artifacts[$key]);
        }
    }
}