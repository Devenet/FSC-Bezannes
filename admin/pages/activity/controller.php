<?php

use lib\content\Page;
use lib\activities\Activity;
use lib\content\Message;

function quit() {
  header('Location: /?page=activities');
  exit();
}

if (isset($_GET['id']) && Activity::isActivity($_GET['id']+0)) {
  
  $act = new Activity($_GET['id']+0);
  
  $pageInfos = array(
   'name' => $act->name(),
   'url' => '/?page=activities'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Activités', 'url' => '?page=activities'), $pageInfos));
  
  // suppression activité
  if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $name = $act->name();
    if ($act->delete(true)) {
      $_SESSION['msg'] = new Message('L’activité <em>'. $name .'</em> a bien été supprimée :/', 1, 'Suppression réussie !');
      quit();
    }
    else {
      $_SESSION['msg'] = new Message('Impossible de supprimer l’activité <em>'. $name .'</em>', -1, 'Suppression impossible :/');
      quit();
    }
  }
  
}
else {
  quit();
}

?>