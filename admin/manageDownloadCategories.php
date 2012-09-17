<?php 

  require_once("includes/downloadAdminGlobal.inc.php");

  $page->set("title","Manage Categories");
  $page->set("heading","Manage Categories");

  $page->addInclude("includes/manageCategories.inc.php", array("downloadTools"=>$downloadTools));

	if (isset($_POST['addCategory'])) {

		$downloadAdminTools->addCategory($_POST['name'],$_POST['parentCategory']);

	}

	if (isset($_POST['deleteCategory'])) {

		$downloadAdminTools->deleteCategory($_POST['categoryID']);

	}

  $page->render("corePage.inc.php");

?>
