<div class="row">
  <div class="span12">
    <div class="page-header">
      <h2 style="margin-bottom: 0;">Configuration</h2>
    </div>
  </div>
  
  <div class="span3 pull-right">
    <h4>Développement</h4>
    <ul>
      <li><a href="/db.php" rel="external">État de la BDD <i class="icon-external-link"></i></a></li>
    </ul>
    <ul>
      <li><a href="/clean.php" onclick="if (confirm('Cette action va nettoyer les descriptions des activités ! \nAction irréversible.')) return true; return false;" rel="external">Nettoyage <i class="icon-external-link"></i></a></li>
      <li><a href="/init.php" onclick="if (confirm('Cette action va tenter d’initialiser la BDD. \nAjout d’une activité, un référent et des horaires.')) return true; return false;" rel="external">Initialisation <i class="icon-external-link"></i></a></li>
    </ul>
    <hr />
    <h4>OVH</h4>
    <ul>
      <li><a href="https://www.ovh.com/managerv3/" rel="external">Manager <i class="icon-external-link"></i></a></li>
      <li><a href="https://phpmyadmin.ovh.net/" rel="external">phpMyAdmin <i class="icon-external-link"></i></a></li>
    </ul>
  </div>
  
  <div class="span9 pull-left">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Constante</th>
          <th>Valeur</th>
        </tr>
      </thead>
      <?php echo $display_constants; ?>
    </table>
  </div>
</div>