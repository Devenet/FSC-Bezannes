<?php

  define('_PATH_GESTION_', 'gestion');
  //define('_PATH_ADMIN_', 'admin');
  define('_PATH_INSCRIPTION_', 'inscription');
  define('_PATH_UPLOADS_', 'uploads');
  define('_SEARCH_ENGINE_', false);
  define('_YEAR_', 2012);
  define('_PHONE_SEC_', '0326362384');

  if (false)
  {
    define('_FSC_', 'http://beta.bezannes-fsc.fr');
    define('_GESTION_', 'http://gestion.bezannes-fsc.fr');
    define('_ADMIN_', 'http://admin.bezannes-fsc.fr');
    define('_DATA_', 'http://data.bezannes-fsc.fr');
    define('_INSCRIPTION_', 'http://inscription.bezannes-fsc.fr');
    define('_ANALYTICS_FSC_', true);
    define('_ANALYTICS_GESTION_', true);
    define('_ANALYTICS_INSCRIPTION_', true);
    define('_JQUERY_', 'http://code.jquery.com/jquery-latest.js');
  }
  else
  {
    define('_FSC_', 'http://fsc.localhost.local');
    define('_GESTION_', 'http://gestion.fsc.localhost.local');
    define('_ADMIN_', 'http://admin.fsc.localhost.local');
    define('_DATA_', _FSC_.'/'._PATH_UPLOADS_);
    define('_INSCRIPTION_', 'http://inscription.fsc.localhost.local');
    define('_ANALYTICS_FSC_', false);
    define('_ANALYTICS_GESTION_', false);
    define('_ANALYTICS_INSCRIPTION_', false);
    define('_JQUERY_', 'http://api.localhost.local/jquery/jquery-1.8.0.min.js');
  }
  
?>