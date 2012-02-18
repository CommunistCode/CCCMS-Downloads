<?php

  require_once($fullPath."/download/classes/downloadTools.class.php");
  require_once($fullPath."/download/classes/torrent.class.php");

  $downloadTools = new downloadTools();

  $downloadTools->addNewTorrentVersion(unserialize($_SESSION['updateTorrent']));

  unset($_SESSION['updateTorrent']);
  unset($_SESSION['originalFilename']);

?>

<p>Thank you, your update was successful!</p>
