<?php

  $downloadTools = new downloadTools();

  if (isset($_GET['session']) && $_GET['session'] == "new") {

    unset($_SESSION['torrent']);
    unset($_SESSION['originalFilename']);

  }

  if (isset($_SESSION['torrent'])) {

    require_once($fullPath."/download/classes/torrent.class.php");
    
    $torrent = unserialize($_SESSION['torrent']);

    $name = $torrent->getName();
    $developer = $torrent->getDeveloper();
    $description = $torrent->getDescription();
    $versionExternal = $torrent->getVersionExternal();
    $change = $torrent->getChangeLog();
    $categories = $torrent->getCategoryArray();

    echo("<br /><p>You are currently editing a torrent, click <a href='uploadItem.php?session=new'>Here</a> to start fresh</p>");


  } else {

    $name = "";
    $developer = "";
    $description = "";
    $versionExternal = "";
    $change = "";
    
  } 

?>

<br />

<form action='uploadItem.php' enctype="multipart/form-data" method="post" >

  <table class='uploadItemTable'>

    <tr>
      <th><label for='itemName'>Distro Name:</label></th>
      <td><input type='text' name='itemName' value='<?=$name?>' /></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th><label for='itemVersion'>Version:</label></th>
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
      <th><label for='itemDesc'>Description:</label></th>
      <td><textarea cols=60 rows=15 name='itemDesc'><?=$description?></textarea></td>
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
      <th>Category:</th>
      <td>
      <?php 

        if (!isset($categories)) {

          echo("<select name='itemCat[]'>");
          $downloadTools->renderCategorySelectOptions();
          echo("</select>");

        } else {
  
          echo($downloadTools->getTorrentCategoryNameArray($torrent));

        }

      ?>
    </td>
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
      <td><input type='submit' value='Preview Submission' name='uploadFile' /></td>
    </tr>

  </table>

</form>
