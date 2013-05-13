<?php
  
  header('Content-type: application/json');

  $data = array (
    array (
      "value" => "Anglais Jeunes Enfants",
      "link" => "./activite/anglais-jeunes-enfants",
      "tokens" => array(
        "anglais jeunes enfants"
      )
    ),
    array (
      "value" => "Bibliothèque",
      "link" => "./activite/bibliotheque",
      "tokens" => array(
        "bibliotheque"
      )
    ),
    array (
      "value" => "Billard",
      "link" => "./activite/billard",
      "tokens" => array(
        "billard"
      )
    ),
     array (
      "value" => "Informatique",
      "link" => "./activite/informatique",
      "tokens" => array(
        "informatique"
      )
    ),
  );

$data = json_encode($data);
exit($data);

?>