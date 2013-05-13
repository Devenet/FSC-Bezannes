<?php

use lib\activities\Activity;
use lib\content\Page;

$pageInfos = array(
  'name' => 'Activités',
  'url' => _FSC_.'/activites'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));


$activities = Activity::ActiveActivities();

$_SCRIPT[] = '<script src="'. _FSC_ .'/js/hogan.js"></script>' . "\n";
$_SCRIPT[] = "\t" . '<script src="'. _FSC_ .'/js/typeahead.min.js"></script>';
$_SCRIPT[] = "
    <script>
      $(document).ready(function() {
        $('.search-activities').typeahead({
          name: 'activities',
          prefetch: '/api/activities.php',
          template: '<p><a href=\"{{link}}\">{{value}}</a></p>',
          engine: Hogan
        });
      });
    </script>
";

?>