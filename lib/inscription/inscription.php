<?php

namespace lib\inscription;
use lib\db\SQL;


class Inscription {

  static public function countAccounts() {
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_users_inscription');
    $data = $query->fetch();
    $query->closeCursor();
    return $data['total'];
  }

  static public function countInscriptions() {
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