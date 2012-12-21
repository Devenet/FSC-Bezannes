<?php

use lib\content\Page;
use lib\activities\Activity;

if (isset($_GET['id']) && Activity::isActivity($_GET['id']+0)) {
  
  $act = new Activity($_GET['id']+0);
  
  $pageInfos = array(
   'name' => $act->name(),
   'url' => '/?page=activites'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '/page=activites'), $pageInfos));

}
else {
  header ('Location: /?page=activites');
  exit();
}

?>