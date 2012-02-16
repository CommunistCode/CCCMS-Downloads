<?php

  require_once($fullPath."/helperClasses/categoryManager/categoryManager.class.php");

	class downloadAdminTools {

    private $pdoConn;

    function __construct() {

      $this->pdoConn = new pdoConn();

    }

		public function addCategory($categoryName,$parentID) {

			$db = new dbConn();

			return	$db->insert("download_categories","name,parentCategoryID","'".$categoryName."',".$parentID);

		}

		public function deleteCategory($categoryID) {

			$db = new dbConn();

			return $db->delete("download_categories","wikiCategoryID=".$categoryID);

		}

	}

?>
