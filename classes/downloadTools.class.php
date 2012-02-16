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

    public function storeTempTorrent($fileArray, $torrentObject) {

      $ret['error'] = 0;

      if ($fileArray['error']) {

        $ret['error'] = 1;
        $ret['message'] = "Error with file upload!";

      }

      if (substr($fileArray['name'],-8) != ".torrent") {

        $ret['error'] = 1;
        $ret['message'] = "File name does not end with .torrent";

      }

      $tmpFileName = time()."-".rand().".torrent";

      $tmpLocation = $GLOBALS['fullPath']."/download/files/temp/".$tmpFileName;

      move_uploaded_file($fileArray['tmp_name'],$tmpLocation);

      $torrentObject->setFullPath($tmpLocation);
      $_SESSION['originalFilename'] = $fileArray['name'];
    }

    public function insertNewTorrent($torrentObject) {

      $torrent = $torrentObject;

      copy($torrent->getFullPath(),$GLOBALS['fullPath']."/download/files/torrents/".$torrent->getName()."-".$torrent->getVersionExternal().".torrent");

      $table = "download_items";

      $insert[0]['field'] = "name";
      $insert[0]['value'] = $torrent->getName();

      $insert[1]['field'] = "description";
      $insert[1]['value'] = $torrent->getDescription();

      $insert[2]['field'] = "developer";
      $insert[2]['value'] = $torrent->getDeveloper();

      $insert[3]['field'] = "uploaderID";
      $insert[3]['value'] = $torrent->getUploaderID();

      $this->pdoConn->insert($table,$insert);

      $downloadItemID = $this->pdoConn->getLastInsertID();

      unset($insert);

      foreach ($torrent->getCategoryArray() as $category) {

        $table = "download_itemCategoryLink";

        $insert[0]['field'] = "downloadCategoryID";
        $insert[0]['value'] = $category;

        $insert[1]['field'] = "downloadItemID";
        $insert[1]['value'] = $downloadItemID;

        $this->pdoConn->insert($table,$insert); 

      }

      unset($insert);

      $table = "download_fileInfo";
    
      $insert[0]['field'] = "downloadItemID";
      $insert[0]['value'] = $downloadItemID;
      
      $insert[1]['field'] = "dateUploaded";
      $insert[1]['value'] = time();
   
      $insert[2]['field'] = "versionExternal";
      $insert[2]['value'] = $torrent->getVersionExternal();
   
      $insert[3]['field'] = "filename";
      $insert[3]['value'] = $torrent->getName()."-".$torrent->getVersionExternal().".torrent";
    
      $this->pdoConn->insert($table,$insert);

    }

    public function countItemsInCategoryRecurring($categoryID) {

      $childCategoryArray = $this->cM->getChildCategoriesRecurring($categoryID);

      $field = "COUNT(downloadItemID) as count";
      $table = "download_itemCategoryLink";

      $i = 0;

      foreach ($childCategoryArray as $childCategoryID) {

        $where[$i]['joinOperator'] = "OR";
        $where[$i]['column'] = "downloadCategoryID";
        $where[$i]['value'] = $childCategoryID;

        $i++;

      }

      $where[$i]['joinOperator'] = "OR";
      $where[$i]['column'] = "downloadCategoryID";
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
