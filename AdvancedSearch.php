<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<form method="post"  name="search" >
<title>Schema Creator</title>
</head>
<?php
    function __autoload($class_name) 
    {
    include $class_name . '.php';
    }
?>

<div style="border-style:outset; width: 550px" align="left">
<h2 align="center" style="color:red">Advanced Recipe Search</h2>
<h4 align="center"><label id=questionLabel ><? echo $message; ?></label></h4>
<h5 style="color: red"><h5>
<table width="500" border="0">
<tr >
<td align="right"><strong>Name :</strong></td>
<td align="left"><input id="recipeID" type="text" name="name"  /></td>
<td align="right"><strong>Image :</strong></td>
<td align="left"><input id="imgid" type="text" name="image" /></td>
</tr>
<tr align="center">
<td align="right"><strong>Description:</strong></td>
<td align="left"><input id="descid" type="text" name="description" /></td>
<td align="right"><strong>URL:</strong></td>
<td align="left"><input id="URLID" type="text" name="url" /></td>
</tr>
<tr align="center">
<td align="right"><strong>About:</strong></td>
<td align="left"><input id="AboutID" type="text" name="about"  /></td>
<td align="right"><strong>Author:</strong></td>
<td align="left"><input id="AuthorID" type="text" name="author" /></td>
</tr>
<tr align="center">
<td align="right"><strong>Ingredients:</strong></td>
<td align="left"><input id="ingrenID" type="text" name="ingredients" /></td>
<td align="right"><strong>Instructions:</strong></td>
<td align="left"><input id="instructID" type="text" name="instructions"  /></td>
</tr>
<tr align="center" >
    <td colspan="2" align="center"><input type="submit" name="Check" title="Check"  value="Search"/></td>
    <td><h4><a href='index.php'>Home</a></h4></td>
</tr>
</table>
</div>
    <?php
    $message = NULL;
    $srchcriteria=NULL;
    $srchThing=NULL;
    $srchCreativeWk=NULL;
    $srchRecipe=NULL;
    $result=NULL;
    $thing=new Recipe();
    if (empty($_POST["name"]) && empty($_POST["description"]) && empty($_POST["image"]) && empty($_POST["url"]) && empty($_POST["author"]) && empty($_POST["about"])&& empty($_POST["ingredients"]) && empty($_POST["instructions"])) 
    {
        //echo 'Please Enter Recipe Name and Hit Search.' ;
       
        $result=$thing->SearchRecipe($srchcriteria);
    }
    else
    {
       $thing=new Recipe();
        /*Collect search parameters and pass to recipe class*/

        if(!empty($_POST["name"]))
        {
        // $regex = new MongoRegex("/^$_POST[name]/i");
        $srchThing["name"]=$_POST["name"];
        }
        if(!empty($_POST["description"]))
        {
        $srchThing["description"]=$_POST["description"];
        }
        if(!empty($_POST["url"]))
        {
        $srchThing["url"]=$_POST["url"];
        }

         if(!empty($_POST["about"]))
        {
        $srchCreativeWk["about"]=$_POST["about"];
        }
        
         if(!empty($_POST["author"]))
        {
        $regex = new MongoRegex("$_POST[author]/i");
        $srchCreativeWk["author"]= $regex;//$_POST["author"];
        }
        
         if(!empty($_POST["ingredients"]))
        {
        $srchRecipe["ingredients"]=$_POST["ingredients"];
        }
        
         if(!empty($_POST["instructions"]))
        {
        $srchRecipe["instructions"]=$_POST["instructions"];
        }
        if(!is_null($srchThing))
        {
            $srchcriteria["Thing"]=$srchThing;
        }
        if(!is_null($srchCreativeWk))
        {
            $srchcriteria["CreativeWork"]=$srchCreativeWk;
        }
        if(!is_null($srchRecipe))
        {
            $srchcriteria["Recipe"]=$srchRecipe;
        }
        $result=$thing->AdvancedRecipeSearch($srchcriteria);
        if($result==0)
        {
        $message="Recipe does not exist"; 
        }
    }
   
?>

</body>
</form>
</html>