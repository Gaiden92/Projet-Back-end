<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';

//affichage de ttes les annonces
$query = "SELECT a.id_annonce, a.titreA, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1
FROM annonce a, membre m, categorie c, photo p
WHERE (a.membre_id = m.id_membre)
AND (a.categorie_id = c.id_categorie)
AND (a.photo_id = p.id_photo)";

        $stmt = $pdo->query($query);
        $annonces = $stmt->fetchAll();


    //  affichage de select : par categories
    $query = 'SELECT titre FROM categorie';
    $stmt = $pdo->query($query);
    $categories = $stmt->fetchAll();

    // affichage de select : par villes
    $query2 = 'SELECT DISTINCT ville FROM annonce';
    $stmt = $pdo->query($query2);
    $villes = $stmt->fetchAll();

    // affichage de select : par membres
    $query3 = 'SELECT DISTINCT pseudo FROM membre';
    $stmt = $pdo->query($query3);
    $membres = $stmt->fetchAll();

$page_title = 'Accueil'; 
include __DIR__ . '/assets/includes/header.php';
?>

  <h1 class="text-center">Bienvenue sur SWAP !</h1>        
  <?php include __DIR__ . '/assets/includes/flash.php'; ?>


  <div class="container d-flex">
      <section class="col-4 select">

          <select  id="categorie" class="form-control mb-2">
            <option value="">Catégorie</option>
            <?php foreach ($categories as $categorie) : ?>
				      <option value="<?= $categorie['titre']?>"><?= $categorie['titre']?>
				      </option>
		        <?php endforeach; ?>
          </select>
      
          <select  id="region" class="form-control mb-2">
            <option value="">Région</option>
            <?php foreach ($villes as $ville) : ?>
				      <option value="<?= $ville['ville']?>"><?= $ville['ville']?>
				      </option>
		        <?php endforeach; ?>
          </select>

          <select  id="membre" class="form-control mb-2">
            <option value="">Membres</option>
            <?php foreach ($membres as $membre) : ?>
				      <option value="<?= $membre['pseudo']?>"><?= $membre['pseudo']?>
				      </option>
		        <?php endforeach; ?>
          </select>






      </section>
      
      <section class="col-8 annonces">
        <?php foreach ($annonces as $annonce) : ?>
            <div class="card  mb-3" style="max-width: 540px;">     
              <div class="row no-gutters">
                <div class="col-md-4">
                  <img src="assets/img/<?=$annonce['photo1']?>" class="card-img" alt="photo">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                <h5 class="card-title"><?=$annonce['titreA']?></h5>
                    <p class="card-text"><?=$annonce['description_courte']?></p>
                    <p>Prix : <?=number_format($annonce['prix'], 2, ',', ' ');?>€</p>
                    <p>avis</p>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach;?>
      </section>
  </div>


<?php
include __DIR__ . '/assets/includes/footer.php';