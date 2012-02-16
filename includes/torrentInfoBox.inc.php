<?php 

  // This is an include designed for use with the render method, so check for required variables

  if (!isset($arg_id)) {

    echo("id variable was not passed!"); 

  }
  
  require_once($GLOBALS['fullPath']."/membership/classes/memberTools.class.php"); 
  require_once($GLOBALS['fullPath']."/download/classes/torrent.class.php");

  $memberTools = new memberTools();
  
  $torrent = new torrent($arg_id);

  $categoryList = $torrent->getCategoryArray();

?>

<div class='torrentInfoBox'>
  <div class='nameVersion'>
    <div class='name'><strong>Image Name: </strong> <?php echo($torrent->getName()); ?></div>
    <div class='version'><strong>Version: </strong><?php echo($torrent->getVersionExternal()); ?></div>
    <div class='clear'></div>
  </div>

  <div class='description'>
    <div class='descriptionTitle'><strong>Description</strong></div>
    <div class='descriptionText'><?php echo(nl2br($torrent->getDescription())); ?></div>
    <div class='clear'></div>
  </div>

  <div class='dateDevel'>
    <div class='dateUploaded'><strong>Date Uploaded: </strong><?php echo(date("j/n/y - G:i",$torrent->getdateUploaded())); ?></div>
    <div class='developer'><strong>Developer: </strong><?php echo($torrent->getDeveloper()); ?></div>
    <div class='developer'><strong>Uploader: </strong><?php echo($memberTools->getUsername($torrent->getUploaderID())); ?></div>
    <div class='clear'></div>
  </div>
  
  <div class='categories'>
    <div><strong>Categories: <?php echo(implode($categoryList,",")); ?></strong></div>
  </div>
</div>
