<?php

  require_once($fullPath."/classes/pdoConn.class.php");
  require_once($fullPath."/helperClasses/categoryManager/categoryManager.class.php");

  class downloadTools {

    private $pdoConn;
    private $cM;

    function __construct() {

      $this->pdoConn = new pdoConn();

      $fields = array("downloadCategoryID","name","parentCategoryID");
      $table = "download_categories";

      $result = $this->pdoConn->select($fields,$table);

      $this->cM = new categoryManager($result,"downloadCategoryID","parentCategoryID","name");

    }

    public function renderCategorySelectOptions() {

      $categoryArray = $this->cM->makeCategoryTreeArray();

      foreach($categoryArray as $category) {

      echo("<option value='".$category['downloadCategoryID']."'>");

        for ($i=0; $i<=$category['level']; $i++) {

          echo("-");

        }

        echo(" ".$category['name']."</option>");

      }

    }    

  }

?>
