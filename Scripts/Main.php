<?php
require_once("API/Api.php");
class Main
{
    private static $Registerbutton = 'Main::Search';
    private static $Searchbutton = 'Main::Find';
    private static $Collectiontoadd = 'Main::NewCollection';
    private static $Collectiontofind = 'Main::Collectiontofind';
    private static $ParentCollection = 'Main::ParentCollection';
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
        $message = $this->api->geterror();
        $this->generateHTML($message);
    }
    
    private function generateHTML($message)
    {
        $uri = $_SERVER["REQUEST_URI"];
        $_uri = explode("?",$uri);
        echo '
              <h1>Api example</h1>
             <p>Add Collection</p>             
             <form action="'.$this->addCollection().'"method="post" >
             <p>Name of collection</p>
    	   	 <input type="text" id="'.self::$Collectiontoadd.'"  name="'.self::$Collectiontoadd.'"/> 
    	   	 <br>
    	   	 <p>Parentcollection(Not needed)</p>
    	   	 <input type="text" id="'.self::$ParentCollection.'" name="'.self::$ParentCollection.'"/> 
    	   	 <input type="submit" name="'.self::$Registerbutton.'" value="Add" />
    	   	 </form>
    	   	 
    	   	 <p>Collection to find</p>
    	   	 <form action="'.$this->findCollection().'"method="post" >
             <p>ID of collection</p>
    	   	 <input type="text" id="'.self::$Collectiontofind.'"  name="'.self::$Collectiontofind.'"/> 
    	   	 <br>
    	   	 <input type="submit" name="'.self::$Searchbutton.'" value="search" />
    	   	 </form>
        ';
        
        if (count($_uri) > 1 && $_uri[1] == "Reg=True")
        {
            echo 'Sucess, here is the ID to search for the collection: '.$_SESSION["PreviousID"].'';
            unset($_SESSION["PreviousID"]);
        }
        if (count($_uri) > 1 && $_uri[1] == "Search=True")
        {
            //var_dump($_SESSION["ResponseCollection"]);
            echo $_SESSION["ResponseCollection"];
        }
    }
    
    private function addCollection()
    {
        if(isset($_POST[self::$Registerbutton]))
        {
             if(isset($_POST[self::$Collectiontoadd]))
             {
                $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 10; $i++) {
                    $this->CollectionID .= $characters[rand(0, $charactersLength - 1)];
                }
                $this->api->AddCollection($this->CollectionID,$_POST[self::$Collectiontoadd],null);
                $_SESSION["PreviousID"] = $this->CollectionID;
                header("Location: " . $_SERVER['REQUEST_URI']."?Reg=True");
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
                $_SESSION["ResponseCollection"] = 'Name: '.$r->getCollectionName().' Id: '.$r->getCollectionID().' Parentcollection: '.$r->getParentCollection().'.';
                header("Location: " . $_SERVER['REQUEST_URI']."?Search=True");
            }
        }
    }
}
