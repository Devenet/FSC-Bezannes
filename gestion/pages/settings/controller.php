<?php

use lib\content\Page;
use lib\content\Display;
use lib\content\Message;

$pageInfos = array(
	'name' => 'Configuration',
	'url' => '/?page=configuration'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

if (!empty($_POST)) {
	try {
		// check if we have rights to write file
		$file = dirname(__FILE__).'/../../../config/configuration.json';
		if (!is_writable($file))
			throw new Exception('Impossible de modifier le fichier de configuration. Vérifiez que l’application a les droits d’écriture.');

		if (empty($_POST['year']))
			throw new Exception('L’année de la saison ne peut être vide.');
		if (empty($_POST['preinscriptions']))
			throw new Exception('Le choix de l’activation des préinscriptions ne peut être vide.');
		if (empty($_POST['phone']) || empty($_POST['email']))
			throw new Exception('Les coordonnées ne peuvent être vides.');

		//check if values seem to be correct
		$year = intval(htmlspecialchars($_POST['year']));
		if (!is_numeric($year) || !($year > 2010))
			throw new Exception('L’année de l’adhésion ne semble pas être un entier ou elle est inférieure à 2010');

		$preinscription_enabled = FALSE;
		if ($_POST['preinscriptions'] == 'enabled') { $preinscription_enabled = TRUE; }

		$phone = htmlspecialchars($_POST['phone']);
		if (!preg_match('#^0[1-9]([0-9]{2}){4}$#', $phone))
			throw new Exception('Le numéro de téléphone donné n’est pas valide.');

		$email = htmlspecialchars($_POST['email']);
		if (!preg_match('#^[a-z0-9._\+-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', strtolower($email)))
			throw new Exception('Le courriel donné n’est pas valide.');

		$json = array(
			'year' => $year,
			'phone' => $phone,
			'email' => $email,
			'search_engine' => _SEARCH_ENGINE_,
			'fsc' => _FSC_,
			'gestion' => _GESTION_,
			'preinscription' => _PREINSCRIPTION_,
			'preinscription_enabled' => $preinscription_enabled,
			'analytics_fsc' => _ANALYTICS_FSC_,
			'analytics_gestion' => _ANALYTICS_GESTION_,
			'analytics_preinscription' => _ANALYTICS_PREINSCRIPTION_,
			'static' => _STATIC_,
			'uploads' => _UPLOADS_
		);

		$result = file_put_contents($file, json_encode($json));
		if ($result !== FALSE) {
			$_SESSION['msg'] = new Message('Les modifications ont bien été effectuées <i class="icon-smile"></i>', 1, 'Configuration mise à jour !');
			header('Location: '. _GESTION_ .'/?page=settings');
			exit();
		}
		throw new Exception('Impossible d’écrire les modifications dans le fichier.');

	} catch (\Exception $e) {
		$_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Une erreur est survenue !');
	}

}

?>