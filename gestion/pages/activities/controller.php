<?php

use lib\activities\Activity;
use lib\content\Page;
use lib\content\Pagination;
use lib\content\Sort;

$pageInfos = array(
  'name' => 'Activités',
  'url' => _GESTION_.'/?page=activities'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

// set actual page
$pages = ceil(Activity::countActivities() / Pagination::step());
$browse = 1;
if (isset($_GET['browse']) && $_GET['browse'] != null)
  $browse = min($pages, max(1, $_GET['browse']+0));

$type = null;
$sens = true;
$url = null;
if (isset($_GET['sort'])) {
  $data = explode('-', htmlspecialchars($_GET['sort']));
  $type = $data[0];
  $sens = isset($data[1]) && $data[1] == 'desc' ? false : true;
}

$sort = array(
  'name' => new Sort(),
  'active' => new Sort(),
  'price' => new Sort()
);

switch($type) {
  case 'name':
    $activities = Activity::ActivitiesByName(($browse-1) * Pagination::step(), $sens);
    $url = '&amp;sort=name-' . ($sens ? 'asc' : 'desc');
    break;
  case 'active':
    $activities = Activity::ActivitiesByActive(($browse-1) * Pagination::step(), $sens);
    $url = '&amp;sort=active-' . ($sens ? 'asc' : 'desc');
    break;
  case 'price':
    $activities = Activity::ActivitiesByPrice(($browse-1) * Pagination::step(), $sens);
    $url = '&amp;sort=price-' . ($sens ? 'asc' : 'desc');
    break;
  default:
    $activities = Activity::Activities(($browse-1) * Pagination::step());
}
if ($type != null) $sort[$type]->sens($sens ? 'asc' : 'desc');

// pagination
$display_pagination = '<li '. ($browse == 1 ? ' class="disabled"><span>' : '><a href="/?page=activities'. $url .'">') .'<i class="icon-double-angle-left"></i>'. ($browse == 1 ? '</span>' : '</a>') .'</li>' ;
for ($i = 1; $i <= $pages; $i++) {
  $display_pagination .= '
  <li '. ($i != $browse ?: ' class="active"') .'><a href="/?page=activities'. $url . ($i != 1 ? '&amp;browse='. $i : '') .'">'. $i .'</a></li>
  ';
}
$display_pagination .= '<li '. ($browse == $pages ? ' class="disabled"><span>' : '><a href="/?page=activities'. $url .'&browse='. $pages .'">') .'<i class="icon-double-angle-right"></i>'. ($browse == $pages ? '</span>' : '</a>') .'</li>' ;


$_SCRIPT[] = '<script src="'. _FSC_ .'/js/hogan.js"></script>';
$_SCRIPT[] = '<script src="'. _FSC_ .'/js/typeahead.min.js"></script>';
$_SCRIPT[] = "
<script>
  $(document).ready(function() {
    //$('input.search-activities').typeahead('destroy');
    $('input.search-activities').typeahead({
      name: 'activities',
      valueKey: 'activity',
      prefetch: {
        'url': 'http:". _PRIVATE_API_ ."/activities.php',
        'ttl': 5000
        },
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