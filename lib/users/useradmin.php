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
      $query = SQL::sql()->prepare('SELECT login, password, name, privilege FROM fsc_users_admin WHERE id = ?');
      $query->execute(array($id+0));
      $data = $query->fetch();
      $this->id = $id;
      $this->login = $data['login'];
      $this->password = $data['password'];
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
  
  public function create() {
    
  }
  
  public function lastHistory() {
    $query = SQL::sql()->prepare('SELECT id, date, ip FROM fsc_history_admin WHERE id_user_admin = ? ORDER BY date DESC');
    $query->execute(array($this->id));
    $data = $query->fetch();
    return $data;
  }
  
  public static function getID($login) {
    $query = SQL::sql()->prepare('SELECT id FROM fsc_users_admin WHERE login = ?');
    $query->execute(array(htmlspecialchars($login)));
    $data = $query->fetch();
    return $data['id'];
  }
  
  public static function isAuthorizedUser($login, $pwd) {
    if (! in_array(htmlspecialchars($login), self::getLogins())) return false;
    $query = SQL::sql()->prepare('SELECT password FROM fsc_users_admin WHERE login = ?');
    $query->execute(array(htmlspecialchars($login)));
    $data = $query->fetch();
    $query->closeCursor();
    return User::hash_password($pwd, htmlspecialchars($login)) == $data['password'];
  }
  
  public static function getUsers() {
    $query = SQL::sql()->query('SELECT id, login, name, privilege FROM fsc_users_admin');
    $users = array();
    while ($data = $query->fetch()) {
      $users[] = array(
        'id' => $data['id'],
        'login' => $data['login'],
        'name' => $data['name'],
        'privilege' => $data['privilege']
      );
    }
    return $users;
  }
  
  protected function getLogins() {
    $query = SQL::sql()->query('SELECT login FROM fsc_users_admin');
    $logins = array();
    while ($data = $query->fetch())
      $logins[] = $data['login'];
    return $logins;
  }
  
  public static function historize($user, $ip) {
    $query = SQL::sql()->prepare('INSERT INTO fsc_history_admin(id_user_admin, ip) VALUES(:user, :ip)');
    $query->execute(array(
      'user' => $user,
      'ip' => $ip
    ));
    $query->closeCursor();
  }
  public static function getHistory() {
    $query = SQL::sql()->query('SELECT fsc_users_admin.login, fsc_users_admin.name, fsc_users_admin.privilege, date, ip FROM fsc_history_admin INNER JOIN fsc_users_admin ON fsc_users_admin.id = fsc_history_admin.id_user_admin ORDER BY fsc_history_admin.id DESC');
    $return = array();
    while ($data = $query->fetch())
      $return[] = array(
        'login' => $data['login'],
        'name' => $data['name'],
        'date' => $data['date'],
        'privilege' => $data['privilege'],
        'ip' => $data['ip']
      );
    $query->closeCursor();
    return $return;
  }
  
}

?>