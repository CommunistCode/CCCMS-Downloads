<?php

	require_once("includes/downloadGlobal.inc.php");

  $page->set("title","View Download");
  $page->set("heading","View Download");
	
  if (isset($_GET['id'])) {
    
    $page->addInclude("includes/detailedItemView.inc.php");

  } else {

    $page->addContent("Torrent could not be found!");

  }

  $page->render("corePage.inc.php");

?>
