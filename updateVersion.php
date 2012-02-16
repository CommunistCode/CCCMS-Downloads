<?php

	require_once("../config/config.php");
	require_once($fullPath."/classes/pageTools.class.php");
	require_once($fullPath."/download/classes/downloadTools.class.php");
	require_once($fullPath."/includes/global.inc.php");

	$downloadTools = new downloadTools();

	$pageTitle = "Downloads Home";
	$heading = "Downloads";

  if (!isset($_GET['downloadItemID'])) {

    $content = "To update an image version you must find the image in the download section, then click the add new version link.";

  }

	require_once($fullPath."/download/themes/".$pageTools->getTheme("download")."/templates/template.inc.php");

?>