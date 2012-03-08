<?php

	require_once("includes/downloadGlobal.inc.php");

  $page->set("title","Downloads");
  $page->set("heading","Downloads");

  if (isset($_GET['categoryID']) && $_GET['categoryID'] != 0) {
    
    $page->addInclude("includes/listItems.inc.php");

  } else {

    $content = $pageTools->getDynamicContent($pageTools->getPageIDbyDirectLink("download/index.php"));
    $content = $pageTools->matchTags($content['text']);
    
    $page->addContent($content);

  }

  $page->render("corePage.inc.php");

?>
