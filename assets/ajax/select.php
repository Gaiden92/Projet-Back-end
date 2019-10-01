<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';


$result= $bdd->query("SELECT a.id_annonce, a.titre, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1
FROM annonce a, membre m, categorie c, photo p
WHERE (a.membre_id = m.id_membre)
AND (a.photo_id = p.id_photo)
AND a.categorie_id= '$_GET[id]' ");

$stmt = $pdo->query($query);
$annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/assets/includes/header.php';
?>
    
    <div class="card  mb-3" style="max-width: 540px;">     
      <div class="row no-gutters">
        <div class="col-md-4">
          <img src="assets/img/<?=$annonces['photo1']?>" class="card-img" alt="photo">
        </div>
        <div class="col-md-8">
          <div class="card-body">
        <h5 class="card-title"><?=$annonces['titreA']?></h5>
            <p class="card-text"><?=$annonces['description_courte']?></p>
            <p>Prix : <?=number_format($annonces['prix'], 2, ',', ' ');?>€</p>
            <p>avis</p>
          </div>
        </div>
      </div>
    </div>


</div>

<?php



include __DIR__ . '/assets/includes/footer.php';