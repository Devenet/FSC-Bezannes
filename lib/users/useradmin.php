<?php

namespace lib\users;
use lib\users\User;
use lib\users\Privilege;
use lib\db\SQL;
use lib\content\Pagination;
use lib\laravel\Str;

class UserAdmin extends User {
  
  private $name;
  private $privilege;
  
  public function __construct($id = NULL) {
    if ($id != NULL) {
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
      $this->created = false;
  }
  
  public function name() {
    return $this->name;
  }
  public function setName($string) {
    if ($string != NULL) {
      $this->name = Str::title(htmlspecialchars($string));
      return true;
    }
    return false;
  }
  
  public function privilege() {
    return $this->privilege;
  }
  public function setPrivilege($int) {
    if ($int == Privilege::VISITOR || $int == Privilege::ADMINISTRATOR)
      $this->privilege = $int;
    else $this->privilege = Privilege::DISABLED;
    return true;
  }
  
  public function create() {
    if (! $this->created) {
      $query = SQL::sql()->prepare('INSERT INTO fsc_users_admin(login, password, name, privilege) VALUES(:login, :password, :name, :privilege)');
      $prepare = array(
        'login' => addslashes($this->login),
        'password' => $this->password,
        'name' => addslashes($this->name),
        'privilege' => $this->privilege
        );
      $rep = $query->execute($prepare);
      $this->id = SQL::sql()->lastInsertId();
      $query->closeCursor();
      $this->created = true;
      return true;
    }
    return false;
  }

  private function update_sql($field, $data) {
    $demande = 'UPDATE fsc_users_admin SET '. $field .' = \''. $data .'\' WHERE id = '. $this->id .'';
    $query = SQL::sql()->query($demande);
    $query->closeCursor();
  }
  
  public function update() {
    if ($this->created) {
      $this->update_sql('password', $this->password);
    }
  }

  public function delete($bool = false) {
    if ($bool && $this->created) {
      // fsc_users_admin
      $query = SQL::sql()->prepare('DELETE FROM fsc_users_admin WHERE id = :id');
      $query->execute(array('id' => $this->id));
      // fsc_history_admin
      $query = SQL::sql()->prepare('DELETE FROM fsc_history_admin WHERE id_user_admin = :id');
      $query->execute(array('id' => $this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }
  
  public function lastHistory() {
    $query = SQL::sql()->prepare('SELECT id, date, ip FROM fsc_history_admin WHERE id_user_admin = ? ORDER BY date DESC LIMIT 1,2');
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
  public static function isUser($login) {
    return in_array(htmlspecialchars($login), UserAdmin::getLogins());
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
  public static function getHistory($start = 0, $step = NULL) {
    $step = is_null($step) ? Pagination::step() : $step;
    $query = SQL::sql()->query('SELECT fsc_users_admin.login, fsc_users_admin.name, fsc_users_admin.privilege, date, ip FROM fsc_history_admin INNER JOIN fsc_users_admin ON fsc_users_admin.id = fsc_history_admin.id_user_admin ORDER BY fsc_history_admin.date DESC LIMIT '. $start .','. $step);
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

  public static function countHistory() {
    $query = SQL::sql()->query('SELECT COUNT(fsc_history_admin.id) AS total FROM fsc_history_admin');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

  public static function clean() {
    $total = self::countHistory();
    if ($total > 300) {
      $query = SQL::sql()->query('SELECT id from fsc_history_admin ORDER BY id DESC LIMIT 300,'. $total);
      $delete = SQL::sql()->prepare('DELETE FROM fsc_history_admin WHERE id = ?');
      while ($data = $query->fetch())
        $delete->execute(array($data['id']));
      $query->closeCursor();
    }
  }
  
}

?>