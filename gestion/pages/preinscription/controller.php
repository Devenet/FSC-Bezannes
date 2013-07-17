<?php

use lib\content\Page;
use lib\users\UserInscription;
use lib\preinscriptions\Preinscription;
use lib\content\Message;
use lib\content\Display;

function quit() {
  header('Location: '. _GESTION_ .'/?page=preinscriptions');
  exit();
}

if (isset($_GET['id']) && UserInscription::isUser(UserInscription::getLogin($_GET['id']+0))) {
  
  $u = new UserInscription($_GET['id']+0);
    
  $pageInfos = array(
   'name' => $u->login(),
   'url' => _GESTION_.'/?page=preinscriptions'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array(array('name' => 'Préinscriptions', 'url' => '?page=preinscriptions'), $pageInfos));

  
}
else {
  quit();
}

?>