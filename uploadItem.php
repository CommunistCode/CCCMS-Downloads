<?php

	require_once("includes/downloadGlobal.inc.php");
  require_once(FULL_PATH."/membership/includes/checkLogin.inc.php");

  $page->set("title","Upload New Torrent");
  $page->set("heading","Upload New Torrent");
  
  if (isset($_POST['uploadFile'])) {

    $include = "includes/reviewItem.inc.php";

  } else if (isset($_POST['doUpload'])) {

    $include = "includes/doUploadFile.inc.php";

  } else {

    $include = "includes/uploadItem.inc.php";  

  }

  $page->addInclude($include);
  $page->render("corePage.inc.php");

?>
