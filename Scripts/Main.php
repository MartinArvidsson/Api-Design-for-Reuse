<?php
require_once("API/Api.php");
class Main
{
    private static $Registerbutton = 'Main::Search';
    private static $Searchbutton = 'Main::Find';
    private static $Deletebutton = 'Main::Delete';
    
    private static $AddArtifact = 'Main::AddArtifact';
    private static $DeleteArtifact = 'Main::DeleteArtifact';
    private static $UpdateArtifact = 'Main::UpdateArtifact';
    
    
    private static $Collectiontoadd = 'Main::NewCollection';
    private static $Collectiontofind = 'Main::Collectiontofind';
    private static $Collectiontodelete = 'Main::Collectiontodelete';
    private static $ParentCollection = 'Main::ParentCollection';
    
    private static $Artifacttoadd = 'Main::NewArtifact';
    private static $ArtifactinCollection = 'Main::ArtifactinCollection';
    private static $UpdateCollectionArtifact = 'Main:UpdateCollectionArtifact';
    private static $Artifacttoupdate = 'Main::Artifacttoupdate';
    private static $Artifacttodelete = 'Main::Artifacttodelete';
    
    private $CollectionID;
    private $message;
    private $cName;
    private $cID;
    private $cParent;
    private $Childnames;
    private $ChildIds;
    public function __construct()
    {
        $this->api = new Api();
    }
    
    public function generateform()
    {
        $message = $this->api->geterror();
        $this->generateHTML($message);
    }
    //    	     <input type="text" id="'.self::$Collectiontoadd.'"  name="'.self::$Collectiontoadd.'"/>
    private function generateHTML($message)
    {
        $uri = $_SERVER["REQUEST_URI"];
        $_uri = explode("?",$uri);
        echo '
              <h1>Api example</h1>
             <p>Add Collection</p>             
             <form action="'.$this->addCollection().'"method="post" >
             <p>Name of collection</p>
    	   	 <br>
    	   	 <p>Parentcollection(Not needed)</p>
    	   	 <input type="text" id="'.self::$ParentCollection.'" name="'.self::$ParentCollection.'"/> 
    	   	 <input type="submit" name="'.self::$Registerbutton.'" id="ReigsterButton" value="Add" />
    	   	 </form>
    	   	 
    	   	 <p>Collection to find</p>
    	   	 <form action="'.$this->findCollection().'"method="post" >
             <p>ID of collection</p>
    	   	 <input type="text" id="'.self::$Collectiontofind.'"  name="'.self::$Collectiontofind.'"/> 
    	   	 <br>
    	   	 <input type="submit" name="'.self::$Searchbutton.'" value="Search" />
    	   	 </form>
    	   	 
    	   	 <p>Collection to delete</p>
    	   	 <form action="'.$this->deleteCollection().'"method="post" >
             <p>ID of collection</p>
    	   	 <input type="text" id="'.self::$Collectiontodelete.'"  name="'.self::$Collectiontodelete.'"/> 
    	   	 <br>
    	   	 <input type="submit" name="'.self::$Deletebutton.'" value="Delete" />
    	   	 </form>
    	   	 
    	   	 <form action="'.$this->addArtifact().'" method="post" enctype="multipart/form-data">
             Select image to upload:
             <input type="file" name="'.self::$Artifacttoadd.'" id="'.self::$Artifacttoadd.'">
             Select Collection:
             <input type="text" id="'.self::$ArtifactinCollection.'"  name="'.self::$ArtifactinCollection.'"/>
             <input type="submit" value="Upload Image" name="'.self::$AddArtifact.'">
             </form>
             
             <form action="'.$this->updateArtifact().'" method="post" enctype="multipart/form-data">
             Select image to upload:
             <input type="file" name="'.self::$Artifacttoupdate.'" id="'.self::$Artifacttoupdate.'">
             Select Collection:
             <input type="text" id="'.self::$UpdateCollectionArtifact.'"  name="'.self::$UpdateCollectionArtifact.'"/>
             <input type="submit" value="Upload Image" name="'.self::$UpdateArtifact.'">
             </form>
             
        ';
        
        if (count($_uri) > 1 && $_uri[1] == "Reg=True")
        {
            echo 'Sucess, here is the ID to search for the collection: '.$_SESSION["PreviousID"].'';
        }
        if (count($_uri) > 1 && $_uri[1] == "Search=True")
        {
            echo $_SESSION["ResponseCollection"];
        }
        if (count($_uri) > 1 && $_uri[1] == "ArtifactAdded=True")
        {
            echo "Artifact Added";
        }
        if (count($_uri) > 1 && $_uri[1] == "ArtifactUpdated=True")
        {
            echo "Artifact Updated";
        }
        if (count($_uri) > 1 && $_uri[1] == "ArtifactDeleted=True")
        {
            echo "Artifact Deleted";
        }
        
    }
    
    private function addCollection()
    {
        if(isset($_POST[self::$Registerbutton]))
        {
            //isset($_POST[self::$Collectiontoadd]) && 
             if(isset($_POST[self::$ParentCollection]))
             {
                $r = $this->api->getCollection($_POST[self::$ParentCollection]);
                //$_POST[self::$Collectiontoadd],
                $_SESSION["PreviousID"] = $this->api->AddCollection($r);
                header("Location:?Reg=True");
             }
        }
    }
    
    private function findCollection()
    {
        if(isset($_POST[self::$Searchbutton]))
        {
            if($_POST[self::$Collectiontofind])
            {
                $r = $this->api->getCollection($_POST[self::$Collectiontofind]);
                
                //  foreach($r->getChildNames() as $names)
                //  {
                //      $this->Childnames .= $names.', ';
                //  }
                
                 foreach($r->getChildIDs() as $ids)
                 {
                     $this->ChildIds .= $ids.', ';   
                 }
                
                $_SESSION["ResponseCollection"] = 
                 'Id: '.$r->getCollectionID().'<br>
                 ChildIDs:'.$this->ChildIds;
                
                header("Location:?Search=True");
            }
        }
    }
    
    private function deleteCollection()
    {
        if(isset($_POST[self::$AddArtifact]))
        {
            if($_POST[self::$Collectiontodelete])
            {
                $this->api->deleteCollection($_POST[self::$Collectiontodelete]);
                
                header("Location:?Delete=True");
            }
        }
    }
    
    private function addArtifact()
    {
        if(isset($_POST[self::$AddArtifact]))
        {
            if($_POST[self::$Artifacttoadd])
            {
                if($_POST[self::$ArtifactinCollection] != "")
                {
                    $this->api->AddArtifact($_POST[self::$Artifacttoadd],$_POST[self::$ArtifactinCollection]);
                    header("Location:?ArtifactAdded=True");   
                }
            }
        }
    }
    
    private function updateArtifact()
    {
        if(isset($_POST[self::$UpdateArtifact]))
        {
            if($_POST[self::$Artifacttoupdate])
            {
                if($_POST[self::$UpdateCollectionArtifact] != "")
                {
                    $this->api->UpdateArtifact($_POST[self::$Artifacttoupdate],$_POST[self::$UpdateCollectionArtifact]);
                    header("Location:?ArtifactAdded=True");   
                }
            }
        }
    }
}
