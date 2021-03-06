<?php
require_once("API/Api.php");
class Main
{
    private static $Registerbutton = 'Main::Search';
    private static $Searchbutton = 'Main::Find';
    private static $Deletebutton = 'Main::Delete';
    private static $ArtifactSubmitbutton = 'Main::CreateArtifact';
    private static $RemoveArtifactbutton = 'Main::RemoveArtifactbutton';
    
    private static $NewArtifact = 'Main::NewArtifact';
    private static $DeleteArtifact = 'Main::DeleteArtifact';
    private static $UpdateArtifact = 'Main::UpdateArtifact';
    
    private static $AddCollection = "AddCollection";
    private static $FindCollection = "FindCollection";
    private static $DeleteCollection = "DeleteCollection";
    private static $AddArtifact = 'AddArtifact';
    private static $RemoveArtifact = 'RemoveArtifact';
    
    private static $Collectiontoadd = 'Main::NewCollection';
    private static $Collectiontofind = 'Main::Collectiontofind';
    private static $Collectiontodelete = 'Main::Collectiontodelete';
    private static $ParentCollection = 'Main::ParentCollection';
    
    private static $DestinationCollection = 'Main::DestinationCollection';
    private static $UpdateCollectionArtifact = 'Main:UpdateCollectionArtifact';

    
    private $CollectionID;
    private $message;
    private $cName;
    private $cID;
    private $cParent;
    public function __construct()
    {
        $this->api = new Api();
    }
    
    public function generateform()
    {
        
        $this->generateHTML(); //WIP
    }
    //    	     
    private function generateHTML()
    {
        if (isset($_GET["ACTION"]))
        {
            switch ($_GET["ACTION"])
            {
                case self::$AddCollection:
                    $this->addCollection();
                    break;
                case self::$FindCollection:
                    $this->findCollection();
                    break;
                case self::$DeleteCollection:
                    $this->deleteCollection();
                    break;
                case self::$AddArtifact:
                    $this->addArtifact();
                    break;
                case self::$RemoveArtifact:
                    $this->removeArtifact();
                    break;
            }
        }
        
        $uri = $_SERVER["REQUEST_URI"];
        $_uri = explode("?",$uri);
        echo '
              <h1>Api example</h1>
             <h2>Add Collection</h2>             
             <form action="?ACTION='.self::$AddCollection.'"method="post" >
             <p>Name of collection</p>
             <input type="text" id="'.self::$Collectiontoadd.'"  name="'.self::$Collectiontoadd.'"/><br>
    	   	 <p>Parentcollection(Not needed)</p>
    	   	 <input type="text" id="'.self::$ParentCollection.'" name="'.self::$ParentCollection.'"/> 
    	   	 <input type="submit" name="'.self::$Registerbutton.'" value="Add" />
    	   	 </form>
    	   	 
    	   	 <h2>Collection to find</h2>
    	   	 <form action="?ACTION='.self::$FindCollection.'"method="post" >
             <p>ID of collection</p>
    	   	 <input type="text" id="'.self::$Collectiontofind.'"  name="'.self::$Collectiontofind.'"/> 
    	   	 <br>
    	   	 <input type="submit" name="'.self::$Searchbutton.'" value="Search" />
    	   	 </form>
    	   	 
    	   	 <h2>Collection to delete</h2>
    	   	 <form action="?ACTION='.self::$DeleteCollection.'"method="post" >
             <p>ID of collection</p>
    	   	 <input type="text" id="'.self::$Collectiontodelete.'"  name="'.self::$Collectiontodelete.'"/> 
    	   	 <br>
    	   	 <input type="submit" name="'.self::$Deletebutton.'" value="Delete" />
    	   	 </form>
    	   	 
    	   	 <h2>Add Artifact</h2>
    	   	 <form action="?ACTION='.self::$AddArtifact.'" method="post" enctype="multipart/form-data">
             Select image to upload:
             <input type="file" name="'.self::$NewArtifact.'" id="'.self::$NewArtifact.'"><br>
             Select Collection:
             <input type="text" id="'.self::$DestinationCollection.'"  name="'.self::$DestinationCollection.'"/>
             <input type="submit" name="'.self::$ArtifactSubmitbutton.'" value="Upload Artifact"">
             </form>
             
             <h2>remove Artifact</h2>
             <form action="?ACTION='.self::$RemoveArtifact.'"method="post" >
             <p>ID of Artifact</p>
    	   	 <input type="text" id="'.self::$DeleteArtifact.'"  name="'.self::$DeleteArtifact.'"/> 
    	   	 <br>
    	   	 <input type="submit" name="'.self::$RemoveArtifactbutton.'" value="Delete" />
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
        if (count($_uri) > 1 && $_uri[1] == "Delete=True")
        {
            echo "Collection Deleted";
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
            if(isset($_POST[self::$Collectiontoadd]))
            {
                if(isset($_POST[self::$ParentCollection]))
                {
                    $_SESSION["PreviousID"] = $this->api->AddCollection($_POST[self::$Collectiontoadd], $_POST[self::$ParentCollection]);
                    header("Location:?Reg=True");
                }   
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
                
                 $childnames = "";
                 $childIds = "";
                 $totalartifacts = "";
                 $removeartifact = "";
                 $childs = $r->getChilds();
                 $_artifacts = $r->getArtifacts();
                 
                 foreach($childs as $child)
                 {
                     $childnames .= $child->getCollectionName().', ';
                     $childIds .= $child->getCollectionID().', ';
                 }
                 foreach($_artifacts as $art)
                 {
                     $name = Api::$Artifactpath.$art;
                     $totalartifacts .= "<a href='$name'>$art</a> , ";
                 }
                 
                 foreach($_artifacts as $_art)
                 {
                     $removeartifact .= $_art.', ';
                 }
                
                $_SESSION["ResponseCollection"] = 
                 'Id: '.$r->getCollectionID().'<br>'
                 .'ChildIDs: '.$childIds.'<br>'
                 .'Childnames: '.$childnames.'<br>'
                 .'Artifacts: '.$totalartifacts.'<br>'
                 .'artifact id use it to remove artifact: '.$removeartifact;
                
                header("Location:?Search=True");
            }
        }
    }
    
    private function deleteCollection()
    {
        if(isset($_POST[self::$Deletebutton]))
        {
            if($_POST[self::$Collectiontodelete])
            {
                $this->api->DeleteCollection($_POST[self::$Collectiontodelete]);
                header("Location:?Delete=True");
            }
        }
    }
    
    private function addArtifact()
    {
        if(isset($_POST[self::$ArtifactSubmitbutton]))
        {
            $this->api->AddArtifact($_POST[self::$DestinationCollection],$_FILES[self::$NewArtifact]);
            header("Location:?ArtifactAdded=True");   

        }
    }
    
    private function removeArtifact()
    {
        if(isset($_POST[self::$RemoveArtifactbutton]))
        {
            $this->api->DeleteArtifact($_POST[self::$DeleteArtifact]);
            header("Location:?ArtifactDeleted=True");   
        }
    }

}
