<div class="page-header">
  <h2 style="margin-bottom: 0;">Historique</h2>
</div>

<ul class="nav nav-tabs">
  <li class="active"><a href="?page=history">Dernières connexions</a></li>
  <li><a href="?page=changelog">Changelog</a></li>
</ul>

<div class="clearfix"></div>

<div class="row espace-top">
  <div class="span10 offset1">
  <!-- history -->
  <table class="table table-striped table-bordered table-hover">
    <thead>
      <tr>
        <th>Date</th>
        <th>Heure</th>
        <th>Utilisateur</th>
        <th>Adresse IP</th>
      </tr>
    </thead>
    <?php echo $display_history; ?>
  </table>
  </div>
</div>

<div class="pagination pagination-centered">
  <ul>
    <?php echo $display_pagination; ?>
  </ul>
</div>