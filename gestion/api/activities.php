<?php

namespace lib;
use lib\activities\Activity;

set_include_path('../../');
spl_autoload_extensions('.php');
spl_autoload_register();
error_reporting (0);

session_name('gestion');
session_start();

require '../../config/config.php';

if (!isset($_SESSION['authentificated']) || !$_SESSION['authentificated']) {
  header('Location: /login.php');
  exit();
}
else {

  header('Content-type: application/json');

  $data = array();

  foreach (Activity::Activities(0, 200) as $act) {
    $data[] = array (
      "activity" => $act->name(),
      "url" => _GESTION_ .'/?page=activity&id='. $act->id()
    );
  }

  $data = json_encode($data);
  exit($data);

}

?>