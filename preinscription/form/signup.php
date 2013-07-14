<?php
  $login_message = 'Votre adresse e-mail sera votre identifiant';
  $password_message = 'Votre mot de passe doit comporter au minimum 7 caractères';
  $confirm_password_message = 'Merci de confirmer votre mot de passe';
  if (!isset($_SESSION['captcha']))
    $_SESSION['captcha'] = array(rand(1, 20), rand(1, 20));
?>

<form action="<?php echo $form->action(); ?>" method="<?php echo $form->method();?>" class="form-horizontal">
  <?php echo ($form->legend() != null ? '<legend>'. $form->legend() .'</legend>' : null); ?>
  
  <!-- form messages -->
  <?php
    if (isset($_SESSION['form_msg'])) {
      echo '<div class="row"><div class="span8">', $_SESSION['form_msg'], '</div></div><div class="clearfix"></div>';
      unset($_SESSION['form_msg']);
    }
  ?>
  <!-- /form messages -->
  
  <h3 class="controls">Mon compte</h3>
  
  <div class="control-group" id="parent-login">
    <label class="control-label" for="login">Courriel</label>
    <div class="controls">
      <div class="input-prepend">
        <span class="add-on"><i class="icon-envelope" id="icon-login"></i></span>
        <input type="text" name="login" id="login" class="input-large" <?php echo $form->value('login'); ?> autofocus />
      </div>
      <span class="help-block"><?php echo $login_message; ?></span>
    </div>
  </div>

  <div class="control-group" id="parent-password">
    <label class="control-label" for="login">Mot de passe</label>
    <div class="controls">
      <div class="input-prepend">
        <span class="add-on"><i class="icon-lock" id="icon-password"></i></span>
        <input type="password" name="password" id="password" class="input-large" <?php echo $form->value('password'); ?>/>
      </div>
      <span class="help-block"><?php echo $password_message; ?></span>
    </div>
  </div>

  <div class="control-group" id="parent-confirm-password">
    <label class="control-label" for="confirm-password">Confirmation</label>
    <div class="controls">
      <div class="input-prepend">
        <span class="add-on"><i class="icon-repeat" id="icon-confirm-password"></i></span>
        <input type="password" name="confirm-password" id="confirm-password" class="input-large" <?php echo $form->value('confirm-password'); ?>/>
      </div>
      <span class="help-block"><?php echo $confirm_password_message; ?></span>
    </div>
  </div>

  <div class="control-group" id="parent-captcha">
    <label class="control-label" for="captcha">Anti-robots</label>
    <div class="controls">
      <div class="input-prepend">
        <span class="add-on"><i class="icon-plus" id="icon-captcha"></i></span>
        <input type="text" name="captcha" id="captcha" class="input-large"/>
      </div>
      <span class="help-block">Combien font <?php echo $_SESSION['captcha'][0], ' + ', $_SESSION['captcha'][1]; ?> ?</span>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <label class="checkbox" for="cnil">
        <input type="checkbox" name="cnil" id="cnil" <?php echo $form->checkbox('cnil'); ?>/> Je confirme avoir pris connaissance de mes droits.
      </label>
      <span class="help-block cnil"><span class="info"></span> <span class="text">Les informations recueillies sont nécessaires pour votre adhésion.<br/>
        Elles font l’objet d’un traitement informatique et sont destinées au secrétariat de l’association. En application des articles 39 et suivants de la loi du 6 janvier 1978 modifiée, vous bénéficiez d’un droit d’accès et de rectification aux informations qui vous concernent.<br />
        Si vous souhaitez exercer ce droit et obtenir communication des informations vous concernant, veuillez vous adresser au secrétariat du Foyer Social et Culturel de Bezannes.</span>
      </span>
    </div>
  </div>

  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary" value="<?php echo $form->submit(); ?>" /> 
    <input type="reset" class="btn" value="Effacer" />
  </div>
  
</form>

<?php
 $_SCRIPT[] = '
<script>
$(document).ready(function(){
  function isValidMail(email) {
    var pattern = '."/^([\w-\+\.]+@([\w-]+\.)+[\w]{2,4})?$/".';
    return pattern.test(email);
  }
  function check_login() {
    var length = $("#login").val().length;
    if (length > 0) {
      if (!isValidMail($("#login").val())) {
        $("#parent-login").removeClass("success").addClass("error");
        $("#icon-login").removeClass().addClass("icon-envelope");
        $("#parent-login span.help-block").text("Adresse invalide !");
      }
      else {
        $("#parent-login").removeClass("error").addClass("success");
        $("#icon-login").removeClass().addClass("icon-ok");
        $("#parent-login span.help-block").text("Votre identifiant sera donc "+$("#login").val());
      }
    }
    else {
      $("#parent-login").removeClass("error").removeClass("success");
      $("#icon-login").removeClass().addClass("icon-envelope");
      $("#parent-login span.help-block").text("'. $login_message .'");
    }
  }
  function check_password() {
    var length = $("#password").val().length;
    if (length >= 7) {
      $("#parent-password").addClass("success");
      $("#icon-password").removeClass().addClass("icon-ok");
      $("#parent-password span.help-block").text("Super ! N’hésitez pas à mettre des caractères spéciaux ;)");
    }
    else {
      $("#parent-password").removeClass("success");
      $("#icon-password").removeClass().addClass("icon-lock");
      $("#parent-password span.help-block").text("'. $password_message .'");
    }
    check_confirm_password();
  }
  function check_confirm_password() {
    var length = $("#confirm-password").val().length;
    var password = $("#password").val();
    var confirmation = $("#confirm-password").val();
    if (length >= 7) {
      if (password == confirmation) {
        $("#parent-confirm-password").addClass("success");
        $("#icon-confirm-password").removeClass().addClass("icon-ok");
        $("#parent-confirm-password span.help-block").text("Les mots de passe correspondent :)");
      }
      else {
        $("#parent-confirm-password").addClass("error").removeClass("success");
        $("#icon-confirm-password").removeClass().addClass("icon-repeat");
        $("#parent-confirm-password span.help-block").text("Les mots de passe ne correspondent pas !");
      }
    }
    else {
      $("#parent-confirm-password").removeClass("success").removeClass("error");
      $("#icon-confirm-password").removeClass().addClass("icon-repeat");
      $("#parent-confirm-password span.help-block").text("'. $confirm_password_message .'");
    }
  }
  function check_captcha() {
    var length = $("#captcha").val().length;
    if (length > 0 && $("#captcha").val() == '. ($_SESSION['captcha'][0] + $_SESSION['captcha'][1]) .') {
      $("#parent-captcha").removeClass("error").addClass("success");
      $("#icon-captcha").removeClass().addClass("icon-ok");
    }
    else {
      $("#parent-captcha").removeClass("success");
      $("#icon-captcha").removeClass().addClass("icon-plus");
    }
  }

  function toogleCNIL() {
    if (cnil) {
      $(".cnil span.text").show();
      $(".cnil span.info").html("<i class=\"icon-minus-sign-alt\"></i> Réduire mes droits");
    }
    else {
      $(".cnil span.text").hide();
      $(".cnil span.info").html("<i class=\"icon-plus-sign-alt\"></i> Afficher mes droits");
    }
    cnil = !cnil;
  }
  
  /*
  check_login();
  check_password();
  check_confirm_password();
  */
  
  $("#login").keyup(function() {
    check_login();
  });
  $("#password").keyup(function() {
    check_password();
  });
  $("#confirm-password").keyup(function() {
    check_confirm_password();
  });
  $("#captcha").keyup(function() {
    check_captcha();
  });
  
  // cnil
  var cnil = false;
  toogleCNIL();
  $(".cnil span.info").click(function() {
    toogleCNIL();
  });

});
</script>
 ';
 ?>