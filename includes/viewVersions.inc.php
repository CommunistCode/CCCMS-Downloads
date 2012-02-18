<?php

  require_once($GLOBALS['fullPath']."/download/classes/downloadTools.class.php");
  require_once($GLOBALS['fullPath']."/download/classes/torrent.class.php");

  $downloadTools = new downloadTools();

  $torrent = new torrent($_GET['downloadItemID']);
  $imageVersions = $downloadTools->getVersionsArray($_GET['downloadItemID']);

?>

<table class='viewVersions'>

  <tr>
    <th>Image Name</th>
    <td><?php echo($torrent->getName()); ?></td>
  </tr>

  <tr>
    <th>Versions</th>

    <td>

      <?php
      
        foreach($imageVersions as $version) {
      
          echo("<a href='viewDetails.php?id=".$torrent->getID()."&versionInternal=".$version['versionInternal']."'>".$version['versionExternal']."</a><br/>");

        }

      ?>

    </td>

  </tr>

</table>
