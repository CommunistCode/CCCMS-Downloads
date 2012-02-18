<?php

  require_once($fullPath."/download/classes/torrent.class.php");
  
  if (isset($_SESSION['updateTorrent'])) {

    if (isset($_GET['session']) && $_GET['session'] == "new") {

      unset($_SESSION['updateTorrent']);
      unset($_SESSION['originalFilename']);

    } else {

      $torrent = unserialize($_SESSION['updateTorrent']);

      echo("You are currently in editing mode <a href='updateVersion.php?itemDownloadID=".$_POST['downloadItemID']."'>click here</a> to start fresh.<br />");

    }

  }

  if (!isset($_GET['downloadItemID']) && !isset($torrent)) {

    echo("To update a version must must find the image in the download section and click update!");
    return;

  } 

  $currentTorrent = new torrent($_GET['downloadItemID']);
      
  if (isset($_SESSION['torrent'])) {
  
    if (isset($_GET['session']) && $_GET['session'] == "new") {

      unset($_SESSION['torrent']);
      unset($_SESSION['originalFilename']);

    } else {

      echo("You haven't finished creating your last torrent, do you wish to lose these changes and update an image version instead?");

      echo("<br /><br /><a href='updateVersion.php?session=new&downloadItemID=".$_GET['downloadItemID']."'>Yes, I want to update an image version</a> | <a href='uploadItem.php'>No, I want to continue creating my new torrent!</a>i<br />");

    }

  } 

  if (isset($_SESSION['updatedTorrent'])) {

    $versionExternal = $torrent->getVersionExternal();
    $developer = $torrent->getDeveloper();
    $change = $torrent->getChangeLog();

  } else {

    $versionExternal = "";
    $developer = $currentTorrent->getDeveloper();
    $change = "";
    
  }

?>

<br />

<form action='updateVersion.php' enctype="multipart/form-data" method="post" >

  <input type='hidden' name='downloadItemID' value='<?php echo($_GET['downloadItemID']); ?>' />

  <table class='uploadItemTable'>

    <tr>
      <th>Image Name:</th>
      <td><?=$currentTorrent->getName();?></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th>Current Version: </th>
      <td><?=$currentTorrent->getVersionExternal();?></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th><label for='itemVersion'>New Version:</label></th>
      <td><input type='text' name='itemVersion' value='<?=$versionExternal?>'/></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th><label for='itemCreator'>Developer:</label></th>
      <td><input type='text' name='itemDeveloper' value='<?=$developer?>'/></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th><label for='itemChange'>Change Log:</label></th>
      <td><textarea cols=60 rows=5 name='itemChange'><?=$change?></textarea></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>
    
    <tr>
      <th><label for='itemFile'>Torrent File:</label></th>
      
      <?php

        if (isset($_SESSION['originalFilename'])) {

          echo("<td><strong>".$_SESSION['originalFilename']."</strong></td>");

        } else {

          echo("<td><input type='file' name='itemFile'/></td>");

        }

      ?>

    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th></th>
      <td><input type='submit' value='Preview Update' name='uploadFile' /></td>
    </tr>

  </table>

</form>
