<?php

  if (isset($_GET['session']) && $_GET['session'] == "new") {

    unset($_SESSION['torrent']);

  }

  if (isset($_SESSION['torrent'])) {

    require_once($fullPath."/download/classes/torrent.class.php");
    
    $torrent = unserialize($_SESSION['torrent']);

    $torrentInfo = $torrent->getInfoArray();

    echo("<br /><p>You are currently editing a torrent, click <a href='uploadItem.php?session=new'>Here</a> to start fresh</p>");


  } else {

    $torrentInfo['name'] = "";
    $torrentInfo['externalVersion'] = "";
    $torrentInfo['developer'] = "";
    $torrentInfo['description'] = "";
    $torrentInfo['location'] = "";

  }

?>

<br />

<form action='uploadItem.php' enctype="multipart/form-data" method="post" >

  <table class='uploadItemTable'>

    <tr>
      <th><label for='itemName'>Name:</label></th>
      <td><input type='text' name='itemName' value='<?php echo($torrentInfo['name']); ?>' /></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th><label for='itemVersion'>Version:</label></th>
      <td><input type='text' name='itemVersion' value='<?php echo($torrentInfo['externalVersion']); ?>'/></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th><label for='itemCreator'>Developer:</label></th>
      <td><input type='text' name='itemDeveloper' value='<?php echo($torrentInfo['developer']); ?>'/></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th><label for='itemDesc'>Description:</label></th>
      <td><textarea cols=60 rows=15 name='itemDesc'><?php echo($torrentInfo['description']); ?></textarea></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>

    <tr>
      <th>Category:</th>
      <td><select name='itemCat[]'><?php $downloadTools->renderCategorySelectOptions(); ?></select></td>
    </tr>

    <tr>
      <td class='spacer'></td>
    </tr>
    
    <tr>
      <th><label for='itemFile'>Torrent File:</label></th>
      
      <?php

        if ($torrentInfo['location'] != "") {

          echo("<td><strong>".$torrentInfo['originalFilename']."</strong></td>");

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
