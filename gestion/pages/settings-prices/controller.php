<?php

use lib\content\Page;
use lib\content\Display;
use lib\content\Message;
use lib\payments\Price;

$pageInfos = array(
  'name' => 'Configuration',
  'url' => '/?page=configuration'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$prices = new Price();

if (!empty($_POST)) {
	try {
		// check if we have rights to write file
		$file = dirname(__FILE__).'/../../../config/prices.json';
		if (!is_writable($file))
			throw new Exception('Impossible de modifier le fichier de configuration des cotisations. Vérifiez que l’application a les droits d’écriture.');

		// check that all fields are completed
		if (empty($_POST['adult']) || empty($_POST['adult_ext']))
			throw new Exception('Les tarifs des cotisations des adultes ne peuvent être vides.');
		if (empty($_POST['young']) || empty($_POST['young_ext']))
			throw new Exception('Les tarifs des cotisations des jeunes ne peuvent être vides.');

		// transform integer values of post string values
		function filterData($data) { return floatval(str_replace(',', '.', htmlspecialchars($data))); }
		$_POST = array_map('filterData', $_POST);
		// check if values are numeric
		if (!is_numeric($_POST['adult']))
			throw new Exception('Le tarif pour un adulte bezannais n’est pas reconnu comme un nombre valide.');
		if (!is_numeric($_POST['adult_ext']))
			throw new Exception('Le tarif pour un adulte extérieur n’est pas reconnu comme un nombre valide.');
		if (!is_numeric($_POST['young']))
			throw new Exception('Le tarif pour un jeune bezannais n’est pas reconnu comme un nombre valide.');
		if (!is_numeric($_POST['young_ext']))
			throw new Exception('Le tarif pour un jeune extérieur n’est pas reconnu comme un nombre valide.');

		$json = array(
			'adult' => array(
				$_POST['adult_ext'],
				$_POST['adult'],
			),
			'teen' => array(
				$_POST['young_ext'],
				$_POST['young'],
			),
		);

		$result = file_put_contents($file, json_encode($json));
		if ($result !== FALSE) {
			$_SESSION['msg'] = new Message('Les modifications ont bien été effectuées <i class="icon-smile"></i>', 1, 'Prix des adhésions mis à jour !');
			header('Location: '. _GESTION_ .'/?page=settings-prices');
			exit();
		}
		throw new Exception('Impossible d’écrire les modifications dans le fichier.');

	} catch (\Exception $e) {
		$_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Une erreur est survenue !');
	}
			
}

?>