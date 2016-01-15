<?php
class Collection
{
    private $collectionID;
    private $CollectionName;
    private $ParentCollection;
    private $ChildCollection = array();
    private $Artifacts = array();
    private $todelete;
    
    public function __construct($name, $collectionID)
    {
        $this->collectionID = $collectionID;
        $this->CollectionName = $name;
    }
    public function getCollectionName()
    {
        return $this->CollectionName;
    }
    
    public function getCollectionID()
    {
        return $this->collectionID;
    }
    
    public function getChilds()
    {
        return $this->ChildCollection;
    }
    
    public function getArtifacts()
    {
        return $this->Artifacts;
    }
    
    public function AddChild($child)
    {
        $childId = $child->getCollectionID();
        if(!isset($this->ChildCollection[$childId]))
        {
            $this->ChildCollection[$childId] = $child;
        }
        
    }
    public function addArtifact($Artifactpath)
    {
        $this->Artifacts[$Artifactpath] = $Artifactpath;
    }
    
    public function removeArtifact($Artifactname)
    {
        
    }
}