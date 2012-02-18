<?php

	require_once("../config/config.php");
	require_once($fullPath."/classes/pageTools.class.php");
	require_once($fullPath."/download/classes/downloadTools.class.php");
	require_once($fullPath."/includes/global.inc.php");
  require_once($fullPath."/membership/includes/checkLogin.inc.php");

	$downloadTools = new downloadTools();

	$pageTitle = "Udate Torrent";
	$heading = "Update Torrent";

  if (isset($_POST['uploadFile'])) {

    $include = "includes/reviewUpdate.inc.php";

  } else if (isset($_POST['doUpload'])) {

    $include = "includes/doUpdate.inc.php";

  } else {

    $include = "includes/newVersion.inc.php";  

  }

	require_once($fullPath."/download/themes/".$pageTools->getTheme("download")."/templates/template.inc.php");

?>
