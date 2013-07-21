<?php
  
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
    define('_JQUERY_', $fsc->jquery);

    define('_PATH_PUBLIC_', $fsc->path_public);
    define('_PATH_GESTION_', $fsc->path_gestion);
    define('_PATH_PREINSCRIPTION_', $fsc->path_preinscription);
    define('_PATH_UPLOADS_', $fsc->path_uploads);
    define('_PATH_UPLOADS_FULL_', $fsc->path_uploads_full);
    define('_PATH_API_', 'api');
    
    define('_STATIC_', $fsc->static);
    define('_UPLOADS_', $fsc->uploads);
    define('_PUBLIC_API_', $fsc->public_api);
    define('_PRIVATE_API_', $fsc->private_api);

  }
  else {
    echo 'Configuration files not found';
    exit();
  }

?>