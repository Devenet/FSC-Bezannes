<?php

namespace lib\content;

class Menu {
  private $links;
  
  public function __construct() {
    
  }
  
  public function addLink($name, $url, $icon = '', $external = false, $right = false, $separator = false) {
    $this->links[] = array('name' => $name, 'url' => $url, 'icon' => $icon, 'external' => $external, 'right' => $right, 'separator' => $separator);
  }
  
  public function display($current = null, $white = false) {
    $return = '';
    $white = $white ? ' icon-white' : null;
    foreach($this->links as $link)
      $return .= ($link['separator'] != false ? '<li class="divider-vertical"></li>' : null) .'<li'. (($link['url'] == $current) ? ' class="active"' : null) .'><a href="'. $link['url'] .'"'. ($link['external'] ? ' rel="external"' : null) .'>'. ($link['icon'] != null && !$link['right'] ? '<i class="icon-'. $link['icon'] . $white .'"></i> ' : null) . $link['name'] . ($link['icon'] != null && $link['right'] ? ' <i class="icon-'. $link['icon'] . $white .'"></i>' : null) .'</a></li>';
    return $return;
  }
  public function displayWhite($current) {
    return $this->display($current, true);
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
  
  public function changeNameLink($position, $name) {
    $this->links[$position]['name'] = $name;
  }
  
}

?>