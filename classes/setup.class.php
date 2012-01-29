<?php

  require_once($fullPath."/classes/dbConn.class.php");
  require_once($fullPath."/admin/classes/adminDBTools.class.php");
  require_once($fullPath."/classes/dbTools.class.php");

  class setupDownloadModule {

    public function createTables() {

      $db = new dbConn();
      $dbTools = new dbTools();

      $i = 0;

      $tableName = "download_items";

      $tableDefintion[$i]['name'] = "downloadItemID";
      $tableDefintion[$i]['definition'] = "INT NOT NULL AUTO_INCREMENT";

      $tableDefinition[++$i]['name'] = "name";
      $tableDefinition[$i]['definition'] = "TEXT";
 
      $tableDefinition[++$i]['name'] = "description":
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "dateAdded";
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "originalCreator";
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "uploaderID";
      $tableDefinition[$i]['definition'] = "INT";

      $primaryKey = "downloadItemID";

      $dbTools->newTable($tableName,$tableDefinition,$primaryKey);
      unset($tableDefinition);

      $i = 0;
  
      $tableName = "download_categories";

      $tableDefinition[$i]['name'] = "downloadCategoryID";
      $tableDefinition[$i]['definition'] = "INT NOT NULL AUTO_INCREMENT";

      $tableDefinition[++$i]['name'] = "parentCategoryID";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "name";
      $tableDefinition[$i]['definition'] = "TEXT";

      $primaryKey = "downloadCategoryID";

      $dbTools->newTable($tableName,$tableDefinition,$primaryKey);
      unset($tableDefinition);

      $i = 0;
  
      $tableName = "download_itemCategoryLink";

      $tableDefinition[$i]['name'] = "downloadItemID";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "downloadCategoryID";
      $tableDefinition[$i]['definition'] = "INT";

      $primaryKey = "downloadItemID,downloadCategoryID";

      $dbTools->newTable($tableName,$tableDefinition,$primaryKey);
      unset($tableDefinition);

      $i = 0;

      $tableName = "download_fileInfo":

      $tableDefinition[$i]['name'] = "fileID";
      $tableDefinition[$i]['definition'] = "INT NOT NULL AUTO_INCREMENT";

      $tableDefinition[++$i]['name'] = "downloadItemID";
      $tableDefinition[$i]['definition'] = "INT";
    
      $tableDefinition[++$i]['name'] = "filname";
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "size";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "versionInternal";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "versionExternal";
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "dateUploaded";
      $tableDefinition[$i]['definition'] = "INT";

      $primaryKey = "fileID";
 
      $dbTools->newTable($tableName,$tableDefinition,$primaryKey);
      unset($tableDefinition);
  
      $i = 0;
    
      $tableName = "download_ratingCategories";
    
      $tableDefinition[$i]['name'] = "ratingCategoryID";
      $tableDefinition[$i]['definition'] = "INT NOT NULL AUTO_INCREMENT";

      $tableDefinition[++$i]['name'] = "name";
      $tableDefinition[$i]['definition'] = "TEXT";

      $primaryKey = "ratingCategoryID";

      $dbTools->newTable($tableName,$tableDefinition,$primaryKey);
      unset($tableDefinition);

      $i = 0;

      $tableName = "download_itemRatings";

      $tableDefinition[$i]['name'] = "memberID";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "downloadItemID";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "ratingCategoryID";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "versionInternal";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "rating";
      $tableDefinition[$i]['definition'] = "INT";

      $primaryKey = "memberID,downloadItemID,versionInternal";      

      $dbTools->newTable($tableName,$tableDefinition,$primaryKey);
      unset($tableDefinition);

    }
  
  }

?>
