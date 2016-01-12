<?php
class Collection
{
    private $collectionID;
    private $CollectionName;
    private $ParentCollection;
    
    public function __construct($collectionID,$CollectionName,$ParentCollection)
    {
        $this->collectionID = $collectionID;
        $this->CollectionName = $CollectionName;
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