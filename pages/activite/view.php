<div class="row">
  
  <div class="span9">
    <div class="page-header">
      <h2><?php echo $act->name(); ?></h2>
    </div>
    
    <ul class="inline" style="margin-top:-15px;">
      <li><address><i class="icon-map-marker"></i> <?php echo $act->place(); ?></address></li>
      <?php
        if ($act->email() != null)
          echo '<li><i class="icon-envelope"></i> <a href="mailto:', $act->email(), '" title="', $act->email() , '">Courriel</a></li>';
        if ($act->website() != null)
          echo '<li><i class="icon-globe"></i> <a href="http://', $act->website(), '" title="', $act->website() , '" rel="external">Site web</a></li>';
      ?>
    </ul>
    
  </div>
  
  <div class="span3 hidden-phone">
    <div class="center">
      <img src="<?php echo _DATA_; ?>/activities/<?php echo $act->image() ? $act->id() : '0'; ?>.jpg" alt="<?php echo $act->name(); ?>" class="img-polaroid" />
    </div>
  </div>
  
  <div class="span3 offset1 pull-right infos">
    <div class="alert alert-info">
      <strong>Tarif</strong> : <?php echo ($act->price() > 0 ? $act->price().' &euro;' : 'gratuit'); ?>
      <?php echo ($act->price_young() != -1 ? '<br /><strong>Tarif jeune</strong> : '. $act->price_young() .' €' : null); ?>
    </div>
    
    <div class="well well-small">
      <?php echo $display_schedules; ?>
    </div>
    
    <div style="padding:10px 12px 0; border:1px solid #dedede; border-radius:3px;">
      <!--<p><i class="icon-user"></i> Contact</p>-->
      <?php echo $display_referents; ?>
    </div>
  </div>
  
    <div class="span8 pull-left">
    <div class="description">
      <?php echo stripslashes($act->description()); ?>
    </div>
  </div>
  
</div><!-- /row -->

