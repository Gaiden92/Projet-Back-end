<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';
//debug($_POST);

    //affichage de ttes les annonces
    $query = 
    "SELECT 
      a.* 
      , m.*
      , p.*
      , c.*
    FROM annonce a
    LEFT JOIN membre m ON a.membre_id = m.id_membre
    LEFT JOIN photo p ON a.photo_id = p.id_photo
    LEFT JOIN categorie c ON a.categorie_id = c.id_categorie"; 
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


  <div class="container d-flex flex-wrap">
    
    <div class="col-12 offset-4">
      <form method="post" >
        <select name="tri" id="tri" class="col-6 form-control mb-2">  
        <option value="0"> -- options de tri --</option>
          <option value="1">trier par prix du moins cher au plus cher</option>
          <option value="2">trier par prix du plus cher au moins cher</option>
          <option value="3">trier par date de la plus ancienne à la plus récente</option>
          <option value="4">trier par date de la plus récente à la plus ancienne</option>
        </select>
      </form>
    </div>

    <section class="col-4 ">     
        <form method="post" >
          <label>Catégorie</label>       
            <select  id="categorie" class="form-control mb-2">
              <option value="0">Toutes les catégories</option>   
                <?php foreach ($categories as $categorie) : ?>
                  <option value="<?=$categorie['id_categorie'];?>"><?= $categorie['titre']?>
                  </option>
                <?php endforeach; ?>
            </select>  
        </form>
        <form method="post" >
          <label>Région</label>    
            <select  id="ville" class="form-control mb-2">
              <option value="">Toutes les villes</option>
                  <?php foreach ($villes as $ville) : ?>
                  <option value="<?= $ville['ville']?>"><?= $ville['ville']?>
                  </option>
                <?php endforeach; ?>
            </select>
        </form>
        <form method="post" >
          <label>Membre</label>    
            <select  id="membre" class="form-control mb-2">
              <option value="">Tous les membres</option>
                <?php foreach ($membres as $membre) : ?>
                  <option value="<?= $membre['pseudo']?>"><?= $membre['pseudo']?>
                  </option>
                <?php endforeach; ?>
            </select>
        </form>
        <form method="post" >           
            <div class="form-group">
              <label for="formControlRange">Prix</label>
              <input type="range" class="form-control-range" id="formControlRange" min="0" max="200000" step="1000" value="100" list="tickmarks">
              <datalist id="tickmarks">
                <option value="0" label="0€">
                <option value="20000">
                <option value="40000">
                <option value="60000">
                <option value="80000">
                <option value="100000" label="100000€">
                <option value="120000">
                <option value="140000">
                <option value="160000">
                <option value="180000">
                <option value="200000" label="200000€">
              </datalist>
              <div id="rangeprice" style="font-size:0.7em;color:red"></div>
            </div>      
        </form>
    </section>  

    <div class="col-8 annonces" id="details">    
      <?php foreach ($annonces as $annonce) : ?>
        <div class="card  mb-3" >     
          <div class="row no-gutters">         
            <div class="col-md-4">
              <img src="assets/img/<?=$annonce['photo1']?>" class="card-img" alt="photo">
            </div>
            <div class="col-md-8">
              <div class="card-body">
            <h5 class="card-title"><?=htmlspecialchars($annonce['titreA']);?></h5>
                <p class="card-text" style="text-align: justify; margin-bottom: 20px;"><?=htmlspecialchars($annonce['description_courte']);?></p>
                <p>avis</p>
                <p style="text-align: right; margin-bottom: 20px;"><span style="font-weight: bold;"> <?=number_format($annonce['prix'], 2, ',', ' ');?>€</span></p>           
              </div>
            </div>
          </div>
          <a href="annonce.php?id=<?= $annonce['id_annonce'] ?>" class="stretched-link"></a> 
        </div> 
      <?php endforeach;?>
      <hr>

    </div>
  </div>
<hr>


<?php
include __DIR__ . '/assets/includes/footer.php';