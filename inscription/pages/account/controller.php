<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\users\UserInscription;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  $pageInfos = array(
    'name' => 'Mon compte',
    'url' => '/account.html'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
  
  $page->addOption('steps');
  $page->addParameter('step', 3);
  $page->addParameter('step-width', 15);
  $page->addOption('bar');
  $page->addParameter('bar', 'danger');
  
  
}
else {
  header ('Location: /login.html');
  exit();
}


?>