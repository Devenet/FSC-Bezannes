<?php

  define('_PATH_PUBLIC_', 'public');
  define('_PATH_GESTION_', 'gestion');
  define('_PATH_ADMIN_', 'admin');
  define('_PATH_INSCRIPTION_', 'preinscription');
  define('_PATH_UPLOADS_', 'uploads');
  define('_PATH_API_', 'api');
  define('_SEARCH_ENGINE_', false);
  define('_YEAR_', 2012);
  define('_PHONE_SEC_', '0326362384');
  define('_EMAIL_', 'contact@bezannes-fsc.fr');

  if (false)
  {
    define('_FSC_', '//beta.fsc-bezannes.fr');
    define('_GESTION_', '//gestion.fsc-bezannes.fr');
    define('_ADMIN_', '//admin.fsc-bezannes.fr');
    define('_INSCRIPTION_', '//preinscription.fsc-bezannes.fr');
    define('_ANALYTICS_FSC_', true);
    define('_ANALYTICS_GESTION_', true);
    define('_ANALYTICS_INSCRIPTION_', true);
    define('_JQUERY_', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
  }
  else
  {
    define('_FSC_', '//fsc.localhost.local');
    define('_GESTION_', '//gestion.fsc.localhost.local');
    define('_ADMIN_', '//admin.fsc.localhost.local');
    define('_INSCRIPTION_', '//inscription.fsc.localhost.local');
    define('_ANALYTICS_FSC_', false);
    define('_ANALYTICS_GESTION_', false);
    define('_ANALYTICS_INSCRIPTION_', false);
    define('_JQUERY_', '//api.localhost.local/jquery/jquery-1.9.1.min.js');
  }
  
  define('_ASSETS_', _FSC_.'/'._PATH_UPLOADS_);
  define('_PUBLIC_API_', _FSC_.'/'._PATH_API_);
  define('_PRIVATE_API_', _GESTION_.'/'._PATH_API_);

?>