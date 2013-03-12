<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-activities" data-toggle="tab" id="link-tab-activities"><i class="icon-globe"></i> Activités</a></li>
    <li><a href="#tab-members" data-toggle="tab" id="link-tab-members"><i class="icon-user"></i> Membres</a></li>
    <li class="pull-right"><a href="#tab-preinscriptions" data-toggle="tab" id="link-tab-preinscriptions"><i class="icon-list-alt"></i> Préinscriptions</a></li>
  </ul>
  
  <div class="tab-content">
    <!-- activites -->
    <div class="tab-pane active" id="tab-activities">
      <div class="btn-group">
        <a href="/?page=activities" class="btn"><i class="icon-eye-open"></i> Voir</a>
        <a href="/?page=new-activity" class="btn"><i class="icon-plus"></i> Ajouter</a>
      </div>
      <div style="margin-top:20px;">
        <p>Il y a actuellement <span class="label"><?php echo $activities; ?></span> activité<?php echo $plural_activities; ?>, dont <span class="label label-success"><?php echo $active_activities; ?></span> active<?php echo $plural_active_activities; ?>.</p>
      </div>
    </div>
    
    <!-- membres -->
    <div class="tab-pane" id="tab-members">
      <div class="btn-group">
        <a href="/?page=members" class="btn"><i class="icon-eye-open"></i> Voir</a>
        <a href="/?page=new-member" class="btn"><i class="icon-plus"></i> Ajouter</a>
      </div>
      <div style="margin-top:20px;">
        <p>Il y a actuellement <span class="label"><?php echo $members; ?></span> membre<?php echo $plural_members; ?>, dont <span class="label label-success"><?php echo $adherents; ?></span> adhérent<?php echo $plural_adherents; ?>.</p>
      </div>
    </div>
    
    <!-- preinscriptions -->
    <div class="tab-pane" id="tab-preinscriptions">
      <p class="center"><a href="<?php echo _INSCRIPTION_; ?>" class="btn btn-warning">Work in progress</a></p>
    </div>
    
  </div>
</div>

<?php
$scripts = '<script src="'. _FSC_ .'/js/active-tab.js"></script>';
?>