<?php

/**
This class provides details of Recipe.Extracts information from other two classes.Thing and Creative work and
* Display all relevant information for recipe.
* @author Dishna
*/
class Recipe Extends CreativeWork 
{

private $instructions;
private $ingredients;
Protected $RecipeArray;
protected $sortedRecipe = array("ra" => "ingredients_txt", "rb" => "instructions_txt");
Public $RecipeColname = "RecipeWork";
private $result;

function Recipe() 
{
    parent::__construct();
    $this->instructions->tag->tagtype = 'span';
    $this->ingredients->tag->tagtype = 'span';
    $this->setinstructionsAttributes('instructions');
    $this->setingredientsAttributes('ingredients');
}

function prepare_array_Recipework() {
    $obj['instructions'] = $_POST["instructions"];
    $obj['ingredients'] = $_POST["ingredients"];
    return $obj;
}

function setinstructionsValue($var) {
    $this->instructions->value = $var;
}

function getinstructionsValue() {
    return $this->instructions->value;
}

function setinstructionsTag($var) {
    $this->instructions->tag->tagtype = $var;
}

function getinstructionsTag() {
    return $this->instructions->tag->tagtype;
}

function setinstructionsAttributes($var) {
    $class = get_class($this) . ' instructions ' . $var;
    $this->instructions->tag->attributes['class'] = $class;
    $this->instructions->tag->attributes['itemprop'] = 'instructions';
}

function getinstructionsAttributes() {
    return $this->instructions->tag->attributes;
}

function setingredientsValue($var) {
    $this->ingredients->value = $var;
}

function getingredientsValue() {
    return $this->ingredients->value;
}

function setingredientsTag($var) {
    $this->ingredients->tag->tagtype = $var;
}

function getingredientsTag() {
    return $this->ingredients->tag->tagtype;
}

function setingredientsAttributes($var) {
    $class = get_class($this) . ' ingredients ' . $var;
    $this->ingredients->tag->attributes['class'] = $class;
    $this->ingredients->tag->attributes['itemprop'] = 'ingredients';
}

function getingredientsAttributes() {
    return $this->ingredients->tag->attributes;
}

public function PrintRecipeWork() 
{

    $dbl = new DBLayer();
    $dbl->setCollectionObj($this->RecipeColname);
    $obj = $this->prepare_array_Recipework();
    $dbl->InsertCollection($obj, $this->objID);
    $cursor = $dbl->get_CollectionObject($this->RecipeColname, $this->objID);
    foreach ($cursor as $arr) {
        $this->instructions->value = $arr['instructions'];
        $this->ingredients->value = $arr['ingredients'];
    }

    echo "<b>Instructions</b> : " . $this->printinstructionsHtmlTag() . '<br>';
    echo "<b>Ingredients</b> : " . $this->printingredientsHtmlTag() . '<br>';
}

Public function printinstructionsHtmlTag() {
    $tag = new Tag($this->getinstructionsTag(), $this->getinstructionsAttributes(), $this->getinstructionsValue());
    return $tag->get_tag();
}

Public function printingredientsHtmlTag() {
    $tag = new Tag($this->getingredientsTag(), $this->getingredientsAttributes(), $this->getingredientsValue());
    return $tag->get_tag();
}
/*Updte recipe*/
public function UpdateRecipeWork($ID)
{
    if (empty($_POST["name"]) || empty($_POST["description"]) || empty($_POST["image"]) || empty($_POST["name"]))
    {
     echo 'Please enter all Required fields.'; 
     return;
    }  
    $dbl=new DBLayer();
    $obj=$this->CreateRecipeArray();
    $dbl->UpdateCollection($obj,$ID);
    header("Location: index.php");
   
}
/*Remove recipe*/
/*Updte recipe*/
public function RemoveRecipework($ID)
{
    $dbl=new DBLayer();
    $obj=$this->CreateRecipeArray();
    $dbl->Removecollection($obj,$ID);
    header("Location: index.php");
}
public function UpdateRecipe($_criteria, $_newData) 
{

    $dbl = new DBLayer();
    $dbl->setCollectionObj($this->Colname);
    $this->objID = $dbl->UpdateCollection($this->Colname, $_criteria, $_newData);
    $cursor = $dbl->get_CollectionObjectbyid($this->Colname, $this->objID);
    foreach ($cursor as $arr) {
        $this->instructions->value = $arr['instructions'];
        $this->ingredients->value = $arr['ingredients'];
    }
    echo "<b>Instructions</b> : " . $this->printinstructionsHtmlTag() . '<br>';
    echo "<b>Ingredients</b> : " . $this->printingredientsHtmlTag() . '<br>';
}
/*Remove selected recipe*/
public function RemoveRecipe($rmvcriteria) 
{
    $dbl = new DBLayer();
    $cursor = $dbl->RemoveRecipe($rmvcriteria);
}

/*Funtion to create nested array and send to DBLayer*/
Public function CreateRecipeArray()
{
    $this->RecipeArray=array(
     "Thing"=>$this->prepare_array(),
     "CreativeWork"=>$this->prepare_array_Creativework(),
     "Recipe"=>$this->prepare_array_Recipework()
         );
    return $this->RecipeArray;

}
/*Function for recipe Advanced Search*/
public function AdvancedRecipeSearch($Criteria)
{
   $dbl=new DBLayer();
   $arr= $dbl->get_AdvancedSearch($Criteria);
     if (!is_null($arr))
    {
        
        echo "<table border='1' width='300'>";
        echo "<th>Name</th><th>Description</th><th>URL</th><th>Image</th>";
        echo "<th>About</th><th>Author</th><th>instructions</th><th>Ingredients</th><th colspan='2'>Action</th>";
        foreach ($arr as $value)
        {
            /*Loop through returned array values*/ 
            $this->PrintRecipe($value);
        echo"<tr>";
        echo "<td>".$this->printNameHtmlTag()."</td>";
        echo "<td>".$this->printDescriptionHtmlTag()."</td>";
        echo "<td>".$this->printUrlHtmlTag()."</td>";
        echo "<td>".$this->printImageHtmlTag()."</td>";
        echo "<td>".$this->printaboutHtmlTag()."</td>";
        echo "<td>".$this->printauthorHtmlTag()."</td>";
        echo "<td>".$this->printinstructionsHtmlTag()."</td>";
        echo "<td>".$this->printingredientsHtmlTag()."</td>";
        echo "<td><a href='Update.php?value=$this->objThingID'>Edit</a></td>";
        echo "<td><a href='Delete.php?value=$this->objThingID'>Delete</a></td>";
        echo "</tr>\n";
        }
        
        echo "</table>\n";
        $this->result=1;
    }
    else
    {
        $this->result=0;
    }
    return $this->result;
    
}
/*Function Searchs recipe macthes input criteria*/
public function SearchRecipe($Criteria)
{
    
    $dbl=new DBLayer();
    $arr= $dbl->get_CollectionObjectbysearchParameter($Criteria);
    //$obj=iterator_to_array($cursor);
    if (!is_null($arr))
    {
        echo "<table border='1' width='300'>";
        echo "<th>Name</th><th>Description</th><th>URL</th><th>Image</th>";
        echo "<th>About</th><th>Author</th><th>instructions</th><th>Ingredients</th><th colspan='2'>Action</th>";
        foreach ($arr as $value)
        {
            /*Loop through returned array values*/ 
            $this->PrintRecipe($value);
        echo"<tr>";
        echo "<td>".$this->printNameHtmlTag()."</td>";
        echo "<td>".$this->printDescriptionHtmlTag()."</td>";
        echo "<td>".$this->printUrlHtmlTag()."</td>";
        echo "<td>".$this->printImageHtmlTag()."</td>";
        echo "<td>".$this->printaboutHtmlTag()."</td>";
        echo "<td>".$this->printauthorHtmlTag()."</td>";
        echo "<td>".$this->printinstructionsHtmlTag()."</td>";
        echo "<td>".$this->printingredientsHtmlTag()."</td>";
        echo "<td><a href='Update.php?value=$this->objThingID'>Edit</a></td>";
        echo "<td><a href='Delete.php?value=$this->objThingID'>Delete</a></td>";
        echo "</tr>\n";
        }
        
        echo "</table>\n";
        $this->result=1;
    }
    else
    {
        $this->result=0;
    }
    return $this->result;
}

/*Search Recipe By ID*/
public function SearchRecipeByID($ID)
{
  
    $dbl=new DBLayer();
    $arr= $dbl->get_CollectionObjectbyID($ID);
    //$obj=iterator_to_array($cursor);
    if (!is_null($arr))
    {
        
        echo "<table border='1' width='300'>";
        echo "<th>Name</th><th>Description</th><th>URL</th><th>Image</th>";
        echo "<th>About</th><th>Author</th><th>instructions</th><th>Ingredients</th>";
        foreach ($arr as $value)
        {
            /*Loop through returned array values*/ 
            $this->PrintRecipe($value);
           
        echo"<tr>";
        echo "<td>".$this->printNameHtmlTag()."</td>";
        echo "<td>".$this->printDescriptionHtmlTag()."</td>";
        echo "<td>".$this->printUrlHtmlTag()."</td>";
        echo "<td>".$this->printImageHtmlTag()."</td>";
        echo "<td>".$this->printaboutHtmlTag()."</td>";
        echo "<td>".$this->printauthorHtmlTag()."</td>";
        echo "<td>".$this->printinstructionsHtmlTag()."</td>";
        echo "<td>".$this->printingredientsHtmlTag()."</td>";
        echo "</tr>\n";
        }
        echo "</table>\n";
//        echo "<script>
//        $(document).ready(function(){
//        document.getElementById('name').value ={$this->printNameHtmlTag()};
//
//        });
//        </script>";
        $this->result=1;
    }
    else
    {
        $this->result=0;
    }
    return $this->result;
}
/*Print recipe function for recipe class only*/
public function SearchRecipeWork($arr)
{

    $this->instructions->value = $arr['instructions'];
    $this->ingredients->value = $arr['ingredients'];
//    echo "<b>Instructions</b> : " . $this->printinstructionsHtmlTag().'<br>';
//    echo "<b>Ingredients</b> : ". $this->printingredientsHtmlTag().'<br>';
}
/*Function to print recipe schema.pass value to appropriate class.*/
public function PrintRecipe($cursor)
{
    $ThingArr=$cursor["Thing"];
    echo $this->SearchThing($ThingArr);
    $CwrArr=$cursor["CreativeWork"];
    echo $this->SearchCreativeWork($CwrArr);
    $RecprArr=$cursor["Recipe"];
    echo $this->SearchRecipeWork($RecprArr);  
    
}
/*function to insert  new recipe*/
public function saveRecipeWork()
{
    $dbl=new DBLayer();
    $obj=$this->CreateRecipeArray();//prepare_array_Recipework();
    $dbl->InsertCollection($obj);
}
}
?>


