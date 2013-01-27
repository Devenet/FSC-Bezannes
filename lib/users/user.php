<?php

namespace lib\users;

class User {
  
  protected $id;
  protected $login;
  protected $email;
  protected $created;
  
  public function id() {
    return $this->id;
  }
  
  public function login() {
    return $this->login();
  }
  
  public function email() {
    return $this->email();
  }

}

?>