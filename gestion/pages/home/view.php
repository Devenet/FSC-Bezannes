<style>
  h3 {font-weight:normal; font-size:20px;}
  h5 {margin:5px 10px; border-bottom:1px solid #aaa; color:#aaa;}
</style>

<div class="row espace-bottom">
  <div class="span6">
    <form class="form-search">
      <input type="text" class="global-search span4" placeholder="Accès rapide" autofocus/>
    </form>
  </div>
  <div class="span6">
    <ul class="inline nav nav-pills pull-right">
      <li><a href="<?php echo _FSC_; ?>" rel="external"><span class="fsc-blue">F</span><span class="fsc-green">S</span><span class="fsc-orange">C</span> <span class="normal external-link"><i class="icon-external-link"></i></span></a></li>
      <li><a href="<?php echo _PREINSCRIPTION_; ?>" rel="external">Présincriptions <span class="normal external-link"><i class="icon-external-link"></i></span></a></li>
    </ul>
  </div>
</div>

<div class="row">

  <!-- activites -->
  <div class="span4">
    <h3><i class="icon-globe"></i> Activités</h3>
    <div class="btn-group">
      <a href="./?page=activities" class="btn"><i class="icon-eye-open"></i> Voir</a>
      <a href="./?page=new-activity" class="btn"><i class="icon-plus"></i> Ajouter</a>
    </div>
    <div style="margin-top:20px;">
      <ul class="unstyled">
        <li><span class="label"><?php echo $activities; ?></span> activité<?php echo $plural_activities; ?></li>
        <li><span class="label label-success"><?php echo $active_activities; ?></span> activité<?php echo $plural_activities; ?> active<?php echo $plural_active_activities; ?></li>
      </ul>
    </div>
  </div>
  
  <!-- membres -->
  <div class="span4">
    <h3><i class="icon-male"></i> Membres</h3>
    <div class="btn-group">
      <a href="./?page=members" class="btn"><i class="icon-eye-open"></i> Voir</a>
      <a href="./?page=new-member" class="btn"><i class="icon-plus"></i> Ajouter</a>
    </div>
    <div style="margin-top:20px;">
      <ul class="unstyled">
        <li><span class="label"><?php echo $members; ?></span> membre<?php echo $plural_members; ?></li>
        <li><span class="label label-success"><?php echo $adherents; ?></span> membre<?php echo $plural_members; ?> adhérent<?php echo $plural_adherents; ?></li>
      </ul>
    </div>
  </div>
  
  <!-- preinscriptions -->
  <div class="span4">
    <h3><i class="icon-hand-right"></i> Préinscriptions</h3>
    <div class="btn-group">
      <a href="<?php echo _GESTION_; ?>/?page=preinscriptions" class="btn"><i class="icon-eye-open"></i> Voir</a>
    </div>
    <div style="margin-top:20px;">
      <p><span class="label"><?php echo $inscription_accounts; ?></span> compte<?php echo $plural_PREINSCRIPTION_accounts; ?></p>
      <ul class="unstyled">
        <li><span class="label label-warning"><?php echo $inscriptions; ?></span> préinscription<?php echo $plural_inscriptions; ?></li>
        <li><span class="label label-success"><?php echo $inscription_adherents; ?></span> pré-adhérent<?php echo $plural_PREINSCRIPTION_adherents; ?></li>
      </ul>
    </div>
  </div>
</div>

<!--
<div class="row espace-top">
  <hr />

  <div class="span6">
    <h3>&Eacute;volutions possibles si le temps le permet...</h3>
    <p style="font-style:italic;">Il aurait fallu me prévenir plus tôt pour que ce soit pris en compte dès le développement,
     car ces modifications nécessitent une réorganisation structurelle, notamment de la base de données.</p>
    <ul>
      <li>Ajout d'une colonne &laquo; complément &raquo; pour les référents d'une activité</li>
    </ul>
  </span>

</div>
-->

<?php
$_SCRIPT[] = '<script src="'. _FSC_ .'/js/hogan.js"></script>';
$_SCRIPT[] = '<script src="'. _FSC_ .'/js/typeahead.min.js"></script>';
$_SCRIPT[] = "
<script>
  $(function(){
    $('input.global-search').typeahead([
      {
        name: 'activities',
        valueKey: 'activity',
        prefetch: {
          'url': 'http:". _PRIVATE_API_ ."/activities.php',
          'ttl': 5000
        },
        template: '<a href=\"{{url}}\">{{activity}} <i class=\"icon-share-alt\" style=\"font-size:14px; margin-left:5px;\"></i></a>',
        engine: Hogan,
        header: '<h5>Activités</h5>'
      },
      {
        name: 'members',
        valueKey: 'name',
        prefetch: {
          'url': 'http:". _PRIVATE_API_ ."/members.php',
          'ttl': 5000
          },
        template: '<a href=\"{{url}}\">{{name}} <i class=\"icon-share-alt\" style=\"font-size:14px; margin-left:5px;\"></i></a>',
        engine: Hogan,
        header: '<h5>Membres</h5>'
      },
      {
        name: 'accounts',
        valueKey: 'login',
        prefetch: {
          'url': 'http:". _PRIVATE_API_ ."/accounts.php',
          'ttl': 5000
          },
        template: '<a href=\"{{url}}\">{{login}} <i class=\"icon-share-alt\" style=\"font-size:14px; margin-left:5px;\"></i></a>',
        engine: Hogan,
        header: '<h5>Préinscriptions</h5>'
      }
    ]);
    $('input.global-search').on(['typeahead:autocompleted', 'typeahead:selected'].join(' '), function (e) {
          var v = [].slice.call(arguments, 1);
          document.location.href = v[0].url;
        });
  });
</script>";
?>