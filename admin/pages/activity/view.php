<div class="row">
  <div class="span8">
    <div class="page-header">
      <h2 style="margin-bottom:0;"><?php echo $act->name(); ?>
      <div class="btn-group pull-right">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i>
        <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="/?page=edit-activity&id=<?php echo $act->id(); ?>"><i class="icon-pencil"></i> Modifier</a></li>
          <li class="divider"></li>
          <li class="dropdown-submenu">
            <a tabindex="-1" href="#"><i class="icon-plus"></i> Ajouter</a>
            <ul class="dropdown-menu">
              <li><a href="/?page=add-schedule&activity=<?php echo $act->id(); ?>"><i class="icon-time"></i> Horaire</a></li>
              <li><a href="/?page=add-referencee&activity=<?php echo $act->id(); ?>"><i class="icon-lock"></i> Référent</a></li>
              <li><a href="/?page=add-participant&activity=<?php echo $act->id(); ?>"><i class="icon-user"></i> Participant</a></li>
            </ul>
          </li>
          <li class="divider"></li>
          <li><a href="#confirmBox<?php echo $act->id(); ?>" role="button" data-toggle="modal"><i class="icon-trash"></i> Supprimer</a></li>
        </ul>
      </div>
      </h2>
    </div>
    
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><i class="icon-book"></i> Description</a></li>
        <li><a href="#tab2" data-toggle="tab"><i class="icon-time"></i> Horaires</a></li>
        <li><a href="#tab3" data-toggle="tab"><i class="icon-lock"></i> Référents</a></li>
        <li class="pull-right"><a href="#tab4" data-toggle="tab"><i class="icon-user"></i> Participants</a></li>
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
            <p class="pull-left">Il s’agit d’une activité à créneaux <?php echo ($act->aggregate() == 0 ? '<strong>non libres</strong>' : '<strong>libres</strong>'); ?>.</p>
            <a class="btn btn-small btn-primary pull-right" href="/?page=new-schedule&activity=<?php echo $act->id(); ?>"><i class="icon-plus icon-white"></i> Ajouter</a>
          </div>
        </div>
        
        <!-- autorites -->
        <div class="tab-pane" id="tab3">
          <p>Coming soon...</p>
        </div>
        
        <!-- participants -->
        <div class="tab-pane" id="tab4">
          <p>Coming later...</p>
        </div>
        
      </div>
    </div>
    
  </div>
  
  <div class="span3 offset1" style="margin-top:20px;">
    <div class="well well-small">
      <strong>Identifiant</strong> : <span class="">#<?php echo $act->id(); ?></span>
    </div>
    
    <div class="alert <?php echo ($act->active() == 1 ? 'alert-success' : ''); ?>">
      Activité <strong><?php echo ($act->active() == 1) ? 'activée</strong> <a href="'. _FSC_ .'/?page=activite&id='. $act->id() .'" target="_blank">&rarr;</a>' : 'désactivée</strong>' ; ?>
    </div>    
    
    <div class="alert alert-info">
      <!--<a class="close" href="#"><i class="icon-pencil"></i></a>-->
      <strong>Tarif</strong> : <?php echo $act->price(); ?> €
      <?php echo ($act->price_young() != -1 ? '<br /><strong>Tarif jeune</strong> : '. $act->price_young() .' €' : null); ?>
    </div>
    
    <div class="well well-small">
      <address style="margin-bottom:0;"><i class="icon-map-marker"></i> <?php echo $act->place(); ?></address>
    <?php
      if ($act->email() != null || $act->website() != null) {
        if ($act->email() != null)
          echo '<i class="icon-envelope"></i> <a href="mailto:', $act->email(), '" title="', $act->email() , '">Courriel</a>';
        if ($act->email() != null && $act->website() != null)
          echo '<br />';
        if ($act->website() != null)
          echo '<i class="icon-globe"></i> <a href="http://', $act->website(), '" title="', $act->website() , '" target="_blank">Site web</a>';
      }
    ?>
    </div>
    
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
<a class="btn" data-dismiss="modal" aria-hidden="true"/>Annuler</a>
<a href="/?page=activity&id=<?php echo $act->id(); ?>&action=delete" class="btn btn-danger">Confirmer</a>
</div>
</div>