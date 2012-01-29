<?php

  require_once("../config/config.php");
  require_once("classes/setup.class.php");

  $create = new setupDownloadModule();

  $create->createTables();
  $create->populateTables();

?>
