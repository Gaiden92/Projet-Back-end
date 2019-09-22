<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';


$result= $bdd->query("SELECT a.id_annonce, a.titreA, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1
FROM annonce a, membre m, categorie c, photo p
WHERE (a.membre_id = m.id_membre)
AND (a.photo_id = p.id_photo)
AND a.categorie_id= '$categorie[id_categorie]' ");

$stmt = $pdo->query($query);
$annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/assets/includes/header.php';
?>


<?php foreach ($annonces as $annonce) : ?>
  
<div class="card  mb-3" >     
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






