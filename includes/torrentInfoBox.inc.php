<?php 

  // This is an include designed for use with the render method, so check for required variables

  if (!isset($arg_torrent)) {

    echo("Required variables were not passed to include!");
    return; 

  }

  require_once(FULL_PATH."/".MEMBER_MODULE_DIR."/classes/memberTools.class.php"); 

  $memberTools = new memberTools();
  $downloadTools = new downloadTools();

  $categoryList = array();
  $categoryArray = $arg_torrent->getCategoryArray();  

  foreach ($categoryArray as $categoryID) {
   
    $categoryLink = "<a href='index.php?categoryID=".$categoryID."'>".$downloadTools->getCategoryName($categoryID)."</a>";
 
    array_push($categoryList,$categoryLink);

  } 

  $categoryList = implode(",", $categoryList); 

$description = nl2br($arg_torrent->getDescription());

if (strlen($description) > 200)
{

  $description = substr($description, 0, 200);
  $description = $description."<a href='viewDetails.php?id=".$arg_torrent->getID()."'>&hellip;</a>";

}

?>

<div class='torrentInfoBox'>
  <div class='nameVersion'>
    <div class='name'><strong>Image Name: </strong> <a href='viewDetails.php?id=<?php echo($arg_torrent->getID()); ?>&categoryID=<?php echo($arg_categoryID); ?>'><?php echo($arg_torrent->getName()); ?></a></div>
    <div class='download'><strong>Download: </strong> <a href='<?php echo($arg_torrent->getDownloadPath()); ?>'><?php echo($arg_torrent->getFilename()); ?></a></div>
    <div class='version'><strong>Version: </strong><?php echo($arg_torrent->getVersionExternal()); ?></div>
    <div class='clear'></div>
  </div>

  <div class='description'>
    <div class='descriptionTitle'><strong>Description</strong></div>
    <div class='descriptionText'><?php echo($description); ?></div>
    <div class='clear'></div>
  </div>

  <div class='dateDevel'>
    <div class='dateUploaded'><strong>Date Uploaded: </strong><?php echo(date("j/n/y",$arg_torrent->getdateUploaded())); ?></div>
    <div class='developer'><strong>Developer: </strong><?php echo($arg_torrent->getDeveloper()); ?></div>
    <div class='uploader'><strong>Uploader: </strong><?php echo($memberTools->getUsername($arg_torrent->getUploaderID())); ?></div>
    <div class='clear'></div>
  </div>
  
  <div class='categories'>
    <div><strong>Categories: </strong><?php echo($categoryList); ?></div>
  </div>
</div>
