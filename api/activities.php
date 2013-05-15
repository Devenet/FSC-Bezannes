<?php

namespace lib;
use lib\activities\Activity;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();
error_reporting (0);

require '../config/config.php';

header('Content-type: application/json');

$data = array();

foreach (Activity::ActiveActivities() as $act) {
  if (isset($_GET['max'])) {
    $data[] = array (
      "activity" => $act->name(),
      "url" => _FSC_ .'/activite/'. $act->url(),
      "place" => $act->place(),
      "description" => $act->description(),
      "img" => _ASSETS_ .'/activities/'. ($act->image() ? $act->id() : '0') .'.jpg'
    );
  }
  else {
    $data[] = array (
      "activity" => $act->name(),
      "url" => _FSC_ .'/activite/'. $act->url()
    );
  }
}

$data = json_encode($data);
exit($data);

?>