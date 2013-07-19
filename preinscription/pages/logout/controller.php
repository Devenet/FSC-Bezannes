<?php

use lib\content\Message;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
 	$_SESSION['authentificated'] = false;
	unset($_SESSION['authentificated']);
	unset($_SESSION['user']);
  unset($_SESSION['to_ban']);
  if (! (isset($_GET['rel']) && $_GET['rel'] == 'deleted'))
	  $_SESSION['msg'] = new Message('Vous avez bien été déconnecté', 1, 'À bientôt !');
	header('Location: '. _PREINSCRIPTION_ .'/login');
	exit;
}

header('Location: '. _PREINSCRIPTION_);
exit;

?>