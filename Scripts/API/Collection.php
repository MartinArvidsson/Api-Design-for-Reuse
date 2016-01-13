<?php
class Collection
{
    private $collectionID;
    private $CollectionName;
    private $ParentCollection;
    private $ChildCollections = array();
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
    
    public function addChild()
    {
        array_push($this->ChildCollections,new Collection($this->collectionID,$CollectionName));
    }
}