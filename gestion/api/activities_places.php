<?php

namespace lib;
use lib\activities\Activity;

set_include_path('../../');
spl_autoload_extensions('.php');
spl_autoload_register();
error_reporting (0);

session_name('fsc_gestion');
session_start();

require '../../config/config.php';

if (!isset($_SESSION['authentificated']) || !$_SESSION['authentificated']) {
  header('Location: '. _GESTION_ .'/login.php');
  exit();
}
else {

  header('Content-type: application/json');

  $data = array();

  foreach (Activity::Activities('all') as $act) {

    if (! in_array(array('place' => $act->place()), $data))
      $data[] = array(
        'place' => $act->place()
      );
  }

  $data = json_encode($data);
  exit($data);

}

?>