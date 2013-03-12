<?php

namespace lib\users;
use lib\db\SQL;

abstract class User {
  
  protected $id;
  protected $login; // email = login
  protected $password;
  protected $created;
  
  public function id() {
    return $this->id;
  }
  
  public function login() {
    return $this->login;
  }
  public function email() {
    return $this->login;
  }
  public function setLogin($login) {
    if ($login != null && $this->acceptLogin($login) && preg_match('#^[a-z0-9._\+-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', strtolower(htmlspecialchars($login)))) {
      $this->login = strtolower(htmlspecialchars($login));
      return true;
    }
    return false;
  }
  public function acceptLogin($login) {
    return !in_array($login, $this->getLogins());
  }
  
  protected static function hash_password($password, $login) {
    return sha1($login . $password . $login);
  }
  public function setPassword($password, $length = 7) {
    if ($password != null && strlen($password) >= $length && $this->login != null) {
      $this->password = self::hash_password($password, $this->login);
      return true;
    }
    return false;
  }
  
  protected abstract function getLogins();
  public abstract function create();
  //public abstract static function getID($login);
  //public abstract static function isAuthorizedUser($login, $pwd);
  
}

?>