<style>
  h3 {font-weight: normal; font-size: 20px;}
</style>

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
      <a href="<?php echo _GESTION_; ?>/?page=preinscriptions" class="btn btn-inverse">Work in progress <i class="icon-spinner icon-spin"></i></a>
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