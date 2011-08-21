<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<form method="post" name="search" >
<title>Schema Creator</title>
</head>
<?php
function __autoload($class_name) {
include $class_name . '.php';
}
$ID=NULL;

$thing=new Recipe();
//echo 'id is '.$_POST['ID'];
  $result= $thing->SearchRecipeByID($_GET["value"]); 
 

?>
<div style="border-style:outset; width: 450px" align="left">
<h2 align="center" style="color:red">Update Recipe</h2>
<h5 style="color: red"><h5>
<table width="400" border="0">
<tr >
<td align="right"><strong>Name :</strong></td>
<td align="left"><input id="recipeID" type="text" name="name"  value="<?php echo $thing->getNameValue(); ?>"/></td>
</tr>
<tr align="center">
<td align="right"><strong>Description:</strong></td>
<td align="left"><input id="descid" type="text" name="description" value="<?php echo $thing->getDescriptionValue(); ?>" /></td>
</tr>
<tr align="center">
<td align="right"><strong>Image :</strong></td>
<td align="left"><input id="imgid" type="text" name="image" value="<?php echo $thing->getImageValue(); ?>" /></td>
</tr>
<tr align="center">
<td align="right"><strong>URL:</strong></td>
<td align="left"><input id="URLID" type="text" name="url" value="<?php echo $thing->getUrlValue(); ?>" /></td>
</tr>
<tr align="center">
<td align="right"><strong>About:</strong></td>
<td align="left"><input id="AboutID" type="text" name="about" value="<?php echo $thing->getaboutValue(); ?>" /></td>
</tr>
<tr align="center">
<td align="right"><strong>Author:</strong></td>
<td align="left"><input id="AuthorID" type="text" name="author" value="<?php echo $thing->getauthorValue(); ?>"/></td>
</tr>
<tr align="center">
<td align="right"><strong>Ingredients:</strong></td>
<td align="left"><input id="ingrenID" type="text" name="ingredients" value="<?php echo $thing->getingredientsValue(); ?>"/></td>
</tr>
<tr align="center">
<td align="right"><strong>Instructions:</strong></td>
<td align="left"><input id="instructID" type="text" name="instructions" value="<?php echo $thing->getinstructionsValue(); ?>" /></td>
</tr>
<tr align="left" >
    <td colspan="2" align="center"><input type="submit" name="Check" title="Check" onclick="<?php  $thing->RemoveRecipework($_GET["value"]);?>" value="Delete"/><h4><a href='index.php'>Home</a></h4></td>
</tr>
</table>
</div>
</body>
</form>
</html>