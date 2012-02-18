<?php 

  // This is an include designed for use with the render method, so check for required variables

  if (!isset($arg_torrent)) {

    echo("Torrent object was not passed to include!");
    return; 

  }

  require_once($GLOBALS['fullPath']."/membership/classes/memberTools.class.php"); 

  $memberTools = new memberTools();
  $downloadTools = new downloadTools();

?>

<table>
  <tr>
    <th>Version</th>
    <td><?php echo($arg_torrent->getVersionExternal()); ?></td>
  </tr>
  <tr>
    <th>Uploader</th>
    <td><?php echo($memberTools->getUsername($arg_torrent->getUploaderID())); ?></td>
  </tr>
  <tr>
    <th>Developer</th>
    <td><?php echo($arg_torrent->getDeveloper()); ?></td>
  </tr>
  <tr>
    <th>Date Uploaded</th>
    <td><?php echo(date("j/n/y",$arg_torrent->getdateUploaded())); ?></td>
  </tr>
  <tr>
    <th>Change Log</th>
    <td><?php echo($arg_torrent->getChangeLog()); ?></td>
  </tr>
</table>
