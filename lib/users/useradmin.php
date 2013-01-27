<?php

namespace lib\users;
use lib\users\User;
use lib\db\SQL;

class UserAdmin extends User {
  
  private $name;
  private $privilege;
  /**
   * 0 disabled
   * 1 referent
   * 7 manager
   * 8 administrator
   * 9 god
   */
  
  public function __construct($id = null) {
    if ($id != null) {
      $query = SQL::sql()->prepare('SELECT login, email, name, privilege FROM fsc_users_admin WHERE id = ?');
      $query->execute(array($id+0));
      $data = $query->fetch();
      $this->id = $id;
      $this->login = $data['login'];
      $this->email = $data['email'];
      $this->name = $data['name'];
      $this->privilege = $data['privilege'];
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
  
  public function privilege() {
    return $this->privilege;
  }
  public function setPrivilege($int) {
    if ($int == 1 || $int >= 7 && $int <= 8)
      $this->privilege = $int;
    else $this->privilege = 0;
    return true;
  }
  
  public static function getName($login) {
    $query = SQL::sql()->prepare('SELECT name FROM fsc_users_admin WHERE login = ?');
    $query->execute(array(htmlspecialchars($login)));
    $data = $query->fetch();
    return $data['name'];
  }
  
  public static function getID($login) {
    $query = SQL::sql()->prepare('SELECT id FROM fsc_users_admin WHERE login = ?');
    $query->execute(array(htmlspecialchars($login)));
    $data = $query->fetch();
    return $data['id'];
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
  
  public static function history($user, $ip) {
    $query = SQL::sql()->prepare('INSERT INTO fsc_history_admin(id_user_admin, ip) VALUES(:user, :ip)');
    $query->execute(array(
      'user' => $user,
      'ip' => $ip
    ));
    $query->closeCursor();
  }
  public static function getHistory() {
    $query = SQL::sql()->query('SELECT fsc_users_admin.name, fsc_users_admin.privilege, fsc_users_admin.email, date, ip FROM fsc_history_admin INNER JOIN fsc_users_admin ON fsc_users_admin.id = fsc_history_admin.id_user_admin ORDER BY fsc_history_admin.id DESC');
    $return = array();
    while ($data = $query->fetch())
      $return[] = array(
        'name' => $data['name'],
        'email' => $data['email'],
        'date' => $data['date'],
        'privilege' => $data['privilege'],
        'ip' => $data['ip']
      );
    $query->closeCursor();
    return $return;
  }
  public static function getUserHistory($user) {
    $query = SQL::sql()->prepare('SELECT date, ip FROM fsc_history_admin WHERE id_user_admin = ? ORDER BY id DESC');
    $query->execute(array($user));
    $return = array();
    while ($data = $query->fetch())
      $return[] = array(
        'date' => $data['date'],
        'ip' => $data['ip']
      );
    $query->closeCursor();
    return $return;
  }
  
}

?>