<?php

use lib\preinscriptions\Member;
use lib\content\Page;
use lib\content\Pagination;

$pageInfos = array(
  'name' => 'Membres',
  'url' => _GESTION_.'/?page=members'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

// set actual page
$pages = ceil(Member::countMembers() / Pagination::step());
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

switch($type) {
  case 'id':
    $members = Member::MembersById(($browse-1) * Pagination::step(), $sens);
    $url = '&amp;sort=id-' . ($sens ? 'asc' : 'desc');
    break;
  case 'name':
    $members = Member::MembersByName(($browse-1) * Pagination::step(), $sens);
    $url = '&amp;sort=name-' . ($sens ? 'asc' : 'desc');
    break;
  case 'adherent':
    $members = Member::MembersByAdherent(($browse-1) * Pagination::step(), $sens);
    $url = '&amp;sort=adherent-' . ($sens ? 'asc' : 'desc');
    break;
  case 'bezannais':
    $members = Member::MembersByBezannais(($browse-1) * Pagination::step(), $sens);
    $url = '&amp;sort=bezannais-' . ($sens ? 'asc' : 'desc');
    break;
  case 'adult':
    $members = Member::MembersByAdult(($browse-1) * Pagination::step(), $sens);
    $url = '&amp;sort=adult-' . ($sens ? 'asc' : 'desc');
    break;
  default:
    $members = Member::Members(($browse-1) * Pagination::step());
}

// pagination
$display_pagination = '<li '. ($browse == 1 ? ' class="disabled"><span>' : '><a href="./?page=members'. $url .'">') .'<i class="icon-double-angle-left"></i>'. ($browse == 1 ? '</span>' : '</a>') .'</li>' ;
for ($i = 1; $i <= $pages; $i++) {
  $display_pagination .= '
  <li '. ($i != $browse ?: ' class="active"') .'><a href="./?page=members'. $url . ($i != 1 ? '&amp;browse='. $i : '') .'">'. $i .'</a></li>
  ';
}
$display_pagination .= '<li '. ($browse == $pages ? ' class="disabled"><span>' : '><a href="./?page=members'. $url .'&browse='. $pages .'">') .'<i class="icon-double-angle-right"></i>'. ($browse == $pages ? '</span>' : '</a>') .'</li>' ;


$_SCRIPT[] = '<script src="'. _FSC_ .'/js/hogan.js"></script>' . "\n";
$_SCRIPT[] = "\t" . '<script src="'. _FSC_ .'/js/typeahead.min.js"></script>';
$_SCRIPT[] = "
    <script>
      $(document).ready(function() {
        //$('input.search-members').typeahead('destroy');
        $('input.search-members').typeahead({
          name: 'members',
          valueKey: 'name',
          prefetch: {
            'url': 'http:". _PRIVATE_API_ ."/members.php',
            'ttl': 5000
            },
          template: '<a href=\"{{url}}\">{{name}} <i class=\"icon-share-alt\" style=\"font-size:14px; margin-left:5px;\"></i></a>',
          engine: Hogan
        });

        $('input.search-members').on(['typeahead:autocompleted', 'typeahead:selected'].join(' '), function (e) {
          var v = [].slice.call(arguments, 1);
          document.location.href = v[0].url;
        });
      });
    </script>
";

?>