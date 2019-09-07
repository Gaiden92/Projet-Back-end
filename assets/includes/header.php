<?php
// Configuration
require_once __DIR__ . '/../config/configurationprincipale.php';


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
    $utilisateur = $req->fetch(PDO::FETCH_ASSOC);

    
    // Si on ne récupère rien ...
    if (!$utilisateur) {
      msgAlert('danger', 'Utilisateur inconnu.');

      // Si le mot de passe est incorrect ...
  } elseif (!password_verify($_POST['mdp'], $utilisateur['mdp'])) {
      msgAlert('danger', 'Mot de passe erroné.');

      // Sinon, connexion
  } else {
      // On ne garde pas le hash du mot de passe en session
      unset($utilisateur['mdp']);
      $_SESSION['utilisateur'] = $utilisateur;
      // On redirige
      header('Location: index.php');
  }
}


/* Déconnexion
if (isset($_GET['logout'])) {
    unset($_SESSION['utilisateur']);
    msgAlert('success', 'Vous avez bien été déconnecté.');
}
*/

?>


<!doctype html>
<html lang="fr">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta name="description" content=" ">
  <meta name="author" content="Svetlana & Samy">
  <meta name="robots" content="INDEX,FOLLOW">
  <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="icon" type="image/x-icon" href="">
  <title><?= $page_title ?> SWAP | Votre site de petites annonces</title>
  </head>
  <body>
      <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand d-md-none" href="#">Swap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                  <a class="nav-link" href="#">Swap <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">qui sommes nous</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">Contact</a>
              </li>
          </ul>
              <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Recherche</button>
              </form>
          <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle mr-auto" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Espace Membre</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <!-- Bouton modal connexion -->
                    <button type="button" class="btn" data-toggle="modal" data-target="#modalConnexion">
                      Connexion
                    </button>
                      <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Inscription</a>
                  </div>
              </li>
          </ul>     
      </div>
    </nav>

    <!------------------------------------------------------------------->
    <div class="row col-12">
      <div class="col-3">
        <h1>SWAP</h1>
        <p>Votre site de petites annonces en ligne</p>
      </div>
      <div class="offset-6 col-3">
        <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="#">Découvrir</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#">Se connecter</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="#">S'inscrire</a>
            </li>
        </ul>
      </div>
    </div>

    <!-- Modal connexion -->
    <div class="modal fade" id="modalConnexion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalConnexion">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">       

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
        </div>
      </div>
    </div>