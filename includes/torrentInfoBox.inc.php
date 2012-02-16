<?php 

  // This is an include designed for use with the render method, so check for required variables

  if (!isset($arg_torrent)) {

    echo("Torrent object was not recieved!");
    return; 

  }
  
  require_once($GLOBALS['fullPath']."/membership/classes/memberTools.class.php"); 

  $memberTools = new memberTools();
  
  $categoryList = implode(",",$arg_torrent->getCategoryArray()); 

?>

<div class='torrentInfoBox'>
  <div class='nameVersion'>
    <div class='name'><strong>Image Name: </strong> <a href='<?php echo($arg_torrent->getDownloadPath()); ?>'><?php echo($arg_torrent->getName()); ?></a></div>
    <div class='version'><strong>Version: </strong><?php echo($arg_torrent->getVersionExternal()); ?></div>
    <div class='clear'></div>
  </div>

  <div class='description'>
    <div class='descriptionTitle'><strong>Description</strong></div>
    <div class='descriptionText'><?php echo(nl2br($arg_torrent->getDescription())); ?></div>
    <div class='clear'></div>
  </div>

  <div class='dateDevel'>
    <div class='dateUploaded'><strong>Date Uploaded: </strong><?php echo(date("j/n/y - G:i",$arg_torrent->getdateUploaded())); ?></div>
    <div class='developer'><strong>Developer: </strong><?php echo($arg_torrent->getDeveloper()); ?></div>
    <div class='developer'><strong>Uploader: </strong><?php echo($memberTools->getUsername($arg_torrent->getUploaderID())); ?></div>
    <div class='clear'></div>
  </div>
  
  <div class='categories'>
    <div><strong>Categories: <?php echo($categoryList); ?></strong></div>
  </div>
</div>
