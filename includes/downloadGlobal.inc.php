<?php

  // Require global include
  require_once("../global/includes/global.inc.php");
  require_once("config/moduleConfig.inc.php");

  // Require downloadTools
  require_once(FULL_PATH."/".MODULE."/classes/downloadTools.class.php");

  // Create memberTools object
  $downloadTools = new downloadTools();

?>
