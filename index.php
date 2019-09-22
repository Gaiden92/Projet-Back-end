<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';

    //affichage de ttes les annonces
    $query = "SELECT a.id_annonce, a.titreA, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1
    FROM annonce a, membre m, categorie c, photo p
    WHERE (a.membre_id = m.id_membre)
    AND (a.categorie_id = c.id_categorie)
    AND (a.photo_id = p.id_photo)";

    $stmt = $pdo->query($query);
   $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);


    //  affichage de select : par categories
    $query = 'SELECT * FROM categorie';
    $stmt = $pdo->query($query);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // affichage de select : par villes
    $query2 = 'SELECT DISTINCT ville FROM annonce';
    $stmt = $pdo->query($query2);
    $villes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // affichage de select : par membres
    $query3 = 'SELECT DISTINCT pseudo FROM membre';
    $stmt = $pdo->query($query3);
    $membres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Accueil'; 
include __DIR__ . '/assets/includes/header.php';
?>

  <h1 class="text-center">Bienvenue sur SWAP !</h1>        
  <?php include __DIR__ . '/assets/includes/flash.php'; ?>


  <div class="container d-flex">
      <section class="col-4 select">
          
          <form method="post" >
          <label>Catégorie</label>
         
            <div class="form-inline my-2 my-lg-0">
            <select  id="categorie" class="form-control mb-2 col-10">  
              <option value="">Toutes les catégories</option>       
              <?php foreach ($categories as $categorie) : ?>
                <option value="<?=$categorie['id_categorie']?>"><?= $categorie['titre']?>
                </option>
              <?php endforeach; ?>
            </select>
            <!--<button type="submit" id="submit"  class= "col-2 mb-2 btn-sm form-inline btn-dark">Voir</button>-->
            </div>
          </form>

      
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


          <form>
            <div class="form-group">
              <label for="formControlRange">Example Range input</label>
              <input type="range" class="form-control-range" id="formControlRange">
            </div>
          </form>

     



      </section>
      
      <div class="col-8 annonces" id="detail" >

        <?php foreach ($annonces as $annonce) : ?>
  
            <div class="card  mb-3" style="max-width: 540px;">     
              <div class="row no-gutters">
              
                <div class="col-md-4">
                  <img src="assets/img/<?=$annonce['photo1']?>" class="card-img" alt="photo">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                <h5 class="card-title"><?=$annonce['titreA']?></h5>
                    <p class="card-text" style="text-align: justify; margin-bottom: 20px;"><?=$annonce['description_courte']?></p>
                    <p>avis</p>
                    <p style="text-align: right; margin-bottom: 20px;"><span style="font-weight: bold;"> <?=number_format($annonce['prix'], 2, ',', ' ');?>€</span></p>
                
                  </div>
                </div>
              </div>
              <a href="annonce.php?id=<?= $annonce['id_annonce'] ?>" class="stretched-link"></a> 
            </div>
        
            <?php endforeach;?>

     </div>

  </div>


<?php
include __DIR__ . '/assets/includes/footer.php';