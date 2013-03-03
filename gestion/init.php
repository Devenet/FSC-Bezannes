<?php

namespace lib;

use lib\db\SQL;
use lib\activities\Activity;
use lib\activities\Schedule;
use lib\members\Member;
use lib\members\Referent;

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
<title>Initialisation</title>
</head>
<body>
<?php

$act = new Activity();
$act->setName('Bibliothèque');
$act->setDescription('La bibliothèque, riche de près de 6000 ouvrages, albums, documentaires, romans, bandes dessinées, biographies propose régulièrement les nouveautés littéraires. Des titres pour tous les âges et toutes les envies de lecture.<br /><br />Des animations autour du livre sont régulièrement proposées le mercredi matin à destination des plus jeunes lecteurs.<br /><br />Intégrée au réseau national de « Culture et Bibliothèque Pour Tous », le choix des livres est réalisé grâce aux conseils avisés des comités de lecture (enfants – ados – adultes) auxquels participent activement les bibliothécaires.<br /><br />Les bibliothécaires sont tous des bénévoles. Vous voulez rejoindre l’équipe ? N’hésitez pas... <br />Prenez contact avec la bibliothèque !');
$act->setPlace('Salle Les Pléiades');
$act->setAggregate('on');
$act->setPrice(0);
$act->setEmail('bibliothequebezannes@free.fr');
$act->setWebsite('bibliothequebezannes.free.fr');
$act->create();
echo 'Création de l’activité Bibliothèque<br/>';

$query = SQL::sql()->query('SELECT id FROM fsc_activities WHERE url = \'bibliotheque\'');
$data = $query->fetch();
$id = $data['id'];
$query->closeCursor();
$act = new Activity($id);

$a = new Member();
$a->setGender(1);
$a->setLastName('Devenet');
$a->setFirstName('Christine');
$a->setDateBirthday(1960, 6, 17);
$a->setMinor();
$a->setAddressNumber(6);
$a->setAddressStreet('rue de la Prieuse');
$a->setAddressZipCode(51430);
$a->setAddressTown('Bezannes');
$a->setAddressDifferent();
$a->setBezannais();
$a->setPhone('0326862815');
$a->setMobile();
$a->setEmail('devenet@orange.fr');
$a->setAdherent(1);
$a->setDateRegistration(2012, 9, 10);      
$a->create();
echo 'Création de l’adhérent Christine Devenet<br/>';

$query = SQL::sql()->query('SELECT id FROM fsc_members WHERE last_name = \'devenet\' AND first_name = \'christine\'');
$data = $query->fetch();
$id = $data['id'];
$query->closeCursor();
$a = new Member($id);

$s1 = new Schedule();
$s1->setActivity($act->id());
$s1->setType();
$s1->setDay(2);
$s1->setTimeBegin(17, 00);
$s1->setTimeEnd(18, 30);
$s1->create();
$s2 = new Schedule();
$s2->setActivity($act->id());
$s2->setType();
$s2->setDay(3);
$s2->setTimeBegin(10, 30);
$s2->setTimeEnd(11, 30);
$s2->create();
$s3 = new Schedule();
$s3->setActivity($act->id());
$s3->setType();
$s3->setDay(3);
$s3->setTimeBegin(16, 00);
$s3->setTimeEnd(18, 30);
$s3->create();
echo 'Création des horaires pour l’activité Bibliothèque<br/>';

$r = new Referent();
$r->setActivity($act->id());
$r->setMember($id);
$r->setType('0');
$r->setDisplayPhone(1);
$r->create();
echo 'Ajout du réferent Christine Devenet pour l’activité Bibliothèque<br/>';

$act->changeActive();
echo 'Activation de l’activité Biblithèque';

?>
<br />
<strong>done</strong>
</body>
</html>

<?php
}
?>