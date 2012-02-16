<?php

  require_once($fullPath."/classes/pdoConn.class.php");

  $categoryID = 0;

  if (isset($_GET['categoryID'])) {

    $categoryID = $_GET['categoryID'];  

  }

  $pdoConn = new pdoConn();

  $bindArray = array();
  array_push($bindArray,$categoryID);
  
  $result = $pdoConn->customQuery("SELECT 
                                     downloadItemID
                                   FROM
                                     download_itemCategoryLink dICL
                                   WHERE
                                     dICL.downloadCategoryID = ?
                                   LIMIT 
                                     10", $bindArray);
  
  if (isset($result)) {

    foreach ($result as $row) {
      
      $id = $row['downloadItemID'];

      $args = array("id"=>$id);
         
      $torrentInfoBox = $pageTools->render("includes/torrentInfoBox.inc.php", $args);
      echo($torrentInfoBox."<br />"); 

    }

  }

?>
