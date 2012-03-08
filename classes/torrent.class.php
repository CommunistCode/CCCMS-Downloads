<?php

  class torrent {

    private $torrentPath; 
    private $pdoConn;

    protected $id;
    protected $name;
    protected $description;
    protected $changeLog;
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
   
      if ($torrentID) {

        $this->pdoConn = new pdoConn();
        $this->torrentPath = "/download/files/torrents/";
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
        filename,
        changeLog

      FROM download_items dI 
        NATURAL JOIN download_itemCategoryLink dCL 
          NATURAL JOIN download_fileInfo dFI

      WHERE dI.downloadItemID = ?
      ORDER BY versionInternal DESC
      LIMIT 1";

      $result = $this->pdoConn->customQuery($queryString,$bindArray);
      
      $torrentInfo = $result[0];

      $this->id = $id;
      $this->setName($torrentInfo['name']);
      $this->setDescription($torrentInfo['description']);
      $this->setDateUploaded($torrentInfo['dateUploaded']);
      $this->setDeveloper($torrentInfo['developer']);
      $this->setChangeLog($torrentInfo['changeLog']);
      $this->setVersionExternal($torrentInfo['versionExternal']);
      $this->setUploaderID($torrentInfo['uploaderID']);
      $this->setFilename($torrentInfo['filename']);
      $this->setFullPath($GLOBALS['fullPath'].$this->torrentPath.$this->getFilename());
      $this->setDownloadPath($this->torrentPath.$this->getFilename());
      
      $table = "download_itemCategoryLink";
      $fields = array("downloadCategoryID");

      $where[0]['column'] = "downloadItemID";
      $where[0]['value'] = $id;

      $result = $this->pdoConn->select($fields,$table,$where);

      foreach($result as $row) {

        $this->addCategory($row['downloadCategoryID']);

      }

    }

    public function addCategory($category) {

      array_push($this->categories,$category);

    }

    public function removeCategory($categoryID) {

      $arrayID = array_search($categoryID,$this->categories);

      unset($this->categories[$arrayID]);

    }

    public function getCategoryArray() {

      return $this->categories;

    }

    /* BASIC GETTERS && SETTERS */
 
    public function setChangeLog($changeLog) {

      $this->changeLog = $changeLog;
    
    }

    public function getChangeLog() {

      return $this->changeLog;

    }

    public function setID($id) {

      $this->id = $id;

    }
 
    public function getID() {

      return $this->id;

    }

    public function setDownloadPath($downloadPath) {
    
      $this->downloadPath = $downloadPath;
  
    }

    public function getDownloadPath() {

      return $this->downloadPath;

    }

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

      $this->filename = $filename;
      
    }

    public function getFilename() {

      return $this->filename;

    }
 
  }

?>
