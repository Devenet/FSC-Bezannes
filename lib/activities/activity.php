<?php

namespace lib\activities;
use lib\db\SQL;
 
class Activity {
  
  private $id;
  private $name;
  private $active;
  private $url;
  private $description;
  private $place;
  private $website;
  private $email;
  private $aggregate;
  private $price;
  private $price_young;
  private $created;
  
  public function __construct($id = 0) {
    if (is_int($id+0) && $this->isActivity($id+0)) {
      $query = SQL::sql()->query('SELECT name, active, url, description, place, email, website, price, price_young, aggregate FROM fsc_activities WHERE id = '. $id);
      $activite = $query->fetch();
      $this->id = $id;
      $this->name = $activite['name'];
      $this->active = $activite['active'];
      $this->url = $activite['url'];
      $this->description = $activite['description'];
      $this->place = $activite['place'];
      $this->email = $activite['email'];
      $this->website = $activite['website'];
      $this->aggregate = $activite['aggregate'];
      $this->price = $activite['price'];
      $this->price_young = $activite['price_young'];
      $this->created = true;
      $query->closeCursor();
    }
    else
      $created = false;
  }
  
  private function boolToInt($bool) {
    if ($bool) return 1;
    return 0;
  }
  
  public function id() {
    return $this->id;
  }
  
  public function setName($name) {
    if (!is_string($name) OR $name == null)
      return false;
    else {
      $this->name = $name;
      return true;
    }
  }
  public function name() {
    return $this->name;
  }

  public function setActive($bool) {
    $this->active = $this->boolToInt($bool);
  }
  public function active() {
    return $this->active;
  }
  
  public function setUrl($url) {
    $query = SQL::sql()->query('SELECT url FROM fsc_activities'); 
    $urls = array();
    while ($data = $query->fetch())
      $urls[] = $data['url'];
    $query->closeCursor();
    if ($url != NULL) {
      $url = mb_strtolower($url, 'UTF-8');
      $url = preg_replace('#à|â|ä#', 'a', $url);
      $url = preg_replace('#é|ê|è|ë#', 'e', $url);
      $url = preg_replace('#î|ï#', 'i', $url);
      $url = preg_replace('#ô|ö#', 'o', $url);
      $url = preg_replace('#ù|û|ü#', 'u', $url);
      $url = preg_replace('#ç#', 'c', $url);
      $url = preg_replace('#([^a-z])+#', '-', $url);
      $url = preg_replace('#\-$#', '', $url);
      if (!in_array($url, $urls)) {
        $this->url = $url;
        return true;
      }
      else {
        $url = $url . '-' . rand(1,10);
        if (!in_array($url, $urls)) {
          $this->url = $url;
          return true;
        }
        else
        $this->setUrl($url);
      }
    }
    return $this->setUrl($this->name);
  }
  public function url() {
    return $this->url;
  }
  
  public function setDescription($description) {
    if ($description != null) {
      $this->description = htmlspecialchars($description);
      return true;
    }
    return false;
  }
  public function description() {
    return $this->description;
  }
  
  public function setPlace($place) {
    if($place != null) {
      $this->place = $place;
      return true;
    }
    return false;
  }
  public function place() {
    return $this->place();
  }
  
  public function setEmail($email) {
    if ($email != null) {
      if (!preg_match('#^[a-z0-9._\+-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', strtolower($email)))
        return false;
      else {
        $this->email = strtolower($email);
        return true;
      }
    }
    else {
      $this->email = '';
      return true;
    }
  }
  public function email() {
    return $this->email;
  }
  
  public function setWebwebsite($website) {
    if ($website != null) {
      // oui je ne prends pas en compte les nouveaux NDD avec accents, mais hein bon quoi keur.
      if (!preg_match('#^(http://)?[a-z0-9._-]{2,}\.[a-z]{2,4}$#', strtolower($website)))
        return false;
      else {
        $this->website = preg_replace('#^http://(.+)#', '$1', strtolower($website));
        return true;
      }
    }
    else {
      $this->website = '';
      return true;
    }
  }
  public function website() {
    return $this->website;
  }
  
  public function setAggregate($bool) {
    $this->aggregate = $this->boolToInt($bool);
  }
  public function aggregate() {
    return $this->aggregate;
  }
  
  public function setPrice($float) {
    $float = preg_replace('#,#', '.', $float) + 0;
    if((is_float($float) or is_int($float)) and $float >= 0) {
      $this->price = $float;
      return true;
    }
    return false;
  }
  public function price() {
    return preg_replace('#\.#', ',', $this->price);
  }
  
  public function setPriceYoung($float) {
    $float = preg_replace('#,#', '.', $float) + 0;
    if((is_float($float) or is_int($float)) and $float >= 0) {
      $this->price_young = $float;
      return true;
    }
    return false;
  }
  public function price_young() {
    return preg_replace('#\.#', ',', $this->price_young);
  }
  
  private function update_sql($field, $data) {
    $demande = 'UPDATE fsc_activities SET '. $field .' = \''. $data .'\' WHERE id = '. $this->id .'';
    $query = SQL::sql()->query($demande);
    $query->closeCursor();
  }
  
  public function update() {
    $this->update_sql('name', $this->name);
    $this->update_sql('active', $this->active);
    $this->update_sql('url', $this->url);
    $this->update_sql('description', $this->description);
    $this->update_sql('place', $this->place);
    $this->update_sql('email', $this->email);
    $this->update_sql('webwebsite', $this->webwebsite);
    $this->update_sql('aggregate', $this->aggregate);
    $this->update_sql('price', $this->price);
    $this->update_sql('price_young', $this->price_young);
  }
  
  public function create() {
    if (!$this->created) {
      if ($this->url == null) $this->setUrl($this->name);
      $query = SQL::sql()->prepare('INSERT INTO fsc_activities(name, active, url, description, place, email, website, price, price_young) VALUES(:name, :active, :url, :description, :place, :email, :website, :price, :price_young)');
      $prepare = array(
        'name' => $this->name,
        'active' => ($this->active == null) ? 0 : $this->active,
        'url' => $this->url,
        'description' => $this->description,
        'place' => $this->place,
        'email' => ($this->email == null) ? '' : $this->email,
        'website' => ($this->website == null) ? '' : $this->website,
        'price' => ($this->price == null) ? 0 : $this->price,
        'price_young' => ($this->price_young == null) ? -1 : $this->price_young
        );
      $rep = $query->execute($prepare);
      $query->closeCursor();
      $query = SQL::sql()->prepare('SELECT id FROM fsc_activities WHERE url = ?');
      $query->execute(array($this->url));
      $data = $query->fetch();
      $this->id = $data['id'];
      $query->closeCursor();
      $this->created = true;
    }
  }
  
  static public function isActivity($id) {
    $query = SQL::sql()->query('SELECT id FROM fsc_activities');
    $ids = array();
    while ($data = $query->fetch())
      $ids[] = $data['id'];
    return in_array($id, $ids);
  }
  
  static public function Activities() {
    $return = array();
    $query = SQL::sql()->query('SELECT id FROM fsc_activities');
    while ($data = $query->fetch())
      $return[] = new Activity($data['id']); 
    $query->closeCursor();
    return $return;
  }
  
}