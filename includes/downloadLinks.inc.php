<?php

  if (isset($_GET['categoryID'])) {

    $categoryID = $_GET['categoryID'];

  } else {

    $categoryID = 0;

  }

  $topDiv = "linkHeaderTop";

  if ($categoryID != 0) {

    echo("<div class='linkHeader ".$topDiv."'>Category Tree</div>");
    $topDiv = "";
  
    $sortedCategoryTree = $downloadTools->getCategoryPath($categoryID);
  
    echo("<ul>");
    
    echo("<li><a href='index.php'>Home</a></li>");

    foreach ($sortedCategoryTree as $branch) {

      echo("<li>");

      $currentCategory = false;

      if (count($sortedCategoryTree) == $branch['level']) {

        echo("<strong>");
        $currentCategory = true;

      }

      echo(str_repeat("-",$branch['level'])." <a href='index.php?categoryID=".$branch['id']."'>".$branch['name']."</a>");
      echo(" (".$downloadTools->countItemsInCategoryRecurring($branch['id']).")"); 

      if ($currentCategory) {

        echo("</strong>");

      }

      echo("</li>");

    } 

  } 

  $childCategoryArray = $downloadTools->getChildCategories($categoryID);

  if (isset($childCategoryArray) && count($childCategoryArray) != 0) {

    if ($categoryID != 0) {

      $categoryHeading = "Sub-Categories";

    } else {

      $categoryHeading = "Categories";

    }

    echo("<div class='linkHeader ".$topDiv."'>".$categoryHeading."</div>");
    $topDiv = "";

    echo("<ul>");
  
    foreach ($childCategoryArray as $child) {

      echo("<li><a href='index.php?categoryID=".$child['downloadCategoryID']."'>".$child['name']."</a>");
      echo(" (".$downloadTools->countItemsInCategoryRecurring($child['downloadCategoryID']).")");

    }

    echo("</ul>");

  }

?>

<div class='linkHeader'>Actions</div>

<ul>
  <li><a href='uploadItem.php'>Upload New Image</a></li>
  <li><a href='updateVersion.php'>Add New Version</a></li>
</ul>
