<?php

namespace lib\users;
use lib\users\User;
use lib\db\SQL;
use lib\preinscriptions\Preinscription;

class UserInscription extends User {
  
  private $ip;
  private $date;
   
  public function __construct($id = NULL) {
    if ($id != NULL) {
      $query = SQL::sql()->prepare('SELECT login, ip, date FROM fsc_users_inscription WHERE id = ?');
      $query->execute(array($id+0));
      $data = $query->fetch();
      $this->id = $id;
      $this->login = $data['login'];
      $this->ip = $data['ip'];
      $this->date = $data['date'];
      $query->closeCursor();
      $this->created = true;
    }
    else 
      $created = false;
  }
  
  public function create() {
    if (! $this->created) {
      $query = SQL::sql()->prepare('INSERT INTO fsc_users_inscription(login, password, ip) VALUES(:login, :password, :ip)');
      $prepare = array(
        'login' => addslashes($this->login),
        'password' => $this->password,
        'ip' => '0.0.0.0'
        );
      $rep = $query->execute($prepare);
      $query->closeCursor();
      $query = SQL::sql()->prepare('SELECT id FROM fsc_users_inscription WHERE login = ?');
      $query->execute(array($this->login));
      $data = $query->fetch();
      $this->id = $data['id'];
      $query->closeCursor();
      $this->created = true;
      return true;
    }
    return false;
  }

  public function date() {
    return $this->date;
  }

  private function update_sql($field, $data) {
    $demande = 'UPDATE fsc_users_inscription SET '. $field .' = \''. $data .'\' WHERE id = '. $this->id .'';
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
      // delete each presinscription and participation
      foreach(Preinscription::Members($this->id) as $m)
        $m->delete(true);
      // delete user account
      $query = SQL::sql()->prepare('DELETE FROM fsc_users_inscription WHERE id = :id');
      $query->execute(array('id' => $this->id));
      $query->closeCursor();
      return true;
    }
    return false;
  }

  public function historize($ip) {
    if ($this->created) {
      $query = SQL::sql()->prepare('UPDATE fsc_users_inscription SET ip = :ip, date = NOW() WHERE id = :id');
      $query->execute(array(
        'ip' => $ip,
        'id' => $this->id
      ));
      $query->closeCursor();
    }
  }

  public function lastConnection() {
    return array(
      'ip' => $this->ip,
      'date' => $this->date
    );
  }

  public function countPreinscriptions() {
    $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_members_inscription WHERE id_user_inscription = ?');
    $query->execute(array($this->id));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

  public function countAdherents() {
    $query = SQL::sql()->prepare('SELECT COUNT(id) AS total FROM fsc_members_inscription WHERE adherent = 1 AND id_user_inscription = ?');
    $query->execute(array($this->id));
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

  public static function getID($login) {
    $query = SQL::sql()->prepare('SELECT id FROM fsc_users_inscription WHERE login = ?');
    $query->execute(array(htmlspecialchars($login)));
    $data = $query->fetch();
    return $data['id'];
  }
  public static function getLogin($id) {
    $query = SQL::sql()->prepare('SELECT login FROM fsc_users_inscription WHERE id = ?');
    $query->execute(array($id+0));
    $data = $query->fetch();
    return $data['login'];
  }
  
  public static function isAuthorizedUser($login, $pwd) {
    /*
    $query = SQL::sql()->query('SELECT login, password FROM fsc_users_inscription');
    $logins = array();
    $passwords = array();
    while ($data = $query->fetch()) {
      $logins[] = $data['login'];
      $passwords[] = $data['password'];
    }
    $query->closeCursor();
    return in_array(htmlspecialchars($login), $logins) && in_array(User::hash_password($pwd, htmlspecialchars($login)), $passwords);
    */
    if (! in_array(htmlspecialchars($login), self::getLogins())) return false;
    $query = SQL::sql()->prepare('SELECT password FROM fsc_users_inscription WHERE login = ?');
    $query->execute(array(htmlspecialchars($login)));
    $data = $query->fetch();
    $query->closeCursor();
    return User::hash_password($pwd, htmlspecialchars($login)) == $data['password'];
  }
  public static function isUser($login) {
    return in_array(htmlspecialchars($login), UserInscription::getLogins());
  }
  
  protected function getLogins() {
    $query = SQL::sql()->query('SELECT login FROM fsc_users_inscription');
    $logins = array();
    while ($data = $query->fetch())
      $logins[] = $data['login'];
    return $logins;
  }
  
}

?>