<?php
class Collection
{
    private $collectionID;
    private $CollectionName;
    private $ChildCollection = array();
    private $Artifacts = array();
    private $parent;
    
    public function __construct($name, $collectionID)
    {
        $this->collectionID = $collectionID;
        $this->CollectionName = $name;
    }
    public function SetParent(Collection $p)
    {
        $this->parent = $p;
    }
    public function GetParent()
    {
        if (isset($this->parent))
            return $this->parent;
        return null;
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
    
    public function removeArtifact($aid)
    {
        
        unset($this->Artifacts[$aid]);
    }
    
    public function AddChild($child)
    {
        $child->SetParent($this);
        $childId = $child->getCollectionID();
        if(!isset($this->ChildCollection[$childId]))
        {
            $this->ChildCollection[$childId] = $child;
        }
        
    }
    
    public function RemoveChild($childId)
    {
        if (isset($this->ChildCollection[$childId]))
        {
            unset($this->ChildCollection[$childId]);
        }
    }
    
    public function addArtifact($Artifactpath)
    {
        $this->Artifacts[$Artifactpath] = $Artifactpath;
    }
}