<?php

use lib\content\Message;

if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
 	$_SESSION['authentificated'] = false;
	unset($_SESSION['authentificated']);
	unset($_SESSION['user']);
	$_SESSION['msg'] = new Message('Vous avez bien été déconnecté', 1, 'À bientôt !');
	header('Location: '. _INSCRIPTION_ .'/signin');
	exit;
}

header('Location: '. _INSCRIPTION_);
exit;

?>