<?php

	require_once("../config/config.php");
	require_once($fullPath."/classes/pageTools.class.php");
	require_once($fullPath."/download/classes/downloadTools.class.php");
	require_once($fullPath."/includes/global.inc.php");

	$downloadTools = new downloadTools();

	$pageTitle = "Downloads Home";
	$heading = "Downloads";
  
  if (isset($_GET['categoryID']) && $_GET['categoryID'] != 0) {
    
    $include = "includes/listItems.inc.php";  

  } else {

    $content = $pageTools->getDynamicContent($pageTools->getPageIDbyDirectLink("download/index.php"));
    $content = $pageTools->matchTags($content);

  }

	require_once($fullPath."/download/themes/".$pageTools->getTheme("download")."/templates/template.inc.php");

?>
