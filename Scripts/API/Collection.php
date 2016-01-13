<?php
class Collection
{
    private $collectionID;
    private $CollectionName;
    private $ParentCollection;
    private $ChildCollectionNames = array();
    private $ChildCollectionIDs = array();
    private $Arifacts = array();
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
        return $this->ChildCollectionNames[0];
    }
    public function getChildID()
    {
        return $this->ChildCollectionIDs[0];
    }
    public function addChild($collectionID,$CollectionName)
    {
        array_push($this->ChildCollectionNames,$CollectionName);
        array_push($this->ChildCollectionIDs,$collectionID);
    }
}