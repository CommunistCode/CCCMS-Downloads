<?php

	require_once("includes/downloadGlobal.inc.php");
  require_once(FULL_PATH."/".MEMBER_MODULE_DIR."/includes/checkLogin.inc.php");

  $page->set("title","Update Torrent");
  $page->set("heading","Update Torrent");

  if (isset($_POST['uploadFile'])) {

    $include = "includes/reviewUpdate.inc.php";

  } else if (isset($_POST['doUpload'])) {

    $include = "includes/doUpdate.inc.php";

  } else {

    $include = "includes/newVersion.inc.php";  

  }

  $page->addInclude($include);
  $page->render("corePage.inc.php");

?>
