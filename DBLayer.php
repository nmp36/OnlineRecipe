<?php
/**
* Description of DBLayer
*This class is responsible for making DB Connection , create ,update ,delete or insert operations.
* This is being used through out application.
* @author Dishna
*/
class DBLayer
{
    //Create method to make database connection
    private $i = 0;
    private $colName;
    private $conn;
    private $Collect;
    private $dbObj;
    private $Id;
    private $abc;
    Protected $RecipeArray;
    private $arr;
    private $criteria_update;
    
    function __construct()
    {
    $username = 'kwilliams';
    $password = 'mongo1234';
    $conn= singleton::singleton($username, $password);
    $this->dbObj = $conn->recipe;
    }
    Function setCollectionObj($colName)
    {
    $this->Collect=$this->dbObj->selectCollection("$colName");
    }
    //Retrieve Collection Method
    public function get_CollectionObject($colName)
    {
    $this->Collect=$this->dbObj->selectCollection("$colName");
    $cursor = $this->Collect->find();
    return $cursor;
    }
    public function get_CollectionObjectbyID($ID)
    {
        $this->Collect=$this->dbObj->selectCollection("Thingtest");
        $ThingObj = $this->Collect->findone(array("_id" => new MongoId($ID)));
            
        $this->i=0;
        
        $CWback=$this->dbObj->CreativeWorkTest;
        //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
        $CWbackResult = $CWback->findone(array("_id" => $ThingObj['_id']));
        $recipeback=$this->dbObj->RecipeTest;
        $RecipeResult = $recipeback->findOne(array("_id" => $CWbackResult['_id']));
        /*Creating array of one recipe document*/
        $this->RecipeArray=array(
             "Thing"=>$ThingObj,
             "CreativeWork"=>$CWbackResult,
             "Recipe"=>$RecipeResult
             );
         
        $this->arr[$this->i]=$this->RecipeArray;
        $this->i=$this->i+1;

         return $this->arr;

       
    }
    public function get_AdvancedSearch($srchCriteria)
    {
        //print_r($srchCriteria);
        $thingBack=$this->dbObj->Thingtest;
        $CWback=$this->dbObj->CreativeWorkTest;
        $recipeback=$this->dbObj->RecipeTest;
        $this->i=0;
        
        if (is_null($srchCriteria))
        {
         $cursor = $thingBack->find();   
          
        }
        else
        {
        /*Check first thing*/
            if(key_exists("Thing", $srchCriteria))
            {
                /*Look for thing */
                 $cursor = $thingBack->find($srchCriteria["Thing"]); 

                
                /*Loop through all parent records and retrive child based on _ID attribute*/
                while ($document = $cursor->getNext())
                {

                //$CWback=$this->dbObj->CreativeWorkTest;
                //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
                $CWbackResult = $CWback->findone(array("_id" => $document['_id']));
                //$recipeback=$this->dbObj->RecipeTest;
                $RecipeResult = $recipeback->findOne(array("_id" => $CWbackResult['_id']));
                /*Creating array of one recipe document*/
                $this->RecipeArray=array(
                     "Thing"=>$document,
                     "CreativeWork"=>$CWbackResult,
                     "Recipe"=>$RecipeResult
                     );
                $this->arr[$this->i]=$this->RecipeArray;
                $this->i=$this->i+1;

                }    

            }
            else
            {
                /*Check for Creativework*/
                if(key_exists("CreativeWork", $srchCriteria))
                {
                    /*Look for thing */
                    $cursor = $CWback->find($srchCriteria["CreativeWork"]); 
                    
                    /*Loop through all parent records and retrive child based on _ID attribute*/
                    while ($document = $cursor->getNext())
                    {

                    //$CWback=$this->dbObj->CreativeWorkTest;
                    //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
                    $CWbackResult = $thingBack->findone(array("_id" => $document['_id']));
                    //$recipeback=$this->dbObj->RecipeTest;
                    $RecipeResult = $recipeback->findOne(array("_id" => $document['_id']));
                    /*Creating array of one recipe document*/
                    $this->RecipeArray=array(
                         "Thing"=>$CWbackResult,
                         "CreativeWork"=>$document,
                         "Recipe"=>$RecipeResult
                         );
                    $this->arr[$this->i]=$this->RecipeArray;
                    $this->i=$this->i+1;

                    }    
                }
                else
                {
                    /*Check Recipe*/
                    if(key_exists("Recipe", $srchCriteria))
                    {
                        /*Look for thing */
                        $cursor = $recipeback->find($srchCriteria["Recipe"]); 

                        /*Loop through all parent records and retrive child based on _ID attribute*/
                        while ($document = $cursor->getNext())
                        {

                        //$CWback=$this->dbObj->CreativeWorkTest;
                        //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
                        $CWbackResult = $CWback->findone(array("_id" => $document['_id']));
                        //$recipeback=$this->dbObj->RecipeTest;
                        $ThingResult = $thingBack->findOne(array("_id" => $document['_id']));
                        /*Creating array of one recipe document*/
                        $this->RecipeArray=array(
                             "Thing"=>$ThingResult,
                             "CreativeWork"=>$CWbackResult,
                             "Recipe"=>$document
                             );
                        $this->arr[$this->i]=$this->RecipeArray;
                        $this->i=$this->i+1;

                        } 
                    
                    }
                }
                
            }
            
            
        }
        return $this->arr;

    }
    /*get object collection by Search Paramter,Retrive all child documents and then create nested array 
    and sent back to Caller.*/
    public function get_CollectionObjectbysearchParameter($srchCriteria)
    {
        //print_r($srchCriteria);
        $this->Collect=$this->dbObj->selectCollection("Thingtest");
        if (is_null($srchCriteria))
        {
//           $criteria_delete = array('_id' => new MongoId('4e4b52e41ce31eff2c000001'));
//$this->Collect->remove($criteria_delete, true );
         $cursor = $this->Collect->find();   
            //$cursor=$this->Collect->find(array("_id" =>'4e4acfca1ce31ecb17000000'));
        }
        else
        {
         $cursor = $this->Collect->find($srchCriteria);  
        }
        
        $this->i=0;
        /*Loop through all parent records and retrive child based on _ID attribute*/
        while ($document = $cursor->getNext())
        {
            
        $CWback=$this->dbObj->CreativeWorkTest;
        //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
        $CWbackResult = $CWback->findone(array("_id" => $document['_id']));
        $recipeback=$this->dbObj->RecipeTest;
        $RecipeResult = $recipeback->findOne(array("_id" => $CWbackResult['_id']));
        /*Creating array of one recipe document*/
        $this->RecipeArray=array(
             "Thing"=>$document,
             "CreativeWork"=>$CWbackResult,
             "Recipe"=>$RecipeResult
             );
        $this->arr[$this->i]=$this->RecipeArray;
        $this->i=$this->i+1;

        }    

        return $this->arr;

    }
    public function InsertCollection($obj)
    {
    
        $Recipe=$obj["Recipe"];
        $RecipeCollection=$this->dbObj->selectCollection("RecipeTest");
        $RecipeCollection->Insert($Recipe);
        //$RecipeRef = MongoDBRef::create($RecipeCollection->getName(),$Recipe['_id']);

        $CreativeWork=$obj["CreativeWork"];
        //$CreativeWork["RecipeReference"]=$RecipeRef;
        $CreativeWork['_id']=$Recipe['_id'];
        $CreativeWorkCollection=$this->dbObj->selectCollection("CreativeWorkTest");
        $CreativeWorkCollection->Insert($CreativeWork);
        //$CreativeWrokRef = MongoDBRef::create($CreativeWorkCollection->getName(), $CreativeWork['_id']);

        $thing=$obj["Thing"];
        $thingCollection=$this->dbObj->selectCollection("Thingtest");
        $thing['_id']=$CreativeWork['_id'];
        $thingCollection->Insert($thing);

        $recipeback=$this->dbObj->RecipeTest;
        $RecipeResult = $recipeback->findOne(array("ingredients" => "Chicken"));
        //echo 'Result'.$RecipeResult['_id'];
        //print_r($RecipeResult);
        $CWback=$this->dbObj->CreativeWorkTest;
        $CWbackResult = $CWback->findOne(array("_id" => $RecipeResult['_id']));
        //print_r($CWbackResult);

        $Thback=$this->dbObj->Thingtest;
        //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
        $ThbackResult = $Thback->findOne(array("_id" => $CreativeWork['_id']));
        //print_r($ThbackResult);
    }
    //Update collection based on Criteria and New data.
    public function SaveCollection($obj,$id)
    {
        //save obj values into Collection
        if(!is_null($obj)|| !is_null($this->Collect))
        if (!is_null($id))
        {
        $obj['_id']=$id;
        }
        $this->Collect->save($obj);
        return $obj['_id'];
    }
    
  /*Update collection based on Criteria and New data.*/
    public function UpdateCollection($obj,$ID)
    {
        /*get the collection*/
        
        $this->Collect=$this->dbObj->selectCollection("Thingtest");
        $ThingObj = $this->Collect->findone(array("_id" => new MongoId($ID)));
            
              
        /*Creative work update*/
        $CWback=$this->dbObj->CreativeWorkTest;
        $CWbackResult = $CWback->findone(array("_id" => $ThingObj['_id']));
        $Criteria_Update=array("_id" => new MongoId($CWbackResult['_id']));
        $CreativeWork=$obj["CreativeWork"];
        $CWback->update($Criteria_Update,$CreativeWork);
        
        /*Recipe Update*/
        $Criteria_Update = array("_id" => new MongoId($CWbackResult['_id']));
        $Recipe=$obj["Recipe"];
        $RecipeCollection=$this->dbObj->selectCollection("RecipeTest");
        $RecipeCollection->update($Criteria_Update,$Recipe);
        
        /*Thing Update*/
        $Criteria_Update=array("_id" => new MongoId($ID));
        $thing=$obj["Thing"];
        $thingCollection=$this->dbObj->selectCollection("Thingtest");
        $thingCollection->update($Criteria_Update,$thing);
    }
    /*Remove collection based on Criteria and New data.*/
    public function RemoveCollection($obj,$ID)
    {
        /*get the collection*/
        
        $this->Collect=$this->dbObj->selectCollection("Thingtest");
        $ThingObj = $this->Collect->findone(array("_id" => new MongoId($ID)));
            
              
        /*Creative work update*/
        $CWback=$this->dbObj->CreativeWorkTest;
        $CWbackResult = $CWback->findone(array("_id" => $ThingObj['_id']));
        $Criteria_Update=array("_id" => new MongoId($CWbackResult['_id']));
        $CreativeWork=$obj["CreativeWork"];
        $CWback->remove($Criteria_Update,$CreativeWork);
        
        /*Recipe Update*/
        $Criteria_Update = array("_id" => new MongoId($CWbackResult['_id']));
        $Recipe=$obj["Recipe"];
        $RecipeCollection=$this->dbObj->selectCollection("RecipeTest");
        $RecipeCollection->remove($Criteria_Update,$Recipe);
        
        /*Thing Update*/
        $Criteria_Update=array("_id" => new MongoId($ID));
        $thing=$obj["Thing"];
        $thingCollection=$this->dbObj->selectCollection("Thingtest");
        $thingCollection->remove($Criteria_Update,$thing);
    }
    //Remove collection Record
    public function RemoveRecipe($rmvcriteria)
    {
        /*Get parent collection first and then remove all related child collection*/
        $ThingDB=$this->dbObj->selectCollection("Thingtest");

        $cursor = $ThingDB->find($rmvcriteria);

        /*Loop through all parent records and retrive child based on _ID attribute*/
        while ($document = $cursor->getNext())
        {
        /*Remove all child records first*/
        $CWback=$this->dbObj->CreativeWorkTest;
        //$CWbackResult = MongoDBRef::get($CWback->db, $RecipeResult['_id']);
        $criteria=array("_id" => $document['_id']);
        $CWbackResult = $CWback->findone(array("_id" => $document['_id']));
        $recipeback=$this->dbObj->RecipeTest;
        $criteria=array("_id" => $CWbackResult['_id']);
        $recipeback->remove($criteria, true );
        $CWback->remove($criteria, true );

        }
        $ThingDB->remove($rmvcriteria);
    }
}
/*SingleTon design Pattern Implementation*/
class singleton
{
    private static $instance;
    private $count = 0;
    private function __construct()
    {
    }
    public static function singleton($username,$password)
    {
    if (!(self::$instance)) {
    $className = __CLASS__;
    self::$instance = new Mongo("mongodb://${username}:${password}@localhost/test",array("persist" => "x"));;
    }
    return self::$instance;
    }
    public function increment()
    {
        return $this->count++;
    }
    public function __clone()
    {
    trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
    trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }
}

?>


