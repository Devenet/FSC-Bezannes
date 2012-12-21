<?php

namespace lib\content;
use lib\content\Menu;

class Page {
  
  private $name;
  private $url;
  private $breadcrumb;
  private $search_engine;
  
  public function __construct($name, $url, $breadcrumb) {
    $this->name = $name;
    $this->url = ($url != null) ? $url : null;
    $this->search_engine = ($url != null) ? 'INDEX, FOLLOW, ARCHIVE' : 'NOINDEX, NOARCHIVE';
    $this->breadcrumb = new Menu();
    $this->breadcrumb->addLink('Accueil', '/', '');
    foreach ($breadcrumb as $link) $this->breadcrumb->addLink($link['name'], $link['url'], '');
  }
  
  public function name() {
    return $this->name;
  }
  
  public function url() {
    return $this->url;
  }
  
  public function breadcrumb() {
    return $this->breadcrumb->breadcrumb($this->url);
  }
  
  public function search_engine() {
    return $this->search_engine;
  }
  
  public function title() {
    if ($this->url != '/') {
      $return = '';
      $links = $this->breadcrumb->links();
      unset($links[0]);
      rsort($links);
      foreach ($links as $link) $return .= $link['name'] .' &ndash; ';
      return substr($return, 0, -8);
    }
    return 'Foyer Social et Culturel de Bezannes';
  }

  public function admin_title() {
    if ($this->url != '/') {
      $return = '';
      $links = $this->breadcrumb->links();
      unset($links[0]);
      rsort($links);
      foreach ($links as $link) $return .= $link['name'] .' &ndash; ';
      return substr($return, 0, -8);
    }
    return 'Administration';
  }
  
}

?>