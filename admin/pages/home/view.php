<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab"><i class="icon-globe"></i> Activités</a></li>
    <li><a href="#tab2" data-toggle="tab"><i class="icon-user"></i> Membres</a></li>
    <li><a href="#tab3" data-toggle="tab"><i class="icon-asterisk"></i> Préinscriptions</a></li>
    <li class="pull-right"><a href="#tab4 data-toggle="tab"><i class="icon-cog"></i> Configuration</a></li>
  </ul>
  
  <div class="tab-content">
    <!-- activites -->
    <div class="tab-pane active" id="tab1">
      <div class="btn-group">
        <a href="/?page=activities" class="btn"><i class="icon-eye-open"></i> Voir</a>
        <a href="/?page=new-activity" class="btn"><i class="icon-plus"></i> Ajouter</a>
      </div>
      <div style="margin-top:20px;">
        <p>Il y a actuellement <span class="label"><?php echo $activities; ?></span> activités.</p>
      </div>
    </div>
    
    <!-- membres -->
    <div class="tab-pane" id="tab2">
      <p>Coming very soon...</p>
    </div>
    
    <!-- preinscriptions -->
    <div class="tab-pane" id="tab3">
      <p>Coming soon...</p>
    </div>
    
    <!-- config -->
    <div class="tab-pane" id="tab4">
      <p>Coming later...</p>
    </div>
    
  </div>
</div>

<!--
<div class="row">
  
  <div class="span2 offset3">
    <div class="btn-group">
      <a class="btn dropdown-toggle btn-large" data-toggle="dropdown" href="#"><i class="icon-globe"></i>
      Activités
      <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <li><a href="/?page=activities"><i class="icon-eye-open"></i> Voir</a></li>
        <li class="divider"></li>
        <li><a href="/?page=new-activity"><i class="icon-plus"></i> Ajouter</a></li>
      </ul>
    </div>
  </div>
  
  <div class="span2 offset2">
    <div class="btn-group">
      <a class="btn dropdown-toggle btn-large" data-toggle="dropdown" href="#"><i class="icon-user"></i>
      Membres
      <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <li><a href="/?page=members"><i class="icon-eye-open"></i> Voir</a></li>
        <li class="divider"></li>
        <li><a href="/?page=new-member"><i class="icon-plus"></i> Ajouter</a></li>
      </ul>
    </div>
  </div>
  
</div>
-->