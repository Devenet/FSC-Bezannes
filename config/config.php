<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */
  
  $dir = dirname(__FILE__) . '/';

  if (file_exists($dir.'configuration.json')) {
	$fsc = json_decode(file_get_contents($dir.'configuration.json'));

	define('_SEARCH_ENGINE_', $fsc->search_engine);
	define('_YEAR_', $fsc->year);
	define('_PHONE_SEC_', $fsc->phone);
	define('_EMAIL_', $fsc->email);

	define('_FSC_', $fsc->fsc);
	define('_GESTION_', $fsc->gestion);
	define('_PREINSCRIPTION_', $fsc->preinscription);
	define('_ANALYTICS_FSC_', $fsc->analytics_fsc);
	define('_ANALYTICS_GESTION_', $fsc->analytics_gestion);
	define('_ANALYTICS_PREINSCRIPTION_', $fsc->analytics_preinscription);

	define('_PATH_PUBLIC_', 'public');
	define('_PATH_GESTION_', 'gestion');
	define('_PATH_PREINSCRIPTION_', 'preinscriptions');
	define('_PATH_UPLOADS_', 'uploads');
	define('_PATH_UPLOADS_FULL_', 'static/uploads');
	define('_PATH_API_', 'api');
	
	define('_STATIC_', $fsc->static);
	define('_UPLOADS_', $fsc->uploads);
	define('_PUBLIC_API_', _FSC_.'/'._PATH_API_);
	define('_PRIVATE_API_', _GESTION_.'/'._PATH_API_);
  }
  else {
	echo 'Configuration file not found';
	exit();
  }

?>