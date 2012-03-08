<?php

	require_once("includes/downloadGlobal.inc.php");

  $page->set("title","View Versions");
  $page->set("heading","View Versions");

  if (isset($_GET['downloadItemID'])) {
    
    $page->addInclude("includes/viewVersions.inc.php");

  } else {

    $page->addContent("Sorry this torrent cannot be found!");

  }

  $page->render("corePage.inc.php");

?>
