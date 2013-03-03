<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-activities" data-toggle="tab" id="link-tab-activities"><i class="icon-globe"></i> Activités</a></li>
    <li><a href="#tab-members" data-toggle="tab" id="link-tab-members"><i class="icon-user"></i> Membres</a></li>
    <li><a href="#tab-preinscriptions" data-toggle="tab" id="link-tab-preinscriptions"><i class="icon-list-alt"></i> Préinscriptions</a></li>
    <li class="pull-right"><a href="#tab-history" data-toggle="tab" id="link-tab-history"><i class="icon-list-alt"></i> Historique</a></li>
    <li class="pull-right"><a href="#tab-config" data-toggle="tab" id="link-tab-config"><i class="icon-cog"></i> Configuration</a></li>
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
        <p>Il y a actuellement <span class="label"><?php echo $members; ?></span> membre<?php echo $plural_members; ?>, dont <span class="label label-success"><?php echo $adherents; ?></span> adhérent<?php echo $plural_adherents; ?></span>.</p>
      </div>
    </div>
    
    <!-- preinscriptions -->
    <div class="tab-pane" id="tab-preinscriptions">
      <p><a href="<?php echo _INSCRIPTION_; ?>" class="btn">Coming soon...</a></p>
    </div>
    
    <!-- history -->
    <div class="tab-pane" id="tab-history">
      <h3>Dernières connexions</h3>
      <div class="row">
        <div class="span10 offset1">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Utilisateur</th>
                <th>Privilèges</th>
                <th>Adresse IP</th>
              </tr>
            </thead>
            <?php echo $display_history; ?>
          </table>
        </div>
      </div>
    </div>
    
    <!-- config -->
    <div class="tab-pane" id="tab-config">
      <h4>debug</h4>
      <ul>
        <li><a href="https://docs.google.com/spreadsheet/ccc?key=0AtVq0USuJNKUdGttRUlhSjd6M1FLV0tTTFo3LVd2X3c" target="_blank">Suivi des bogues</a> [Google Doc]</li>
        <li><a href="/db.php" target="_blank">Database</a></li>
      </ul>
      <h4 style="margin-top:30px;">constants</h4>
      <table class="table table-striped">
        <?php echo $display_constants; ?>
      </table>
      
    </div>
    
  </div>
</div>

<?php
$scripts = '<script src="'. _FSC_ .'/js/active-tab.js"></script>';
?>