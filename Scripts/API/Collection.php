<?php
class Collection
{
    private $collectionID;
    private $CollectionName;
    private $ArtifactName;
    private $ParentCollection;
    private $ChildCollection = array();
    private $Arifacts = array();
    private $todelete;
    
    public function __construct($name, $collectionID, $artifactName)
    {
        $this->collectionID = $collectionID;
        $this->CollectionName = $name;
        $this->ArtifactName = $artifactName;
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
        return $this->ArtifactName;
    }
    
    public function AddChild($child)
    {
        $childId = $child->getCollectionID();
        if(!isset($this->ChildCollection[$childId]))
        {
            $this->ChildCollection[$childId] = $child;
        }
        
    }
    public function addArtifact($artifactName)
    {
        $artifactId = $Artifactname->getArtifacts();
        if(!isset($this->ArtifactName[$artifactId] = $artifactName))
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