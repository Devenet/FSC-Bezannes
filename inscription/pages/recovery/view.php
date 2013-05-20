<div class="row">
  <div class="span8 offset2">

<?php

if (isset($content))
  echo $content;

else {
?>

  <div class="alert">
    Merci d’indiquer votre nom d’utilisateur.
    <br />Un email contenant un lien pour réinitialiser votre mot de passe vous sera envoyé.
  </div>


  <form class="form-horizontal espace-top" action="recovery" method="post">

    <div class="control-group">
      <label class="control-label" for="user">Courriel</label>
      <div class="controls">
        <div class="input-prepend">
          <span class="add-on"><i class="icon-envelope"></i></span>
          <input type="text" name="user" id="user" class="input-large"  autofocus />
        </div>
      </div>
    </div>
  
    <div class="form-actions">
      <input type="submit" class="btn btn-primary" value="Envoyer" /> 
    </div>

  </form> 

<?php
}
?>

  </div>
</div>