<div class="row">
  <div class="span8">
    <div class="page-header" style="overflow:hidden; padding-bottom:5px">
      <h2 style="margin-bottom:0;"><?php echo $act->name(); ?>
      <div class="btn-group pull-right btn-small">
        <a href="./?page=edit-activity&amp;id=<?php echo $act->id(); ?>" class="btn  btn-small" title="Modifier l’activité"><i class="icon-pencil"></i></a>
        <?php /*
        <a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#"><i class="icon-plus"></i></a>  
        <ul class="dropdown-menu">
          <li><a href="/?page=new-schedule&amp;activity=<?php echo $act->id(); ?>"><i class="icon-time"></i> Horaire</a></li>
          <li><a href="/?page=new-referent&amp;activity=<?php echo $act->id(); ?>"><i class="icon-legal"></i> Référent</a></li>
          <?php if ($act->active()) echo '<li><a href="/?page=new-participant&amp;activity='. $act->id() .'"><i class="icon-male"></i> Participant</a></li>'; ?>
        </ul>
        */ ?>
        <a href="./?page=new-schedule&amp;activity=<?php echo $act->id(); ?>" title="Ajouter un horaire" class="btn btn-small"><i class="icon-plus"></i> Horaire</a>
        <a href="./?page=new-referent&amp;activity=<?php echo $act->id(); ?>" title="Ajouter un référent" class="btn btn-small"><i class="icon-plus"></i> Référent</a>
        <a href="#confirmBox<?php echo $act->id(); ?>" role="button" data-toggle="modal" class="btn btn-small" title="Supprimer l’activité"><i class="icon-trash"></i></a>
      </div>
      </h2>
    </div>

    
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-description" id="link-tab-description" data-toggle="tab"><i class="icon-book"></i> Description</a></li>
        <li><a href="#tab-schedules" id="link-tab-schedules" data-toggle="tab"><i class="icon-time"></i> Horaires</a></li>
        <li><a href="#tab-referents" id="link-tab-referents" data-toggle="tab"><i class="icon-legal"></i> Référents</a></li>
        <?php echo $act->active() ? '<li class="pull-right"><a href="#tab-participants" id="link-tab-participants" data-toggle="tab"><i class="icon-male"></i> Participants <span class="label label-info">'.$count_participants.'</span></a></li>' : null; ?>
      </ul>
      
      <div class="tab-content">
        <!-- description -->
        <div class="tab-pane active" id="tab-description">
          <div class="description">
            <div class="pull-right" style="margin-left: 20px; margin-bottom: 20px;"><a href="./?page=edit-activity&amp;id=<?php echo $act->id(); ?>" class="btn  btn-small" title="Modifier l’activité"><i class="icon-pencil"></i> Modifier</a></div>
            <?php echo stripslashes($act->description()); ?>
          </div>
        </div>
        
        <!-- horaires -->
        <div class="tab-pane" id="tab-schedules">
          <div style="overflow: hidden;">
            <p class="pull-left">Il s’agit d’une activité à pratique <span class="label"><?php echo ($act->aggregate() == 0 ? 'non libre' : 'libre'); ?></span>.</p>
            <a class="btn btn-small pull-right" href="./?page=new-schedule&amp;activity=<?php echo $act->id(); ?>"><i class="icon-plus"></i> Ajouter</a>
          </div>
          <div style="clear:both; margin-top: 10px;">
            <?php echo $display_schedules; ?>
          </div>
        </div>
        
        <!-- referents -->
        <div class="tab-pane" id="tab-referents">
          <div style="overflow: hidden;">
            <p class="pull-left">L’activité possède <span class="label"><?php echo $count_referents; ?></span> référent<?php echo $plural_count_referents; ?>.</p>
            <a class="btn btn-small pull-right" href="./?page=new-referent&amp;activity=<?php echo $act->id(); ?>"><i class="icon-plus"></i> Ajouter</a>
          </div>
          <div style="clear:both; margin-top: 10px;">
            <?php echo $display_referents; ?>
          </div>
        </div>
        
        <!-- participants -->
        <?php if ($act->active()): ?>
        <div class="tab-pane" id="tab-participants">
          <div style="overflow: hidden;">
            <p class="pull-left">L’activité possède <span class="label"><?php echo $count_participants; ?></span> participant<?php echo $plural_count_participants; ?>.</p>
            <a class="btn btn-small pull-right" href="./?page=new-participant&amp;activity=<?php echo $act->id(); ?>"><i class="icon-plus"></i> Ajouter</a>
          </div>
          <div style="clear:both; margin-top: 10px;">
            <?php echo $display_participants; ?>
          </div>
        </div>
        <?php endif; ?>
        
      </div>
    </div>
    
  </div>
  
  <div class="span3 offset1" style="margin-top:20px;">
    <div class="well well-small">
      <strong>Activité</strong> : <span class="">#<?php echo $act->id(); ?></span>
    </div>
    
    <div class="alert <?php echo ($act->active() == 1 ? 'alert-success' : ''); ?>">
      <?php echo ($act->active() == 1) ? '<a href="'. _FSC_ .'/activite/'. $act->url() .'" rel="external" class="normal text-success">' : ''; ?>
      Activité <strong><?php echo ($act->active() == 1) ? 'activée' : 'désactivée' ; ?></strong>
      <?php echo ($act->active() == 1) ? ' <span class="external-link"><i class="icon-external-link"></i></a>' : ''; ?>
      <a href="?page=activity&amp;id=<?php echo $act->id(); ?>&amp;action=change-status" class="pull-right normal" id="change-status" style="margin-right:0px;" data-toggle="tooltip" 
        title="<?php echo ($act->active() == 1) ? 'En désactivant l’activité, tous les participants seront supprimés !' : 'Vous pouvez l’activer si elle possède au moins un horaire et un référent.'; ?>" 
        data-placement="left"><i class="icon-retweet" style="margin-left:10px;"></i></a>
    </div>    
    
    <div class="alert alert-info">
      <strong>Tarif</strong> : <?php echo $act->price(); ?> €
      <?php echo ($act->price_young() != -1 ? '<br /><strong>Tarif jeune</strong> : '. $act->price_young() .' €' : null); ?>
    </div>
    
    <div class="well well-small">
      <address style="margin-bottom:0;"><i class="icon-map-marker"></i> <?php echo $act->place(); ?></address>
    <?php
      if ($act->email() != null || $act->website() != null) {
        echo '<div style="margin-top:5px;"></div>';
        if ($act->email() != null)
          echo '<i class="icon-envelope-alt"></i> <a href="mailto:', $act->email(), '" title="', $act->email() , '">Courriel</a>';
        if ($act->email() != null && $act->website() != null)
          echo '<br />';
        if ($act->website() != null)
          echo '<i class="icon-globe"></i> <a href="http://', $act->website(), '" title="', $act->website() , '" rel="external">Site web</a>';
      }
    ?>
    </div>
    
    <div class="center">
      <?php
        if ($act->hasImage())
          echo '<img src="', _UPLOADS_, '/activities/', $act->id(), '.jpg" alt="', $act->name(), '" class="img-polaroid" />';
        else
          echo '<p><a href="./?page=edit-activity&amp;id=', $act->id(), '#image" class="normal img-polaroid" data-toggle="tooltip" 
                title="L’image sert de miniature pour l’activité." data-placement="bottom"><i class="icon-picture"></i> aucune image associée</a></p>';
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
    <a href="./?page=activity&amp;id=<?php echo $act->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
  </div>
</div>

<?php
$_SCRIPT[] = '<script src="'. _FSC_ .'/js/fsc-active-tab.js"></script>';
$_SCRIPT[] = '<script>$(function(){ 
  $("a#change-status").tooltip();
  $("a.img-polaroid").tooltip();
});</script>'
?>