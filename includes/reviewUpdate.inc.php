<?php

  require_once($fullPath."/helperClasses/torrentDecoder/torrentDecoder.class.php");
  require_once($fullPath."/download/classes/downloadTools.class.php");
  require_once($fullPath."/download/classes/torrent.class.php");

  $downloadTools = new downloadTools();

  $error = null;

  if (!isset($_FILES['itemFile']['tmp_name']) && !isset($_SESSION['updateTorrent'])) {

    echo("File could not be uploaded!");
    unset($_SESSION['updateTorrent']);
    unset($_SESSION['originalFilename']);
    return;

  } else if (isset($_SESSION['updateTorrent'])) {

    $torrent = unserialize($_SESSION['updateTorrent']);
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

    $currentTorrent = new torrent($_POST['downloadItemID']);
    $torrent = new torrent();
    $downloadTools->storeTempTorrent($_FILES['itemFile'],$torrent);

  }

  $member = unserialize($_SESSION['member']);

  $torrent->setID($_POST['downloadItemID']);
  $torrent->setDateUploaded(time());
  $torrent->setName($currentTorrent->getName());
  $torrent->setDeveloper($_POST['itemDeveloper']);
  $torrent->setVersionExternal($_POST['itemVersion']);
  $torrent->setUploaderID($member->getID());
  $torrent->setChangeLog($_POST['itemChange']);

  if (!isset($torrentFiles)) {
 
    $torrentFiles = $torrentDecoder->getFiles();

  }

?>

<p>Please look over the following information and ensure it is correct, if you wish to change something then click the edit button.</p>
<br />

<?php 

  $args = array("torrent"=>$torrent);

  echo($pageTools->render("includes/torrentUpdateInfoBox.inc.php",$args)); 

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
  $_SESSION['updateTorrent'] = $serialisedTorrent;

?>

<br />

<form action='updateVersion.php' method='post'>
  <input type='hidden' value='<?php echo($_GET['downloadItemID']); ?>' name='downloadItemID' />
  <input type='submit' value='Upload!' name='doUpload' />
  <input type='submit' value='Edit' name='edit' />
</form>
