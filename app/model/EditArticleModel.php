<?php
namespace model;

class EditArticleModel extends \db\Database {
  private $iduser,
          $ref;

  public function __construct ($iduser, $ref) {
    parent::__construct();
    $this->iduser = $iduser;
    $this->ref = $ref;
  }

  public function create () {
    $date = new \DateTime();
    $timeStamp = $date->getTimestamp();
    $timeCreated = date('Y-m-d H:i:s', $timeStamp);

    $query = "UPDATE articles
    SET created = ?, draft = 0
    WHERE iduser = ? AND articleref = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('sss', $timeCreated, $this->iduser, $this->ref);
    $execution = $stmt->execute();
    $stmt->close();

    return $execution;
  }

  public function save ($title, $text, $tags) {
    if (!$this->validateSave($title, $text, $tags)) return false;

    $date = new \DateTime();
    $timeStamp = $date->getTimestamp();
    $timeSaved = date('Y-m-d H:i:s', $timeStamp);

    $query = "UPDATE articles
    SET title = ?, text = ?, tags = ?, lastSaved = ?
    WHERE iduser = ? AND articleref = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ssssss', $title, $text, json_encode($tags), $timeSaved, $this->iduser, $this->ref);
    $execution = $stmt->execute();
    $stmt->close();

    return $execution ? $timeSaved : false;
  }

  public function validateSave ($title, $text, $tags) {
    if (strlen($title) == 0 || strlen($title) > 100 ) return false;
    if (strlen($text) < 100 && strlen($text) > 10000) return false;
    if (count($tags) == 0 || count($tags) > 5 || count($tags) != count(array_unique($tags))) return false;

    foreach($tags as $tag) {
      if (strlen($tag) < 2 || strlen($tag) > 20) return false;
      if (!ctype_alnum(str_replace(' ', '', $tag))) return false;
    }

    return true;
  }

  public function validateEdit () {
    $query = "SELECT text
    FROM articles
    WHERE iduser = ?
    AND articleref = ?";

    $stmt = ($this->conn)->prepare($query);
    $stmt->bind_param('ss', $this->iduser, $this->ref);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    $stmt->close();

    return $rows == 1;
  }
}