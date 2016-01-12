<?php
require_once("API/Api.php");
class Main
{
    private static $Registerbutton = 'Main::Search';
    private static $Collectiontoadd = 'Main::NewCollection';
    private static $ParentCollection = 'Main::ParentCollection';
    private $CollectionID;
    private $message;
    
    public function __construct()
    {
        $this->api = new Api;
    }
    
    public function generateform()
    {
        $message = $this->api->geterror();
        $this->generateHTML($message);
    }
    
    private function generateHTML($message)
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
              <p>'.$message.'</p>
             <form action="'.$this->addCollection().'"method="post" >
             <p>Name of collection</p>
    	   	 <input type="text" id="'.self::$Collectiontoadd.'"  name="'.self::$Collectiontoadd.'"/> 
    	   	 <br>
    	   	 <p>Parentcollection(Not needed)</p>
    	   	 <input type="text" id="'.self::$ParentCollection.'" name="'.self::$ParentCollection.'"/> 
    	   	 <input type="submit" name="'.self::$Registerbutton.'" value="Add" />
    	   	 </form>
              
             </body>
          </html>
        ';
    }
    
    private function addCollection()
    {
        // if(isset($POST[self::$Registerbutton]))
        // {
        //     if(isset($POST[self::$Collectiontoadd]))
        //     {
                $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 10; $i++) {
                    $this->CollectionID .= $characters[rand(0, $charactersLength - 1)];
                }
                // $collections = $this->api->GetCollections();
                
                // foreach ($collections as $collection)
                // {
                //     if($collection == $collectionID)
                //     {
                //       throw new Exception("Folder not found");
                //     }
                // }
                //$POST[self::$Collectiontoadd]
                $this->api->AddCollection($this->CollectionID,null);
        //     }
        // }
    }
}
