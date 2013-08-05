<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

namespace lib\users;
use lib\db\SQL;

abstract class User {
  
  protected $id;
  protected $login; // email = login
  protected $password;
  protected $created;

  private $token = NULL;
  private $token_expire = NULL;
  const EXPIRATION = 180;
  
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
    if ($login != NULL && $this->acceptLogin($login) && preg_match('#^[a-z0-9._\+-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', strtolower(htmlspecialchars($login)))) {
      $this->login = strtolower(htmlspecialchars($login));
      return true;
    }
    return false;
  }
  public function acceptLogin($login) {
    return !in_array($login, $this->getLogins());
  }
  
  protected static function hash_password($password, $login) {
    return hash('sha512', $login . $password . $login);
  }
  public function setPassword($password, $length = 7) {
    if ($password != NULL && strlen($password) >= $length && $this->login != NULL) {
      $this->password = self::hash_password($password, $this->login);
      return true;
    }
    return false;
  }
  
  public function gravatar($size = 50, $type = 'retro') {
    return '//gravatar.com/avatar/' . md5(strtolower(trim($this->login()))) . '?size=' . $size . '&amp;default=' . $type;
  }
  public static function getGravatar($login, $size = 50, $type = 'retro') {
    return '//gravatar.com/avatar/' . md5(strtolower(trim($login))) . '?size=' . $size . '&amp;default=' . $type;
  }

  public function token() {
    $this->token = md5(rand());
    $this->token_expire = time() + self::EXPIRATION;
    return $this->token;
  }
  public function acceptToken($token) {
    if (time() <= $this->token_expire && $this->token == $token) {
      $this->token = NULL;
      $this->token_expire = NULL;
      return true;
    }
    return false;
  }

  protected abstract function getLogins();
  public abstract function create();
  //public abstract static function getID($login);
  //public abstract static function isAuthorizedUser($login, $pwd);
  //public abstract static function isUser($login);
  
}

?>