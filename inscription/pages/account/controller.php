<?php

use lib\content\Page;
use lib\content\Form;
use lib\content\Message;
use lib\users\UserInscription;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {

  $pageInfos = array(
    'name' => 'Mon compte',
    'url' => '/account'
  );
  $page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));
  
  $u = $_SESSION['user'];
  
}
else {
  header ('Location: /signin');
  exit();
}


?>