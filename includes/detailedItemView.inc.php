<link href="<?php echo(DIRECTORY_PATH); ?>/download/themes/<?php echo(THEME); ?>/stylesheets/detailedTorrentInfo.css" rel="stylesheet" />    

<?php

  require_once("classes/torrent.class.php");
  require_once(FULL_PATH."/membership/classes/memberTools.class.php");

  $torrent = new torrent($_GET['id']);
  $memberTools = new memberTools();
  $pageTools = new pageTools();
  $downloadTools = new downloadTools();

?>

<div class='detailedTorrentInfo'>

  <table>

    <tr>
      <th>Name</th>
      <td><?php echo($torrent->getName()); ?></td>
    </tr>

    <tr>
      <th>Download</th>
      <td><a href='<?php echo($torrent->getDownloadPath()); ?>'><?php echo($torrent->getFilename()); ?></a></td>
    </tr>

    <tr>
      <th>Developer</th>
      <td><?php echo($torrent->getDeveloper()); ?></td>
    </tr>

    <tr>
      <th>Uploader</th>
      <td><?php echo($memberTools->getUsername($torrent->getUploaderID())); ?></td>
    </tr>

    <tr>
      <th>Version</th>
      <td><?php echo($torrent->getVersionExternal()); ?> <a class='extraDetail' href='viewVersions.php?downloadItemID=<?php echo($torrent->getID()); ?>'>View Older Versions</a></td>
    </tr>

    <tr>
      <th>Categories</th>
      <td><?php echo($downloadTools->getTorrentCategoryNameArray($torrent)); ?></td>
    </tr>

    <tr>
      
<th>Change Log</th>
      <td><?php echo($pageTools->matchTags($torrent->getChangeLog())); ?><a class='extraDetail' href=''>View All Change Logs</a></td>
    </tr>

    <tr class='lastRow'>
      <th>Description</th>
      <td><?php echo($pageTools->matchTags($torrent->getDescription())); ?></td>    </tr>

  </table>

  <a href='index.php?categoryID=<?php echo($_GET['categoryID']); ?>'> << Back to Category</a> |
  <a href='updateVersion.php?downloadItemID=<?php echo($torrent->getID()); ?>'>Submit New Version</a> |
  <a href=''>Edit Details</a>

</div>
