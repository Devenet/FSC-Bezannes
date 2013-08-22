<div class="row">
  <div class="span7">
    
    <h4>Récapitulatif</h4>
    <div class="alert alert-info espace">
      <?php echo $display_count_members; ?>
    </div>

    <h4>Identifiants</h4>
    <dl class="dl-horizontal">
      <dt>Courriel</dt>
        <dd><?php echo $u->login(); ?></dd>
      <dt>Mot de passe</dt>
        <dd><a href="#change-password" role="button" data-toggle="modal">modifier</a></dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Avatar</dt>
        <dd>
          <a id="gravatar-help" href="//fr.gravatar.com/emails" data-toggle="tooltip" title="Votre avatar est généré à partir votre courriel grâce au service Gravatar." data-placement="right" class="normal" rel="external">
            <img class="img-polaroid" style="margin-right:5px;" src="<?php echo $u->gravatar(100); ?>" alt="\o/" />
          </a>
      </dd>
    </dl>

    <div class="clearfix espace">
      <h4>Vos données</h4>
      <p>Les informations recueillies sont nécessaires pour votre adhésion.</p>
      <p>
        Elles font l’objet d’un traitement informatique et sont destinées au secrétariat de l’association. En application des articles 39 et suivants de la loi du 6 janvier 1978 modifiée, vous bénéficiez d’un droit d’accès et de rectification aux informations qui vous concernent.
        Si vous souhaitez exercer ce droit et obtenir communication des informations vous concernant, veuillez vous adresser au secrétariat du Foyer Social et Culturel de Bezannes.
      </p>
    </div>

    <p>
      <a href="<?php echo _PREINSCRIPTION_, '/delete/', $u->token(); ?>" class="normal text-error" id="delete-account" data-toggle="tooltip" data-html="true"
        title="Soucieux de vos données ? <br />Votre compte sera automatiquement détruit lors de la valdation de vos préinscriptions par le FSC." data-placement="right">
      <small style="margin-right: 5px;"><i class="icon-remove-sign"></i> Supprimer mon compte</small></a>
    </p>

  </div>

  <div class="span4 offset1 espace-top">
    <div class="well well-small">
      <h3 style="margin-top:0;">Sécurité</h3>
      <?php echo $security; ?>
    </div>
  </div>
</div>


<!-- Modal -->
<div id="change-password" class="modal hide fade" style="display:none;" tabindex="-1" role="dialog" aria-labelledby="modalChangePassword" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="modalChangePassword">Changer mon mot de passe</h3>
  </div>
  <form method="post" action="<?php echo _PREINSCRIPTION_; ?>/account" class="form form-horizontal" style="margin-bottom:0;">
    <div class="modal-body">
      <div class="control-group">
        <label class="control-label" for="password">Mot de passe actuel</label>
        <div class="controls">
          <input type="password" id="password" name="password" autofocus />
        </div>
      </div>
      <p class="alert alert-info"><strong>Note :</strong> votre mot de passe doit comporter au moins 7 caractères !</p>
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
.tooltip { text-align: left !important; }
</style>
<?php
  $_SCRIPT[] = '<script>$(function(){ 
    $("a#gravatar-help").tooltip();
    $("a#delete-account").tooltip();
  });</script>';
?>