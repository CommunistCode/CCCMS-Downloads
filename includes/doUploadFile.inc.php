<?php

  require_once($fullPath."/download/classes/downloadTools.class.php");
  require_once($fullPath."/download/classes/torrent.class.php");

  $downloadTools = new downloadTools();

  $downloadTools->insertNewTorrent(unserialize($_SESSION['torrent']));

  unset($_SESSION['torrent']);

?>

<p>Thank you, your torrent was sucessfully uploaded and added to the database!</p>
