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

// recupérer les suggestions de produit : 

$query = "SELECT a.id_annonce, a.titreA, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1
FROM annonce a, membre m, categorie c, photo p
WHERE (a.membre_id = m.id_membre)
AND (a.categorie_id = c.id_categorie)
AND (a.photo_id = p.id_photo)
ORDER BY prix LIMIT 0,4";

$stmt = $pdo->query($query);
$suggestions = $stmt->fetchAll(PDO::FETCH_ASSOC);
extract($suggestions);

$page_title = 'Accueil'; 
include __DIR__ . '/assets/includes/header.php';
?>

  <h1 class="text-center"><?= nl2br(htmlspecialchars($annonce['titreA']))?></h1>        
  <?php include __DIR__ . '/assets/includes/flash.php'; ?>

  <div class="container-fluid annonce d-flex flex-row flex-wrap">
    <div class="photo col-5">
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

    <div class="col-7">
        <h5>Descritpion :</h5>
        <p class="card-text" style="text-align: justify;"><?= nl2br(htmlspecialchars($annonce['description_longue']))?></p>              
    </div>

    <div class="col d-flex justify-content-between">
        <p><i class="far fa-calendar-alt"></i> Dâte de publication : <?= (new DateTime($annonce['date_enregistrement']))->format('d/m/Y'); ?></p>


        <p><i class="far fa-user"></i> avis</p>
        <p><i class="fas fa-euro-sign"></i> <?=number_format($annonce['prix'], 2, ',', ' ');?>€</p>
        <p><i class="fas fa-map-marker-alt"></i> Adresse : <?=$annonce['adresse'];?></p>
    </div>

  </div>

  <div class="container-fluid localisation mb-4">
    <iframe width="100%" height="350" src="http://maps.google.fr/maps?q=<?=$annonce['adresse'];?>&amp;t=h&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" ></iframe>
  </div>

  <p class="text-center">Voir des autres annonces :</p>
  <hr>
  <div class="container-fluid autresAnnonces  d-flex flex-row justify-content-between">
    <?php foreach($suggestions as $sug) : ?>
        <div class="card m-4" style="width: 18rem; ">
            <img src="assets/img/<?=$sug['photo1']?>" class="card-img-top" alt="..."> 
            <a href="annonce.php?id=<?= $sug['id_annonce'] ?>" class="stretched-link"></a> 
        </div>
    <?php endforeach; ?>
  </div>
  <hr>
  <div class="container-fluid d-flex flex-row justify-content-between">
      <a href="#" class="text-decoration-none bg-light" style="color:black;">deposer un commentaire ou une note</a>
     <a href="index.php" class="text-decoration-none bg-light" style="color:black;">Retour vers les annonces</a>
  </div>

  <hr>




  <?php
include __DIR__ . '/assets/includes/footer.php';