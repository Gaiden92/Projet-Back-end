<!doctype html>
<html lang="fr">
  <head>
  <meta charset="UTF-8">
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
 
  <?php include __DIR__ . '/flash.php'; ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand d-md-none" href="#">Swap</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active"><a class="nav-link" href="#">Swap <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item"><a class="nav-link" href="#">qui sommes nous</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        </ul>
        <form action="search.php" method="get" class="form-inline">
          <input type="search" name="recherche" class="form-control mr-sm-2">
                <input type="submit" value="Rechercher" class="btn btn-outline-info my-2 my-sm-0">
          </form>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item  dropleft ">
              <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Espace Membre</a>
              <div class="dropdown-menu ">                 
                <?php if (getMember() === null) : ?>      
                 <a class="dropdown-item" href="connexion.php">Connexion</a>
                  <div class="dropdown-divider"></div><a class="dropdown-item" href="inscription.php">Inscription</a>
                <?php else: ?>
                 <a class="dropdown-item text-center font-weight-bold" href="profil.php">Bonjour <?=getMember()['pseudo']?> <br>Voir mon profil</a>
                 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="annonce_ajout.php">ajouter une annonce</a>
                 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="connexion.php?deconnexion">Déconnexion</a>
                    <?php if (statut(ROLE_ADMIN)) : ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="admin/">Back-Office</a>
                    <?php endif;?>
              <?php endif; ?>
              </div>
          </li>   
        </ul>
      </div>
    </nav>


