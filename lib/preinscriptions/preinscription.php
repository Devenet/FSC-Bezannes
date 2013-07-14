<?php

namespace lib\preinscriptions;
use lib\db\SQL;
use lib\users\UserInscription;

class Preinscription {

  static public function Preinscriptions() {
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_users_inscription');
    while ($data = $query->fetch())
      $return[] = new UserInscription($data['id']); 
    $query->closeCursor();
    return $return;
  }

  static public function countAccounts() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_users_inscription');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

  static public function countPreinscriptions() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members_inscription');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

  static public function countAdherents() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_members_inscription WHERE adherent = 1');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

}

?>