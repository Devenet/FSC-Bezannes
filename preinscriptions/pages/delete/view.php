<div class="row">
  <div class="span8 offset2">
    <form class="form form-horizontal" action="<?php echo _PREINSCRIPTION_.'/delete/'.$u->token(); ?>" method="post">
      <?php if (isset($display_count_members)) : ?>
      <div class="alert alert-error">
        En supprimant votre compte, <?php echo $display_count_members; ?>
      </div>
      <?php endif;
        // form messages
        if (isset($_SESSION['form_msg'])) {
          echo '<div class="control-group">', $_SESSION['form_msg'], '</div>';
          unset($_SESSION['form_msg']);
        }
      ?>

      <div class="espace">
        <p>Merci de valider la suppression de votre compte en confirmant votre mot de passe.</p>
      </div>
      <div class="control-group">
        <label class="control-label">Compte concerné</label>
        <div class="controls">
          <div class="input-prepend">
            <span class="add-on"><i class="icon-envelope"></i></span>
            <input type="text" disabled="disabled" value="<?php echo $u->login(); ?>" />
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="login">Mot de passe</label>
        <div class="controls">
          <div class="input-prepend">
            <span class="add-on"><i class="icon-lock" id="icon-password"></i></span>
            <input type="password" name="password" id="password" class="input-large"/>
          </div>
        </div>
      </div>

      <div class="form-actions espace-top">
        <button type="submit" class="btn btn-danger">Supprimer mon compte</button>
        <a href="<?php echo _PREINSCRIPTION_; ?>/list" class="btn">Annuler</a>
      </div>
    </form>
  </div>
</div>