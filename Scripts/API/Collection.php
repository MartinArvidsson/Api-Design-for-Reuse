<?php
class Collection
{
    private $collectionID;
    private $CollectionName;
    private $ParentCollection;
    private $ChildCollectionNames = array();
    private $ChildCollectionIDs = array();
    private $Arifacts = array();
    private $todelete;
    //$CollectionName
    
    public function __construct($collectionID,$CollectionName)
    {
        $this->collectionID = $collectionID;
        $this->CollectionName = $CollectionName;
    }
    
    public function getCollectionID()
    {
        return $this->collectionID;
    }
    
    public function getCollectionName()
    {
        return $this->CollectionName;
    }
    public function getChildNames()
    {
        return $this->ChildCollectionNames;
    }
    public function getChildID()
    {
        return $this->ChildCollectionIDs;
    }
    public function addChild($collectionID,$CollectionName)
    {
        array_push($this->ChildCollectionNames,$CollectionName);
        array_push($this->ChildCollectionIDs,$collectionID);
        $this->CollectionName = "Gick in hit";
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