<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<form action="DeleteRecipe.php" method="post" />
<title>Schema Creator</title>
</head>
<?php

    function __autoload($class_name) 
    {
        include $class_name . '.php';
    }

    if (empty($_POST["name"]) && empty($_POST["description"]) && empty($_POST["image"]) && empty($_POST["url"])) 
    {
        echo 'Please Enter Recipe Information.';
    } else 
    {
        $thing = new Recipe(); //As Thing, the super parent class extends Tag. Tag construtor is invoked.
        /*collect remove parameters*/
        if(!empty($_POST["name"]))
        {
        $rmvcriteria=array("name"=>$_POST["name"]);   

        }
        if(!empty($_POST["description"]))
        {
        $rmvcriteria=array("description"=>$_POST["description"]);   

        }
        if(!empty($_POST["name"]) && !empty($_POST["description"]))
        {
        $rmvcriteria=array("name"=>$_POST["name"],"description"=>$_POST["description"]);   

        }

        echo $thing->RemoveRecipe($rmvcriteria);
        echo 'Recipe Deleted Successfully.';
    }
    ?>
<body>
<div style="border-style: outset; width: 450px" align="left">
<h2 align="center" style="color: red">Delete Recipe</h2>
<h5 style="color: red">
<h5>
<?php
                    $recipe = new Recipe();
                    $form = new FormGenerator();
                    $form->generate($recipe);
                    ?>
<input type="submit" name="Check" title="Check" value="Delete Recipe" >
<h4><a href='index.php'>Home</a></h4></td>
</div>
</body>
</form>
</html>