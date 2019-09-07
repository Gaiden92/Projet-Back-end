<?php
// Configuration
require_once __DIR__ . '/assets/config/configurationprincipale.php';


// Traitement du formulaire name=login
if (isset($_POST['login'])) {
    // Récupérer l'utilisateur par son pseudo
    $req = $pdo->prepare(
        'SELECT *
        FROM membre
        WHERE
            pseudo = :pseudo'
    );
    $req->bindParam(':pseudo', $_POST['identifiant']);
    $req->execute();
    $membre = $req->fetch(PDO::FETCH_ASSOC);

    
    // Si on ne récupère rien ...
    if (!$membre) {
      alertMessage('danger', 'Utilisateur inconnu.');

      // Si le mot de passe est incorrect ...
  } elseif (!password_verify($_POST['mdp'], $membre['mdp'])) {
    alertMessage('danger', 'Mot de passe erroné.');

      // Sinon, connexion
  } else {
      // On ne garde pas le hash du mot de passe en session
      unset($membre['mdp']);
      $_SESSION['membre'] = $membre;
      // On redirige
      header('Location: index.php');
  }
}



if (isset($_GET['deconnexion'])) {
    unset($_SESSION['membre']);
    alertMessage('success', 'Vous avez bien été déconnecté.');
}




$page_title = 'Connexion'; 
include __DIR__ . '/assets/includes/header.php';
?>

    <div class="container border mt-4 p-4">
    <?php include __DIR__ . '/assets/includes/flash.php'; ?>
          
         

<form  method="post">
    <div class="form-group">
        <label>Pseudo</label>
        <input type="text" name="identifiant" class="form-control" value="<?= $_POST['identifiant'] ?? '' ?>">
    </div>

    <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="mdp" class="form-control">
    </div>

    <input type="submit" name="login" class="btn btn-primary" value="Connexion">
</form>

</div>

<?php

include __DIR__ . '/assets/includes/footer.php';