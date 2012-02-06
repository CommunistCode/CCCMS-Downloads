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

    public function countItemsInCategoryRecurring($categoryID) {

      $childCategoryArray = $this->cM->getChildCategoriesRecurring($categoryID);

      $field = "COUNT(wikiPageID) as count";
      $table = "wiki_pageCategories";

      $i = 0;

      foreach ($childCategoryArray as $childCategoryID) {

        $where[$i]['joinOperator'] = "OR";
        $where[$i]['column'] = "wikiCategoryID";
        $where[$i]['value'] = $childCategoryID;

        $i++;

      }

      $where[$i]['joinOperator'] = "OR";
      $where[$i]['column'] = "wikiCategoryID";
      $where[$i]['value'] = $categoryID;

      $countResult = $this->pdoConn->select($field,$table,$where);

      return $countResult[0]['count'];

    }

    public function getCategoryPath($categoryID) {

      $array = array();

      return $this->cM->getCategoryPath($categoryID);

    }

    public function getChildCategories($categoryID) {

      return $this->cM->getChildCategories($categoryID);

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
