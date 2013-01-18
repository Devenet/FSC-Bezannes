<div class="row">
  <div class="span8">
    <div class="page-header">
      <h2><?php echo $act->name(); ?></h2>
    </div>
    
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><i class="icon-book"></i> Description</a></li>
        <li><a href="#tab2" data-toggle="tab"><i class="icon-time"></i> Horaires</a></li>
        <li><a href="#tab3" data-toggle="tab"><i class="icon-user"></i> Référents</a></li>
      </ul>
      
      <div class="tab-content">
        <!-- description -->
        <div class="tab-pane active" id="tab1">
          <div class="description">
            <?php echo stripslashes($act->description()); ?>
          </div>
        </div>
        
        <!-- horaires -->
        <div class="tab-pane" id="tab2">
          <div>
            <p>Il s’agit d’une activité à pratique <span class="label"><?php echo ($act->aggregate() == 0 ? 'non libre' : 'libre'); ?></span>.</p>
          </div>
          <div>
            <?php echo $display_schedules; ?>
          </div>
        </div>
        
        <!-- referents -->
        <div class="tab-pane" id="tab3">
          <div>
            <?php echo $display_referents; ?>
          </div>
        </div>
        
      </div>
    </div>
    
  </div>
  
  <div class="span3 offset1" style="margin-top:20px;">  
    
    <div class="alert alert-info">
      <strong>Tarif</strong> : <?php echo ($act->price() > 0 ? $act->price().' &euro;' : 'gratuit'); ?>
      <?php echo ($act->price_young() != -1 ? '<br /><strong>Tarif jeune</strong> : '. $act->price_young() .' €' : null); ?>
    </div>
    
    <div class="well well-small">
      <address style="margin-bottom:0;"><i class="icon-map-marker"></i> <?php echo $act->place(); ?></address>
    <?php
      if ($act->email() != null || $act->website() != null) {
        echo '<div class="espace-small-top">';
        if ($act->email() != null)
          echo '<i class="icon-envelope"></i> <a href="mailto:', $act->email(), '" title="', $act->email() , '">Courriel</a>';
        if ($act->email() != null && $act->website() != null)
          echo '<br />';
        if ($act->website() != null)
          echo '<i class="icon-globe"></i> <a href="http://', $act->website(), '" title="', $act->website() , '" target="_blank">Site web</a>';
        echo '</div>';
      }
    ?>
    </div>
    
  </div>
  
</div><!-- /row -->


<div id="confirmBox<?php echo $act->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelActivity<?php echo $act->id(); ?>" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="ConfirmDelActivity<?php echo $act->id(); ?>"><?php echo $act->name(); ?></h3>
  </div>
  <div class="modal-body">
    <p class="text-error">Êtes-vous sûr de vouloir supprimer cette activité ?</p>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
    <a href="/?page=activity&amp;id=<?php echo $act->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>