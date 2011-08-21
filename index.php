<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<form method="post"  action="index.php" name="search" >
<title>Schema Creator</title>
</head>
<body>
<div style="border-style: outset; width: 550px" align="left">
<h2 style="color: red" align="center">Welcome to Recipe System</h2>
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
    <tr>
        <td align="center"colspan="4" ><input type="submit" name="Check" title="Check" value="Search Recipe"/><h4><a href='Add.php'>Add</a></h4>
        <h4><a href='UpdateRecipe.php'>Update</a></h4>
        <h4><a href='DeleteRecipe.php'>Delete</a></h4>
        <h4><a href='AdvancedSearch.php'>Advanced Search</a></h4></td>
    </tr>    
</table>
</div>
    <?php
    $message = NULL;
    $srchcriteria=NULL;
    $result=NULL;

    function __autoload($class_name) {
        include $class_name . '.php';
    }
    $thing=new Recipe();
    if (empty($_POST["name"]) && empty($_POST["description"]) && empty($_POST["image"]) && empty($_POST["url"])) 
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
        $regex = new MongoRegex("/$_POST[name]/i");
        $srchcriteria["name"]=$regex;
        }
        if(!empty($_POST["description"]))
        {
        $regex = new MongoRegex("/$_POST[description]/i");
        $srchcriteria["description"]=$regex;
        }
        if(!empty($_POST["url"]))
        {
        $srchcriteria["url"]=$_POST["url"];
        }

        $result=$thing->SearchRecipe($srchcriteria);
        if($result==0)
        {
        $message= "Recipe does not exist"; 
        }
    }
   
    ?>
</body>
</form>
</html>