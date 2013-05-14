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
        $('input.search-activities').typeahead('destroy');
        $('input.search-activities').typeahead({
          name: 'activities',
          valueKey: 'activity',
          prefetch: '/api/activities.json',
          template: '<a href=\"{{url}}\">{{activity}} <i class=\"icon-share-alt\" style=\"font-size:14px; margin-left:5px;\"></i></a>',
          engine: Hogan
        });

        $('input.search-activities').on(['typeahead:autocompleted', 'typeahead:selected'].join(' '), function (e) {
          var v = [].slice.call(arguments, 1);
          document.location.href = v[0].url;
        });
      });
    </script>
";

?>