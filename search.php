<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';
// Traitement

    ////////////////////////////////////////////////////////
$recherche = $_GET['recherche'] ?? '';

$req = $pdo->prepare(
    'SELECT 
    a.* 
    , m.*
    , p.*
    , c.*
    ,MATCH (c.titre, c.motcles) AGAINST (:recherche)  AS score
   /* MATCH (a.titreA, a.description_courte, a.description_longue) AGAINST (:recherche) */
    FROM annonce a
  LEFT JOIN membre m ON a.membre_id = m.id_membre
  LEFT JOIN photo p ON a.photo_id = p.id_photo
  LEFT JOIN categorie c ON a.categorie_id = c.id_categorie 

  HAVING score  > 0 
ORDER BY score DESC'
);
$req->bindParam(':recherche', $recherche);
$req->execute();

$resultats = $req->fetchAll(PDO::FETCH_ASSOC);



$page_title = 'Recherche: ' . $recherche; 
include __DIR__ . '/assets/includes/header.php';
?>
<h1 class="mb-4 text-center">Recherche: <?=htmlspecialchars($recherche); ?></h1>
    <div class="col-12 p-2 m-2">
        <a href="index.php" class="text-decoration-none bg-light" style="color:black;">Retour vers les annonces</a>
    </div>
  <div class="container d-flex flex-wrap">
        <div class="col-8 annonces offset-2" id="details">    
            <?php foreach ($resultats as $annonce) : ?>
                <div class="card  mb-3" >     
                <div class="row no-gutters">         
                    <div class="col-md-4">
                    <img src="assets/img/<?=$annonce['photo1']?>" class="card-img" alt="photo">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                    <h5 class="card-title"><?=htmlspecialchars($annonce['titreA']);?></h5>
                        <p class="card-text" style="text-align: justify; margin-bottom: 20px;"><?= htmlspecialchars($annonce['description_courte']);?></p>
                        <p>avis</p>
                        <p style="text-align: right; margin-bottom: 20px;"><span style="font-weight: bold;"> <?=number_format($annonce['prix'], 2, ',', ' ');?>€</span></p>           
                    </div>
                    </div>
                </div>
                <a href="annonce.php?id=<?= $annonce['id_annonce'] ?>" class="stretched-link"></a> 
                </div> 
         
            <hr>
            <p class="card-text">
                <small class="text-muted">
                    Correspondance avec la recherche:
                    <?= number_format(($annonce['score'] * 100), 2, '.', ' '); ?> %
                </small>
            </p>
            <?php endforeach;?>
        </div>
  </div>




















<?php
include __DIR__ . '/assets/includes/footer.php';