<?php

namespace lib\content;

class Menu {
  private $links;
  
  public function __construct() {
    
  }
  
  public function addLink($name, $url, $icon) {
    $this->links[] = array('name' => $name, 'url' => $url, 'icon' => $icon);
  }
  
  public function display($current, $right) {
    $return = '<ul class="nav'. ($right ? ' pull-right' : null) .'">';
    foreach($this->links as $link)
      $return .= '<li'. (($link['url'] == $current) ? ' class="active"' : null) .'><a href="'. $link['url'] .'">'. ($link['icon'] != null ? '<i class="icon-'. $link['icon'] .'"></i> ' : null) . $link['name'] .'</a></li>';
    $return .= '</ul>';
    return $return;
  }
  
  public function breadcrumb($current) {
    $return = '<ul class="breadcrumb">';
    foreach ($this->links as $link) {
      if ($link['url'] != $current)
        $return .= '<li><a href="'. $link['url'] .'">'. $link['name'] .'</a> <span class="divider">&rsaquo;</span></li>';
      else
        $return .= '<li class="active">'. $link['name'] .'</li>';
    }
    $return .= '</ul>';
    return $return;
  }
  
  public function links() {
    return $this->links;
  }
  
}

?>