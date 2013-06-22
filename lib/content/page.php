<?php

namespace lib\content;
use lib\content\Menu;

class Page {
  
  protected $name;
  protected $url;
  protected $breadcrumb;
  private $search_engine;
  private $options;
  private $parameters;
  private $separator = '&middot;';
  private $admin_separator = '&ndash;';
  
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
  
  public function breadcrumb($home = 'Accueil') {
    $this->breadcrumb->changeNameLink(0, $home);
    return $this->breadcrumb->breadcrumb($this->url);
  }
  
  public function search_engine() {
    return _SEARCH_ENGINE_ ? $this->search_engine : 'NOINDEX, NOARCHIVE, NOFOLLOW';
  }
  
  public function title() {
    if ($this->url != _FSC_.'/') {
      $return = '';
      $links = $this->breadcrumb->links();
      unset($links[0]);
      krsort($links);
      foreach ($links as $link) $return .= $link['name'] .' '. $this->separator .' ';
      return substr($return, 0, -(2 + strlen($this->separator)));
    }
    return 'Foyer Social et Culturel de Bezannes';
  }

  public function admin_title() {
    $return = '';
    $links = $this->breadcrumb->links();
    unset($links[0]);
    krsort($links);
    foreach ($links as $link) $return .= $link['name'] .' '. $this->admin_separator .' ';
    return substr($return, 0, -(2 + strlen($this->admin_separator)));
  }


  
  public function addOption($option, $bool = true) {
    $this->options[$option] = $bool;
  }
  public function option($option) {
    return isset($this->options[$option]) && $this->options[$option]; 
  }
  
  public function addParameter($param, $data) {
    $this->parameters[$param] = $data;
  }
  public function parameter($param) {
    return isset($this->parameters[$param]) ? $this->parameters[$param] : null;
  }
  
  
}

?>