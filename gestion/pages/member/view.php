<?php
use lib\content\Display;
?>

<div class="row">
  <div class="span8">
    <div class="page-header" style="overflow:hidden; padding-bottom:5px;">
      <h2 style="margin-bottom:0;"><?php echo $m->name(); ?>
      <div class="btn-group pull-right btn-small">
        <a href="./?page=edit-member&amp;id=<?php echo $m->id(); ?>" class="btn btn-small" title="Modifier le membre"><i class="icon-pencil"></i></a>
        <?php echo ($m->minor() ? '<a href="./?page=choose-responsible&amp;member='. $m->id() .'"  class="btn btn-small" title="Modifier le responsable"><i class="icon-male"></i> Responsable</a>' : NULL); ?>
        <?php echo ($m->adherent() ? '<a href="./?page=new-participant&amp;adherent='. $m->id() .'"  class="btn btn-small" title="Ajouter une activité"><i class="icon-plus"></i> Activité</a>' : NULL); ?>
        <a href="#confirmBox<?php echo $m->id(); ?>" class="btn btn-small" role="button" data-toggle="modal" title="Supprimer le membre"><i class="icon-trash"></i></a>
      </div>
      <?php /*
      <div class="btn-group pull-right">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="/?page=edit-member&amp;id=<?php echo $m->id(); ?>"><i class="icon-cog"></i>
        <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="/?page=edit-member&amp;id=<?php echo $m->id(); ?>"><i class="icon-pencil"></i> Modifier</a></li>
          <?php echo ($m->minor() ? '<li><a href="/?page=choose-responsible&amp;member='. $m->id() .'"><i class="icon-user"></i> Représentant</a></li>' : NULL); ?>
          <?php echo ($m->adherent() ? '<li class="divider"></li> <li><a href="/?page=new-participant&amp;adherent='. $m->id() .'"><i class="icon-plus"></i> Activité</a></li>' : NULL); ?>
          <li class="divider"></li>
          <li><a href="#confirmBox<?php echo $m->id(); ?>" role="button" data-toggle="modal"><i class="icon-trash"></i> Supprimer</a></li>
        </ul>
      </div>
      */ ?>
      </h2>
    </div>
    
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-infos" id="link-tab-infos" data-toggle="tab"><i class="icon-user"></i> Informations</a></li>
        <li><a href="#tab-address" id="link-tab-adress" data-toggle="tab"><i class="icon-map-marker"></i> Coordonnées</a></li>
        <?php echo ($m->adherent() ? '<li><a href="#tab-payments" id="link-tab-payments" data-toggle="tab"><i class="icon-shopping-cart"></i> Paiements</a></li><li class="pull-right"><a href="#tab-activities" id="link-tab-activities" data-toggle="tab"><i class="icon-globe"></i> Activités <span class="label label-info">'. $count_activites .'</span></a></li>' : NULL); ?>
      </ul>
      
      <div class="tab-content">
        <!-- infos -->
        <div class="tab-pane active" id="tab-infos">
          <div class="clearfix">
          <div class="span3">
            <h4>Civilité</h4>
            <p><?php echo Display::FullGender($m->gender()), ' ', $m->last_name(), ' ', $m->first_name(); ?></p>
            <p><i class="icon-gift"></i> <?php echo Display::Date($m->date_birthday()), ' (', $m->age(), ' ans)'; ?></p>
          </div>
          
          <div class="span3 offset1">
            <h4>Inscription</h4>
            <p>Membre créé le <?php echo Display::Date($m->date_creation()); ?></p>
            <?php if ($m->adherent()): ?>
            <p>Adhérent depuis le <?php echo Display::Date($m->date_registration()); ?></p>
            <?php endif; ?>
          </div>
          </div>
          
          <?php if ($m->minor()): ?>
            <div class="span3">
              <h4>Responsable</h4>
              <p><?php echo Display::HtmlGender($r->gender()), ' ', $r->name(); ?> [<a href="./?page=member&amp;id=<?php echo $r->id(); ?>">#<?php echo $r->id(); ?></a>]</p>
            </div>
          <?php endif; ?>
          <?php
            if ($m->countResponsabilities() > 0) {
              echo '<div class="span3">', '<h4>Responsabilité</h4>';
              $minors = $m->Responsabilities();
              echo '<ul>';
              foreach ($minors as $minor)
                echo '<li>', Display::HtmlGender($minor->gender()), ' ', $minor->name(), ' [<a href="./?page=member&amp;id=', $minor->id(), '">#', $minor->id(), '</a>]</li>';
              echo '</ul>', '</div>';
            }
          ?>
          <?php
            if (isset($display_referent)) {
              echo '<div class="clearfix"></div><hr /><div class="span6">', '<h4>Référent</h4>';
              echo '<ul>', $display_referent, '</ul>';
              echo '</div>';
            }
          ?>
          
          
        </div>
        
        <!-- coordonnees -->
        <div class="tab-pane" id="tab-address">
          <div class="span3">
            <?php if (!$m->minor() || $m->address_different()) : ?>
            <h4>Adresse</h4>
            <address>
              <?php echo $m->address(); ?>
            </address>
            <?php endif; ?>
            
            <?php if ($m->minor()): ?>
            <h4>Adresse du responsable</h4>
            <address>
              <?php echo $r->address(); ?>
            </address>
            <?php endif; ?>
          </div>
          <div class="span3 offset1">
            <h4>Contact</h4>
            <p>
              <i class="icon-phone"></i> <?php echo Display::Phone($m->phone()); ?>
              <?php echo ($m->mobile() != NULL ? '<br /><i class="icon-phone"></i> '. Display::Phone($m->mobile()) : NULL); ?>
            </p>
            <p><i class="icon-envelope-alt"></i> <?php echo Display::Email($m->email()); ?></p>
            
            <?php if ($m->minor()): ?>
            <h4>Responsable</h4>
            <p>
              <i class="icon-phone"></i> <?php echo Display::Phone($r->phone()); ?>
              <?php echo ($r->mobile() != NULL ? '<br /><i class="icon-phone"></i> '. Display::Phone($r->mobile()) : NULL); ?>
            </p>
            <p><i class="icon-envelope-alt"></i> <?php echo Display::Email($r->email()); ?></p>
            <?php endif; ?>
          </div>
        </div>
        
        <!-- paiements -->
        <?php if ($m->adherent()): ?>
        <div class="tab-pane" id="tab-payments">
          <div class="clearfix">
            <p class="pull-left">
              Les frais d’inscription de <?php echo $m->first_name(); ?> s’élèvent à <span class="label"><?php echo preg_replace('#\.#', ',', $cost_payments); ?></span> &euro;.
              <?php if ($total_payments != $cost_payments) echo '<br />Les frais totaux de '. $m->first_name() .' s’élèvent à <span class="label label-inverse">'. preg_replace('#\.#', ',', $total_payments) .'</span> &euro;.'; ?>
            </p>
            <!--
            <div class="btn-group pull-right">
              <a class="btn dropdown-toggle btn-small" data-toggle="dropdown" href="#"><i class="icon-plus"></i> Ajouter
              <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/?page=new-transaction&amp;adherent=<?php echo $m->id(); ?>"><i class="icon-shopping-cart"></i> Transaction</a></li>
                <li class="divider"></li>
                <li><a href="/?page=new-advantage&amp;adherent=<?php echo $m->id(); ?>"><i class="icon-gift"></i> Avantage</a></li>
              </ul>
            </div>
            -->
            <div class="btn-group pull-right">
              <a class="btn btn-small" href="./?page=new-transaction&amp;adherent=<?php echo $m->id(); ?>"><i class="icon-shopping-cart"></i> Transaction</a>
              <a class="btn btn-small" href="./?page=new-advantage&amp;adherent=<?php echo $m->id(); ?>"><i class="icon-gift"></i> Avantage</a>
            </div>
          </div>
          <div style="clear:both; margin-top: 10px;">
            <?php echo $display_payments; ?>
          </div>
        </div>
        
        <!-- activites -->
        <div class="tab-pane" id="tab-activities">
          <div style="overflow: hidden;">
            <p class="pull-left"><?php echo $m->first_name(); ?> participe à <span class="label"><?php echo $count_activites; ?></span> activité<?php echo $plural_count_activities; ?>.</p>
            <a class="btn btn-small pull-right" href="./?page=new-participant&amp;adherent=<?php echo $m->id(); ?>"><i class="icon-plus"></i> Ajouter</a>
          </div>
          <div style="clear:both; margin-top: 10px;">
            <?php echo $activities_participant; ?>
          </div>
        </div>
        <?php endif; ?>
        
      </div>
    </div>
    
  </div>
  
  <div class="span3 offset1" style="margin-top:20px;">
    <div class="well well-small">
      <strong>Membre</strong> : <span class="">#<?php echo $m->id(); ?></span>
    </div>
    
    <div class="alert <?php echo ($m->adherent() ? 'alert-success' : ''); ?>">
      <strong><?php echo ($m->adherent() ? 'Adhérent' : 'Membre'); ?></strong>
    </div>    
    
    <div class="well well-small">
      <?php echo ($m->bezannais() ? '<i class="icon-home"></i> Bezannais' : 'Extérieur'); ?>
      <br /><?php echo (!$m->minor() ? 'Adulte' : 'Jeune'); ?>
    </div>
    
  </div>
  
</div><!-- /row -->


<div id="confirmBox<?php echo $m->id(); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ConfirmDelmember<?php echo $m->id(); ?>" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="ConfirmDelmember<?php echo $m->id(); ?>"><?php echo $m->name(); ?></h3>
</div>
<div class="modal-body">
<p class="text-error">Êtes-vous sûr de vouloir supprimer ce membre ?</p>
</div>
<div class="modal-footer">
<a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
<a href="./?page=member&amp;id=<?php echo $m->id(); ?>&amp;action=delete" class="btn btn-danger">Confirmer</a>
</div>
</div>

<?php
  $_SCRIPT[] = '<script src="'. _FSC_ .'/js/fsc-active-tab.js"></script>';
?>