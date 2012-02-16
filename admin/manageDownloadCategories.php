<?php 

	require_once("../../config/config.php");
	require_once($fullPath."/admin/includes/global.inc.php");
	require_once($fullPath."/admin/includes/checkLogin.inc.php");
	require_once("classes/downloadAdminTools.class.php");
	require_once($fullPath."/download/classes/downloadTools.class.php");

	$downloadAdminTools = new downloadAdminTools();
	$downloadTools = new downloadTools();
  $pageTools = new pageTools();

  $title = "Admin : Downloads : Manage Categories";
  $heading = "Manage Categories";
  $include = "includes/manageCategories.inc.php";

	if (isset($_POST['addCategory'])) {

		$downloadAdminTools->addCategory($_POST['name'],$_POST['parentCategory']);

	}

	if (isset($_POST['deleteCategory'])) {

		$downloadAdminTools->deleteCategory($_POST['categoryID']);

	}

  require_once($fullPath."/admin/themes/".$pageTools->getTheme("admin")."/templates/corePage.inc.php");

?>
