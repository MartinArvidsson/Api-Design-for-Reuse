<?php
class Collection
{
    private $collectionID;
    private $CollectionName;
    private $ParentCollection;
    //$CollectionName
    
    public function __construct($collectionID,$ParentCollection)
    {
        $this->collectionID = $collectionID;
        //$this->CollectionName = $CollectionName;
        $this->ParentCollection = $ParentCollection;
    }
    
    public function getCollectionID()
    {
        return $this-> collectionID;
    }
    
    public function getCollectionName()
    {
        return $this->CollectionName;
    }
    
    public function getParentCollection()
    {
        return $this->ParentCollection;
    }
}