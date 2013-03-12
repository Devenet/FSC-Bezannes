<div class="row">
  <div class="span12">
    <div class="page-header">
      <h2 style="margin-bottom: 0;">Configuration</h2>
    </div>
  </div>
  
  <div class="span3 pull-right">
    <h4>Développement</h4>
    <ul>
      <li><a href="/test.php" target="_blank">Test <i class="icon-share-alt"></i></a></li>
      <li><a href="/db.php" target="_blank">État de la BDD <i class="icon-share-alt"></i></a></li>
    </ul>
    <ul>
      <li><a href="/clean.php" onclick="if (confirm('Cette action va nettoyer les descriptions des activités ! \nAction irréversible.')) return true; return false;" target="_blank">Nettoyage <i class="icon-share-alt"></i></a></li>
      <li><a href="/init.php" onclick="if (confirm('Cette action va tenter d’initialiser la BDD. \nAjout d’une activité, un référent et des horaires.')) return true; return false;" target="_blank">Initialisation <i class="icon-share-alt"></i></a></li>
    </ul>
    <hr />
    <h4>OVH</h4>
    <ul>
      <li><a href="https://www.ovh.com/managerv3/" target="_blank">Manager <i class="icon-share-alt"></i></a></li>
      <li><a href="https://phpmyadmin.ovh.net/" target="_blank">phpMyAdmin <i class="icon-share-alt"></i></a></li>
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