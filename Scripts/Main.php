<?php
require_once("Api.php");
class Main
{
    private static $Registerbutton = 'Main::Search';
    private static $Collectiontoadd = 'Main::NewCollection';
    private static $ParentCollection = 'Main::ParentCollection';
    private $CollectionID;
    public function __construct()
    {
        $Api = new Api;
    }
    
    public function generateHTML()
    {
        echo '<!DOCTYPE html>
          <html>
            <head>
              <meta charset="utf-8">
              <title>API example</title>
            </head>
            <body>
              <h1>Api example</h1>
              <p>Add Collection</p>
             <form method="post" >
             <p>Name of collection</p>
    	   	 <input type="text" id="'.self::$Collectiontoadd.'"  name="'.self::$Collectiontoadd.'"/> 
    	   	 <br>
    	   	 <p>Parentcollection(Not needed)</p>
    	   	 <input type="text" id="'.self::$ParentCollection.'" name="'.self::$ParentCollection.'"/> 
    	   	 <input type="submit" name="'.self::$Registerbutton.'" value="Search" />
    	   	 </form>
              
             </body>
          </html>
        ';
        
        if(isset($POST[self::$Registerbutton]))
        {
            if(isset($POST[self::$Collectiontoadd]) && !isset($POST[self::$ParentCollection]))
            {
                for ($i = 0; $i < 5; $i++) 
                {
                     $this->$CollectionID += rand(0,9);
                }
                
                $files = $this->$api->GetCollections();
                
                foreach ($files as $fileName)
                {
                    if($fileName == $collectionID)
                    {
                      throw new Exception("FolderID Exist");
                    }
                }
                $this->$api->AddCollection($collectionID,$POST[self::$Collectiontoadd],null);
                echo "This is the collectionid:$CollectionID , you need it to get the folder";
            }
            if(!isset($POST[self::$Collectiontoadd]) && isset($POST[self::$ParentCollection]))
            {
                echo "Need a collectionname";
            }
        }

    }
}
