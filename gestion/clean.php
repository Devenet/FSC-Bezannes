<?php

namespace lib;

use lib\db\SQL;
use lib\activities\Activity;

set_include_path('../');
spl_autoload_extensions('.php');
spl_autoload_register();

session_name('fsc_gestion');
session_start();

include '../config/config.php';

if (!isset($_SESSION['authentificated']) || !$_SESSION['authentificated']) {
	header('Location: '. _GESTION_ .'/login.php?path='.htmlspecialchars($_SERVER['REQUEST_URI']));
	exit();
}
else {



?><!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Initialisation</title>
</head>
<body>
<?php

foreach(Activity::Activities() as $act) {
	echo '<strong>', $act->name(), '</strong><br />';
	$description = $act->description();
	$description = preg_replace('#</p><p>#', '<br /><br />', $description);
	$description = preg_replace('#</p>#', '', $description);
	$description = preg_replace('#<p>#', '', $description);
	$act->setDescription($description);
	echo htmlspecialchars($act->description());
	$act->update();
	echo '<br /><br />';
}

?>
<br /><br />
<strong>done</strong>
</body>
</html>

<?php
}
?>