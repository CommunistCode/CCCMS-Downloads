<?php

  require_once(FULL_PATH."/download/classes/torrent.class.php");

  $pageTools = new pageTools();

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
      $torrent = new torrent($id);
      $args = array("torrent"=>$torrent, "categoryID"=>$categoryID);
      
      $torrentInfoBox = $pageTools->render("includes/torrentInfoBox.inc.php", $args, "arg");
      echo($torrentInfoBox."<br />"); 

    }

  }

?>
