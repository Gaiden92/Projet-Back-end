<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';

// fiche_annonce.php?id=  //Recup ID
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare(
        "SELECT 
            a.*
            , m.*
            , p.* 
            , c.*
        FROM annonce a
        LEFT JOIN membre m ON a.membre_id = m.id_membre
        LEFT JOIN photo p ON a.photo_id = p.id_photo
        LEFT JOIN categorie c ON a.categorie_id = c.id_categorie       
            WHERE a.id_annonce =:id");

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

$resultat2 = $pdo -> prepare(
"SELECT 
a.*
, m.*
, p.* 
, c.*
FROM annonce a
LEFT JOIN membre m ON a.membre_id = m.id_membre
LEFT JOIN photo p ON a.photo_id = p.id_photo
LEFT JOIN categorie c ON a.categorie_id = c.id_categorie  

ORDER BY prix LIMIT 0,4");

 
    $resultat2 -> execute();
$suggestions = $resultat2->fetchAll(PDO::FETCH_ASSOC);
extract($suggestions);

$page_title = 'Accueil'; 
include __DIR__ . '/assets/includes/header.php';
?>

  <h1 class="text-center"><?= nl2br(htmlspecialchars($annonce['titreA']))?></h1>        
  <?php include __DIR__ . '/assets/includes/flash.php'; ?>

  <div class="container-fluid annonce d-flex flex-row flex-wrap">
    <div class="col-12 p-2 m-2 d-flex justify-content-between">
        <a href="index.php" class="text-decoration-none " style="color:black;">Retour vers les annonces</a>
        <button type="button" class="btn" data-toggle="modal" data-target="#contactMembre">Contacter <?=$annonce['pseudo'];?>
        </button>
    </div>

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


        <p><i class="far fa-user"></i> avis </p>
        <p><i class="fas fa-euro-sign"></i> <?=number_format($annonce['prix'], 2, ',', ' ');?>€</p>
        <p><i class="fas fa-map-marker-alt"></i> Adresse : <?=htmlspecialchars($annonce['adresse']);?></p>
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
      <a href="commentaire_ajout.php?id=<?= $_GET['id'] ?>" class="text-decoration-none bg-light" style="color:black;">D&eacute;poser un commentaire ou une note</a>
     <a href="index.php" class="text-decoration-none bg-light" style="color:black;">Retour vers les annonces</a>
  </div>

  <hr>

<!-- Modal contact membre-->
<div class="modal fade" id="contactMembre" tabindex="-1" role="dialog" aria-labelledby="contactMembreLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="contactMembreLabel">Contacter <?=$annonce['pseudo'];?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body m-4 p-4">
            <form id="contact" method="post" action="traitement_formulaire_contact.php">
                <fieldset class="text-center"><legend>Vos coordonnées</legend>
                    <p><label for="pseudo">Pseudo :</label><input type="text" id="pseudo" name="pseudo" value="<?=getMember()['pseudo'] ;?>"/></p>
                    <p><label for="email">Email :</label><input type="text" id="email" name="email" value="<?=getMember()['email'] ;?>"/></p>
                </fieldset>
            
                <fieldset class="text-center"><legend>Votre message :</legend>
                    <p><textarea id="message" name="message" cols="50" rows="8"></textarea></p>
                </fieldset>
                
                    <fieldset class="text-center"><legend>Concernant :</legend>
                    <p><?=$annonce['titreA'];?></p>
                    <p><img src="assets/img/<?=$annonce['photo1'];?>" class="img-thumbnail"></p>
                </fieldset>
            
                <div style="text-align:center;"><input type="submit" name="envoi" value="Envoyer le formulaire !" /></div>
            </form>
        </form>




    </div>
  </div>
</div>


  <?php
include __DIR__ . '/assets/includes/footer.php';