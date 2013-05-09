<?php

namespace lib\content;
use lib\content\Page;
use lib\content\Menu;

class PageChild extends Page {

  private $child_name;
  private $child_url;
  private $display_parent_name;
  
  public function __construct($parent, $name, $url, $display_parent_name = false) {
    $this->name = $parent->name();
    $this->url = $parent->url();
    $this->child_name = $name;
    $this->child_url = $url;
    $this->display_parent_name = $display_parent_name;
    $this->breadcrumb = new Menu();
    $this->breadcrumb->addLink('Accueil', '/');
    $this->breadcrumb->addLink($this->name, $this->url);
    $this->breadcrumb->addLink($this->child_name, $this->child_url);
  }
  
  
  public function name() {
    return ($this->display_parent_name ? $this->name . ' &rsaquo; ' . $this->child_name : $this->child_name);
  }
  
  public function url() {
    return $this->child_url;
  }
  
  public function breadcrumb($home = 'Accueil') {
    $this->breadcrumb->changeNameLink(0, $home);
    return $this->breadcrumb->breadcrumb($this->child_url);
  }
  
}

?>