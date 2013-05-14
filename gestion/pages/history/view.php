<div class="row">
  <div class="span12">
    <div class="page-header">
      <h2 style="margin-bottom: 0;">Dernières connexions</h2>
    </div>
  </div>
  <div class="span10 offset1">
  <!-- history -->
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

<div class="pagination pagination-centered">
  <ul>
    <?php echo $display_pagination; ?>
  </ul>
</div>