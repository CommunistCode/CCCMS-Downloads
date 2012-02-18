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

      $tableDefinition[$i]['name'] = "downloadItemID";
      $tableDefinition[$i]['definition'] = "INT NOT NULL AUTO_INCREMENT";

      $tableDefinition[++$i]['name'] = "name";
      $tableDefinition[$i]['definition'] = "TEXT";
 
      $tableDefinition[++$i]['name'] = "description";
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "dateUploaded";
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "developer";
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

      $tableName = "download_fileInfo";

      $tableDefinition[$i]['name'] = "fileID";
      $tableDefinition[$i]['definition'] = "INT NOT NULL AUTO_INCREMENT";

      $tableDefinition[++$i]['name'] = "downloadItemID";
      $tableDefinition[$i]['definition'] = "INT";
    
      $tableDefinition[++$i]['name'] = "filename";
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "size";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "versionInternal";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "versionExternal";
      $tableDefinition[$i]['definition'] = "TEXT";

      $tableDefinition[++$i]['name'] = "dateUploaded";
      $tableDefinition[$i]['definition'] = "INT";

      $tableDefinition[++$i]['name'] = "changeLog";
      $tableDefinition[$i]['definition'] = "TEXT";

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

    public function populateTables() {

      $db  = new dbConn();

      $adminDBTools = new adminDBTools();

      if ($db->checkExists("version","module","download")) {

        echo("Version already populated!<br />");

      } else {

        if ($db->insert("version","module,version,theme","'download','1.0.0','default'")) {

          echo("Version populated!<br />");
        
        }

      }

      $adminDBTools->newContent("Download Module","download/admin/downloadModule.php","main");
      $adminDBTools->newContent("Manage Categories","download/admin/manageDownloadCategories.php","Download Module");

      if ($db->checkExists("dContent","title","Downloads")) {

        echo("dContent already populated with downloads link");

      } else {

        if ($db->insert("dContent","title,linkName,directLink","'Downloads','Downloads','download/index.php'")) {

          echo("dContent populated with Downloads lnik");
  
        }

      }

    }
  
  }

?>
