<?php

  require_once($fullPath."/classes/pdoConn.class.php");

  class downloadTools {

    private $pdoConn;

    function __construct() {

      $this->pdoConn = new pdoConn();

    }

  }

?>
