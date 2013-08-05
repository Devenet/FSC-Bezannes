<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

$dir = dirname(__FILE__) . '/';

  if (file_exists($dir.'version.json')) {
    $ver = json_decode(file_get_contents($dir.'version.json'));

    define('_VERSION_FSC_', $ver->fsc);
    define('_VERSION_GESTION_', $ver->gestion);
    define('_VERSION_PREINSCRIPTION_', $ver->preinscription);
    define('_VERSION_CSS_', $ver->css);
    define('_VERSION_JS_', $ver->js);
    
  }
  else {
    echo 'Version file not found';
    exit();
  }

?>