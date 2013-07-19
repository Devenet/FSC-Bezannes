<?php

use lib\content\Page;
use lib\content\Message;
use lib\content\Form;
use lib\users\UserAdmin;

$pageInfos = array(
 'name' => 'Nouvel utilisateur',
 'url' => _GESTION_.'/?page=users'
);
$page = new Page($pageInfos['name'], $pageInfos['url'], array($pageInfos));

$form = new Form('new-user', './?page=edit-users&amp;action=new', 'Ajouter', 'Nouvel utilisateur');

function redirect() {
  header ('Location: '. _GESTION_ .'/?page=users');
  exit;
}

if (isset($_GET['action'])) {
  
  switch (htmlspecialchars($_GET['action'])) {
    case 'new':
      if (isset($_POST) and $_POST != null) {
        $inputs = array(
          'name',
          'login',
          'password',
          'privilege'
        );
        foreach ($inputs as $input)
          $form->add($input, (isset($_POST[$input]) ? htmlspecialchars($_POST[$input]) : null));
        $u = new UserAdmin();
        try {
          
          if (! $u->setName(htmlspecialchars($_POST['name'])))
            throw new \Exception('Nom de l’utilisateur invalide');
          
          if (! $u->acceptLogin(htmlspecialchars($_POST['login'])))
            throw new \Exception('Ce courriel est déjà utilisé comme identifiant');
          
          if (! $u->setLogin(htmlspecialchars($_POST['login'])))
            throw new \Exception('Courriel invalide...');
          
          if (! $u->setPassword(htmlspecialchars($_POST['password']), 8))
            throw new \Exception('Mot de passe invalide (au moins 8 caractères)');

          if (! $u->setPrivilege(htmlspecialchars($_POST['privilege'])))
            throw new \Exception('Privilège incorrect !');
          
          if (! $u->create())
            throw new \Exception('Impossible d’ajouter le nouvel utilisateur');
          
          $u->create();
          $_SESSION['msg'] = new Message('L’utilisateur <em>'. $u->name() .'</em> a bien été créé :)', 1, 'Ajout réussi !');
          redirect();
        }
        catch (\Exception $e) {
          $_SESSION['form_msg'] = new Message($e->getMessage(), -1, 'Formulaire incomplet !');
        }
      }
      break;
    
    case 'delete':
      if (isset($_GET['login']) && $_GET['login'] != null) {
        $actual = $_SESSION['user']->id();

        try {
          if (! UserAdmin::isUser(htmlspecialchars($_GET['login'])))
            throw new \Exception('L’utilisateur n’existe pas !');

          $u = new UserAdmin(UserAdmin::getID(htmlspecialchars($_GET['login'])));
          $old = $u->id();
          if (! $u->delete(true))
            throw new \Exception('Impossible de supprimer l’utilisateur de la base.');

          $_SESSION['msg'] = new Message('L’utilisateur a bien été supprimé !', 1, 'Suppression réussie');

          if ($actual == $old) {
            $_SESSION['msg'] = new Message('Votre compte a bien été supprimé !', 1, 'Suppression réussie');
            header('Location: '. _GESTION_.'/login.php?logout&deleted');
            exit();
          }
        }
        catch (\Exception $e) {
          $_SESSION['msg'] = new Message($e->getMessage(), -1, 'Suppression impossible');
        }
      }
      redirect();
      break;
    
    default:
      redirect();
  }
  
}
else {
  redirect();
}

?>