<?php

namespace lib;

use lib\db\SQL;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

include '../config/config.php';


if (!isset($_SESSION['authentificated']) || !$_SESSION['authentificated']) {
	header('Location: /login.php?path='.htmlspecialchars($_SERVER['REQUEST_URI']));
	exit();
}
else {

?><!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Database</title>
</head>
<body>
<?php
  $bases = array('activities', 'history_admin', 'inscription_members', 'inscription_participants', 'members', 'participants', 'payments_advantages', 'payments_transactions', 'schedules', 'users_admin', 'users_inscription', 'users_recover_passwords');
  foreach ($bases as $db) {
    echo '<p style="width:250px; display:inline-block; text-align:right; margin-right:15px;">fsc_<strong>', $db ,'</strong></p><p style="display:inline-block;">';
    $query = SQL::sql()->query('SELECT COUNT(id) AS total FROM fsc_'.$db);
    $data = $query->fetch();
    echo $data['total'], '</p><div class="clear:both;"></div>';
  }
?>
</body>
</html>

<?php
}
?>