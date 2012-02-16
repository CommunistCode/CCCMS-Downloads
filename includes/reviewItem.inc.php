<?php

  require_once($fullPath."/helperClasses/torrentDecoder/torrentDecoder.class.php");
  require_once($fullPath."/download/classes/downloadTools.class.php");
  require_once($fullPath."/download/classes/torrent.class.php");

  $downloadTools = new downloadTools();

  $error = null;

  if (!isset($_FILES['itemFile']['tmp_name']) && !isset($_SESSION['torrent'])) {

    echo("File could not be uploaded!");
    return;

  } else if (isset($_SESSION['torrent'])) {

    $torrent = unserialize($_SESSION['torrent']);
    $torrentDecoder = new torrentDecoder($torrent->getFullPath());

  } else {

    try {
    
      $torrentDecoder = new torrentDecoder($_FILES['itemFile']['tmp_name']);
      $decodedTorrent = $torrentDecoder->getDecodedTorrent();
    
    } catch (Exception $e) {

      echo("File was either corrupt or not a torrent!<br />");
      echo("Bencode decode failed with: ".$e->getMessage());
      return;

    }

    try { 
  
      $torrentFiles = $torrentDecoder->getFiles();

      if (count($torrentFiles) <= 1) {

        throw new Exception("Torrent file did not follow guidelines, only 1 or less files were found!");

      }

      if (count($torrentFiles) != 2) {

        throw new Exception("Torrent file did not follow guidelines, only 2 files should be present!");

      } 

      $image = 0;
      $readme = 0;
  
      foreach ($torrentFiles as $filename) {

        if (substr($filename,-8) == ".tar.bz2") {

          $image = 1;
          $type = "bz2";

        }

        if (substr($filename,-4) == ".img") {

          $image = 1;
          $type = "image";

        }

        if ($filename == "README") {

          $readme = 1;

        } 

      }
  
      if (!($readme && $image)) {
    
        throw new Exception("Torrent did not follow guidelines, there must be a .tar.bz2/.img image and README file!");

      }

    } catch (Exception $e) {

      echo($e->getMessage());
      return;

    }

    $torrent = new torrent();
    $downloadTools->storeTempTorrent($_FILES['itemFile'],$torrent);

  }

  $member = unserialize($_SESSION['member']);

  $torrent->setName($_POST['itemName']);
  $torrent->setDescription($_POST['itemDesc']);
  $torrent->setDateUploaded(time());
  $torrent->setDeveloper($_POST['itemDeveloper']);
  $torrent->setVersionExternal($_POST['itemVersion']);
  $torrent->setUploaderID($member->getID());

  foreach($_POST['itemCat'] as $itemCategory) {

    $torrent->addCategory($itemCategory);

  }
 
  if (!isset($torrentFiles)) {
 
    $torrentFiles = $torrentDecoder->getFiles();

  }

?>

<p>Please look over the following information and ensure it is correct, if you wish to change something then click the edit button.</p>
<br />

<?php 

  $args = array("torrent"=>$torrent);

  echo($pageTools->render("includes/torrentInfoBox.inc.php",$args)); 

?>

<br />

<table class='torrentFiles'>
  <tr>
    <th>Summary of Files in Torrent</th>
  </tr>

<?php 

  foreach($torrentFiles as $filename) {

    echo("<tr><td>".$filename."</td></tr>");

  }

?>

</table>

<?php

  $serialisedTorrent = serialize($torrent);
  $_SESSION['torrent'] = $serialisedTorrent;

?>

<br />

<form action='uploadItem.php' method='post'>
  <input type='submit' value='Upload!' name='doUpload' />
  <input type='submit' value='Edit' name='edit' />
</form>
