<?php

namespace lib\content;

class Menu {
  private $links;
  
  public function __construct() {
    
  }
  
  public function addLink($name, $url, $icon = '', $external = false, $right = false, $separator = false) {
    $this->links[] = array('name' => $name, 'url' => $url, 'icon' => $icon, 'external' => $external, 'right' => $right, 'separator' => $separator);
  }
  
  public function display($current = NULL, $white = false) {
    $return = PHP_EOL;
    $white = $white ? ' icon-white' : NULL;
    foreach($this->links as $link)
      $return .= ($link['separator'] != false ? '<li class="divider-vertical"></li>' : NULL) .'<li'. (($link['url'] == $current) ? ' class="active"' : NULL) .'><a href="'. $link['url'] .'"'. ($link['external'] ? ' rel="external"' : NULL) .'>'. ($link['icon'] != NULL && !$link['right'] ? '<i class="icon-'. $link['icon'] . $white .'"></i> ' : NULL) . $link['name'] . ($link['icon'] != NULL && $link['right'] ? ' <i class="icon-'. $link['icon'] . $white .'"></i>' : NULL) .'</a></li>' . PHP_EOL;
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
  public function changeUrlLink($position, $url) {
    $this->links[$position]['url'] = $url;
  }

}

?>