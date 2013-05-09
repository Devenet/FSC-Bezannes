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
  
  $u = $_SESSION['user'];

//  $view = isset($_GET['rel']) ? htmlspecialchars($_GET['rel']) : home;

  
}
else {
  header ('Location: /login.html');
  exit();
}


?>