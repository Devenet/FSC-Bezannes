<?php

namespace lib\users;
use lib\users\User;
use lib\db\SQL;

class UserAdmin extends User {
  
  private $id;
  private $login;
  private $password;
  private $name;
  private $created;
  
  public function __construct($id = null) {
    if ($id != null) {
      $query = SQL::sql()->prepare('SELECT login, password, name FROM fsc_users_admin WHERE id = :id');
      $query->execute(array($id));
      $data = $query->fetch();
      $this->id = $id;
      $this->login = $data['login'];
      $this->password = $data['password'];
      $this->name = $data['name'];
      $query->closeCursor();
      $this->created = true;
    }
    else
      $created = false;
  }
  
  public function name() {
    return $this->name;
  }
  public function setName($string) {
    $this->name = htmlspecialchars($string);
  }
  
  public static function getName($login) {
    $query = SQL::sql()->prepare('SELECT name FROM fsc_users_admin WHERE login = ?');
    $query->execute(array(htmlspecialchars($login)));
    $data = $query->fetch();
    return $data['name'];
  }
  
  public static function isAuthorizedUser($login, $pwd) {
    $query = SQL::sql()->query('SELECT login, password FROM fsc_users_admin');
    $logins = array();
    $passwords = array();
    while ($data = $query->fetch()) {
      $logins[] = $data['login'];
      $passwords[] = $data['password'];
    }
    $query->closeCursor();
    return in_array(htmlspecialchars($login), $logins) && in_array(md5(htmlspecialchars($pwd)), $passwords);
  }
  
  
}

?>