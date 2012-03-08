<?php

  require_once("classes/torrent.class.php");

  $downloadTools = new downloadTools();

  $downloadTools->insertNewTorrent(unserialize($_SESSION['torrent']));

  unset($_SESSION['torrent']);
  unset($_SESSION['originalFilename']);

?>

<p>Thank you, your torrent was sucessfully uploaded and added to the database!</p>
