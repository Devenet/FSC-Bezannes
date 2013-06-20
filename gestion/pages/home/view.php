<div class="row">

  <!-- activites -->
  <div class="span4">
    <h3><i class="icon-globe"></i> Activités</h3>
    <div class="btn-group">
      <a href="/?page=activities" class="btn"><i class="icon-eye-open"></i> Voir</a>
      <a href="/?page=new-activity" class="btn"><i class="icon-plus"></i> Ajouter</a>
    </div>
    <div style="margin-top:20px;">
      <p>Il y a actuellement <span class="label"><?php echo $activities; ?></span> activité<?php echo $plural_activities; ?>, dont <span class="label label-success"><?php echo $active_activities; ?></span> active<?php echo $plural_active_activities; ?>.</p>
    </div>
  </div>
  
  <!-- membres -->
  <div class="span4">
    <h3><i class="icon-male"></i> Membres</h3>
    <div class="btn-group">
      <a href="/?page=members" class="btn"><i class="icon-eye-open"></i> Voir</a>
      <a href="/?page=new-member" class="btn"><i class="icon-plus"></i> Ajouter</a>
    </div>
    <div style="margin-top:20px;">
      <p>Il y a actuellement <span class="label"><?php echo $members; ?></span> membre<?php echo $plural_members; ?>, dont <span class="label label-success"><?php echo $adherents; ?></span> adhérent<?php echo $plural_adherents; ?>.</p>
    </div>
  </div>
  
  <!-- preinscriptions -->
  <div class="span4">
    <h3><i class="icon-hand-right"></i> Préinscriptions</h3>
    <p class="center"><a href="<?php echo _INSCRIPTION_; ?>" class="btn btn-warning">Work in progress</a></p>
  </div>
    
</div>

<style>
  h3 {font-weight: normal; font-size: 20px;}
</style>