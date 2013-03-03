<?php

use lib\payments\Transaction;
use lib\payments\Advantage;
use lib\members\Member;
use lib\content\Message;

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['transaction']) && Transaction::isTransaction($_GET['transaction']+0)) {
  $t = new Transaction($_GET['transaction']+0);
  $m = new Member($t->adherent());
  $t->delete(true);
  $_SESSION['msg'] = new Message('La transaction a bien été supprimée', 1, 'Suppression réussie');
  header ('Location: /?page=member&id='.$m->id().'#payments');
  exit();
}
elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['advantage']) && Advantage::isAdvantage($_GET['advantage']+0)) {
  $t = new Advantage($_GET['advantage']+0);
  $m = new Member($t->adherent());
  $t->delete(true);
  $_SESSION['msg'] = new Message('L’avantage a bien été supprimé', 1, 'Suppression réussie');
  header ('Location: /?page=member&id='.$m->id().'#payments');
  exit();
}
else {
  header ('Location: /?page=members');
  exit();
}

?>