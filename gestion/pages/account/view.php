<div class="page-header">
  <h2 style="margin-bottom:0;">Mon compte</h2>
</div>

<div class="row">
  <div class="span6">
    <dl class="dl-horizontal">
      <dt>Nom</dt>
      <dd><?php echo $u->name() ?></dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Identifiant</dt>
      <dd><?php echo $u->login() ?></dd>
      <dt>Mot de passe</dt>
      <dd><a href="#change-password" role="button" data-toggle="modal">modifier</a></dd>
    </dl>

    <dl class="dl-horizontal">
      <dt>Avatar</dt>
        <dd>
          <a id="gravatar-help" href="//fr.gravatar.com/emails" data-toggle="tooltip" title="Votre avatar est généré à partir votre courriel grâce au service Gravatar." data-placement="right" class="normal" rel="external">
            <img class="img-polaroid" style="margin-right:10px;" src="<?php echo $u->gravatar(100); ?>" alt="\o/" />
          </a>
      </dd>
    </dl>
  </div>

  <div class="span6">
    <dl class="dl-horizontal">
      <dt>Privilège</dt>
      <dd><?php echo $display_privilege; ?></dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Dernière connexion</dt>
      <dd><?php echo $display_last_history; ?></dd>
    </dl>
  </div>
</div>


<!-- Modal -->
<div id="change-password" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalChangePassword" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="modalChangePassword">Changer mon mot de passe</h3>
  </div>
  <form method="post" action="<?php echo _GESTION_; ?>/?page=account" class="form form-horizontal" style="margin-bottom:0;">
    <div class="modal-body">
      <div class="control-group">
        <label class="control-label" for="password">Mot de passe actuel</label>
        <div class="controls">
          <input type="password" id="password" name="password" autofocus />
        </div>
      </div>
      <p class="alert alert-info"><strong>Note :</strong> votre mot de passe doit comporter au moins 8 caractères !</p>
      <div class="control-group">
        <label class="control-label" for="new-password">Nouveau mot de passe</label>
        <div class="controls">
          <input type="password" id="new-password" name="new-password" />
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="confirm-new-password">Confirmation</label>
        <div class="controls">
          <input type="password" id="confirm-new-password" name="confirm-new-password" />
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a class="btn" data-dismiss="modal" aria-hidden="true">Annuler</a>
      <input type="submit" class="btn btn-primary" value="Modifier" />
    </div>
  </form>
</div>

<style>
a#gravatar-help img:hover { opacity: 0.8; }
</style>
<?php
  $_SCRIPT[] = '<script>$(function(){ $("a#gravatar-help").tooltip(); });</script>';
?>
