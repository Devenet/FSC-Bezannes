<?php

namespace lib\content;
use lib\content\Menu;

class Page {
  
  protected $name;
  protected $url;
  protected $breadcrumb;
  private $search_engine;
  private $options;
  
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
  public function parent_url() {
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
      krsort($links);
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
      krsort($links);
      foreach ($links as $link) $return .= $link['name'] .' &ndash; ';
      return substr($return, 0, -8);
    }
  }
  
  public function addOption($option, $bool = true) {
    $this->options[$option] = $bool;
  }
  
  public function option($option) {
    return isset($this->options[$option]) && $this->options[$option]; 
  }
  
}

?>