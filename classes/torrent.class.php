<?php

  require_once($GLOBALS['fullPath']."/classes/pdoConn.class.php");

  class torrent {

    private $torrentPath; 
    private $pdoConn;

    protected $id;
    protected $name;
    protected $description;
    protected $dateUploaded;
    protected $developer;
    protected $versionExternal;
    protected $versionInternal;
    protected $uploaderID;
    protected $location;
    protected $fullPath;
    protected $filename;   

    protected $categories = array();

    function __construct($torrentID=NULL) {
   
      $this->pdoConn = new pdoConn();
 
      if ($torrentID) {

        $this->torrentPath = $GLOBALS['fullPath']."/download/files/torrents/";
        $this->loadTorrentInfoFromID($torrentID);

      }

    }

    private function loadTorrentInfoFromID($id) {

      $bindArray = array($id);

      $queryString = "
    
      SELECT 
        name, 
        description, 
        dateUploaded, 
        developer, 
        uploaderID, 
        versionExternal,
        filename

      FROM download_items dI 
        NATURAL JOIN download_itemCategoryLink dCL 
          NATURAL JOIN download_fileInfo dFI

      WHERE dI.downloadItemID = ?";

      $result = $this->pdoConn->customQuery($queryString,$bindArray);
      
      $torrentInfo = $result[0];

      $this->setName($torrentInfo['name']);
      $this->setDescription($torrentInfo['description']);
      $this->setDateUploaded($torrentInfo['dateUploaded']);
      $this->setDeveloper($torrentInfo['developer']);
      $this->setVersionExternal($torrentInfo['versionExternal']);
      $this->setUploaderID($torrentInfo['uploaderID']);
      $this->setFilename($torrentInfo['filename']);
      $this->setFullPath($this->torrentPath.$this->getFilename());

    }

    public function addCategory($category) {

      array_push($this->categories,$category);

    }

    public function getCategoryArray() {

      return $this->categories;

    }

    /* BASIC GETTERS && SETTERS */

    public function setFullPath($fullPath) {

      $this->fullPath = $fullPath;

    }

    public function getFullPath() {

      return $this->fullPath;

    }

    public function setName($name) {

      $this->name = $name;

    }

    public function getName() {

      return $this->name;

    }

    public function setDescription($desc) {
  
      $this->description = $desc;

    }

    public function getDescription() {

      return $this->description;

    }

    public function setDateUploaded($dateUploaded) {

      $this->dateUploaded = $dateUploaded;
  
    }

    public function getDateUploaded() {

      return $this->dateUploaded;

    }

    public function setDeveloper($origCreate) {

      $this->developer = $origCreate;

    }

    public function getDeveloper() {

      return $this->developer;

    }

    public function setVersionExternal($externalVer) {

      $this->versionExternal = $externalVer;

    }

    public function getVersionExternal() {

      return $this->versionExternal;

    }

    public function setUploaderID($uploaderID) {

      $this->uploaderID = $uploaderID;
    
    }

    public function getUploaderID() {

      return $this->uploaderID;

    }

    public function setFilename($filename) {

      $this->location = $filename;
      
    }

    public function getFilename() {

      return $this->filename;

    }
 
  }

?>
