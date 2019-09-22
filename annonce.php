<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';

// fiche_categorie.php?id=  //Recup ID
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare("SELECT a.id_annonce, a.titreA, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1, p.photo2, p.photo3, p.photo4, p.photo5
    FROM annonce a, membre m, categorie c, photo p
    WHERE a.id_annonce =:id
    AND a.categorie_id = c.id_categorie
    AND a.photo_id = p.id_photo
");
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    
    if ($resultat -> rowCount() > 0) {
        $annonce = $resultat -> fetch(PDO::FETCH_ASSOC);
        extract($annonce);
    }   
    
} else {
        alertMessage('danger', 'erreur annonce non valide / id non récupérer');
    
}




$page_title = 'Accueil'; 
include __DIR__ . '/assets/includes/header.php';
?>

  <h1 class="text-center"><?= nl2br(htmlspecialchars($annonce['titreA']))?></h1>        
  <?php include __DIR__ . '/assets/includes/flash.php'; ?>

  <div class="container-fluid annonce d-flex flex-row flex-wrap">
    <div class="photo col-4">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="assets/img/<?=$annonce['photo1'];?>" class="d-block w-100" alt="photo1">
                </div>
                <div class="carousel-item">
                <img src="assets/img/<?=$annonce['photo2'];?>" class="d-block w-100" alt="photo2">
                </div>
                <div class="carousel-item">
                <img src="assets/img/<?=$annonce['photo3'];?>" class="d-block w-100" alt="photo3">
                </div>
                <div class="carousel-item">
                <img src="assets/img/<?=$annonce['photo4'];?>" class="d-block w-100" alt="photo4">
                </div>
                <div class="carousel-item">
                <img src="assets/img/<?=$annonce['photo5'];?>" class="d-block w-100" alt="photo5">
                </div>
            </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>
    </div>

    <div class="col-8">
        <h5>Descritpion :</h5>
        <p class="card-text" style="text-align: justify;"><?= nl2br(htmlspecialchars($annonce['description_longue']))?></p>              
    </div>

    <div class="col d-flex justify-content-between">
        <p>Dâte de publication : <?=$annonce['date_enregistrement'];?></p>
        <p>avis</p>
        <p><span style="font-weight: bold;"><?=number_format($annonce['prix'], 2, ',', ' ');?>€</span></p>
        <p>Adresse : <?=$annonce['adresse'];?></p>
    </div>

  </div>

  <div class="container localisation"></div>

  <div class="container autresAnnonces"></div>


















  <?php
include __DIR__ . '/assets/includes/footer.php';