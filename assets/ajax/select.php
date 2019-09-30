<?php
require_once __DIR__ . '/../config/configurationprincipale.php';

                      function phperrshow($display="On",$log="On"){
                        ini_set('display_errors', $display);
                        ini_set('log_errors', $log);
                        ini_set('error_log', dirname(__FILE__).'/log.txt');
                        error_reporting(E_ALL);
                      }
                    //---------------------------------------------------------------------
                    // Afficher les erreurs à l'écran
                      ini_set('display_errors', 'On');
                      // Enregistrer les erreurs dans un fichier de log
                      ini_set('log_errors', "On");
                      // Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
                      ini_set('error_log', dirname(__FILE__).'/logty.txt');
                      // Afficher les erreurs et les avertissements
                      error_reporting(E_ALL);
                    //-----------------------------------------------------------------------------

    function AnnoncesSelectionnees($annonces,$voirplus=false){ //$voirplus est une option facultative
      $tab = array();
      $tab['resultat'] = '<div>'; 
      foreach ($annonces as $annonce) {
        $tab['resultat'] .= '<div class="card mb-3"><div class="row no-gutters"><div class="col-md-4"><img src="assets/img/'.$annonce['photo'].'"class="card-img" alt="photo">';
        $tab['resultat'] .=  '</div><div class="col-md-8"><div class="card-body">';
    
        $tab['resultat'] .=  '<h5 class="card-title">'.$annonce['titreA'].'</h5>';
      
        $tab['resultat'] .= ' <p class="card-text" style="text-align: justify; margin-bottom: 20px;">test pr la recup de la catégorie :'.$annonce['titre'].'</p>
    <p>avis</p>';
        $tab['resultat'] .='<p style="text-align: right; margin-bottom: 20px;"><span style="font-weight: bold;">'.$annonce['prix'].'€</span></p>';
        $tab['resultat'] .='</div></div></div>';
        $tab['resultat'] .=' <a href="annonce.php?id='.$annonce['id_annonce'].'" class="stretched-link"></a></div> ';
      }
      if($voirplus===true){
        //$tab['resultat'] .='<form method="post">';
        $tab['resultat'] .='<button id="voirplusbtn" class="btn col-12 ">Voir Plus</button>';
        //$tab['resultat'] .='</form>';
      }
      $tab['resultat'] .= '</div>'; 
      return $tab;
    }


    $response = array();
    //affichage de ttes les annonces par ID Catégories
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(isset($_POST['id']) && $_POST['id']!=='0') {
      //$tab['resultat']="cond1";
      //echo json_encode($tab);
      //exit();// 
      $offset=$_POST['offset'];
      $offset=(int)$offset;
      $resultat = $pdo -> prepare(
        "SELECT
          a.*
          , m.pseudo AS membre
          , p.photo1 AS photo
          , c.*
        FROM annonce a
        LEFT JOIN membre m ON a.membre_id = m.id_membre
        LEFT JOIN photo p ON a.photo_id = p.id_photo
        LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
        WHERE a.categorie_id = :id
      ");

        $resultat -> bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        $resultat -> execute();
        $nbreEnreng=$resultat->rowCount();
        $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
        
        if($nbreEnreng==2){ 
          $response=AnnoncesSelectionnees($annonces,true);
        }
        else{ 
          $response=AnnoncesSelectionnees($annonces);
        }
        echo json_encode($response);
        exit();
    }
    elseif(isset($_POST['id']) && $_POST['id']==='0') {
      $offset=$_POST['offset'];
      $offset=(int)$offset;
      $resultat = $pdo -> prepare(
        "SELECT 
          a.*
          , m.pseudo AS membre
          , p.photo1 AS photo
          , c.*
        FROM annonce a
        LEFT JOIN membre m ON a.membre_id = m.id_membre
        LEFT JOIN photo p ON a.photo_id = p.id_photo
        LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
      ");
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ 
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ 
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
    }    

       //affichage de ttes les annonces par villes
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   if(isset($_POST['ville']) && $_POST['ville']!=='Toutes les villes'){
    $offset=$_POST['offset'];
    $offset=(int)$offset;
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
        WHERE a.ville = :ville
        LIMIT {$offset},2 
    ");

      $resultat -> bindValue(':ville', $_POST["ville"]);
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ 
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ 
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
  }
  elseif(isset($_POST['ville']) && $_POST['ville']==='Toutes les villes'){
    $offset=$_POST['offset'];
    $offset=(int)$offset;
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
      LIMIT {$offset},2 
    ");
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ 
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ 
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
  }



      //affichage de ttes les annonces par prix
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   if(isset($_POST['prix'])){
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
        WHERE a.prix <= :prix
    ");

      $resultat -> bindValue(':prix', $_POST["prix"]);
      $resultat -> execute();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      $response=AnnoncesSelectionnees($annonces);
      echo json_encode($response);
      exit();
  }
  
      //affichage de ttes les annonces par membres
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   if(isset($_POST['membre']) && $_POST['membre']!=='Tous les membres'){
    $offset=$_POST['offset'];
    $offset=(int)$offset;
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
        WHERE m.pseudo= :membre
        LIMIT {$offset},2 
    ");
      $resultat -> bindValue(':membre', $_POST["membre"]);
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ 
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ 
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
  }
  elseif(isset($_POST['membre']) && $_POST['membre']==='Tous les membres'){
    $offset=$_POST['offset'];
    $offset=(int)$offset;
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
      LIMIT {$offset},2 
    ");
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ 
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ 
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
  }

        //affichage de ttes les annonces trier par prix 
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   if(isset($_POST['tri']) && $_POST['tri']==='trier par prix du moins cher au plus cher'){
     $offset=$_POST['offset'];
     $offset=(int)$offset; // je m'assure que offset est bien un int sinon ca va planter dans la clause limit
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
       ORDER BY a.prix ASC
       LIMIT {$offset},2 
    ");// j'ai rajouté la clause limit
   
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ // si j'ai 2 enreg alors je veux voir le bouton voir plus
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ // sinon je ne veux pas le voir
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
  }
  if(isset($_POST['tri']) && $_POST['tri']==='trier par prix du plus cher au moins cher'){
    $offset=$_POST['offset'];
    $offset=(int)$offset;
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
       ORDER BY a.prix DESC
       LIMIT {$offset},2 
    ");
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ 
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ 
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
  }

          //affichage de ttes les annonces trier par date
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   if(isset($_POST['tri']) && $_POST['tri']==='trier par date de la plus ancienne à la plus récente'){
    $offset=$_POST['offset'];
    $offset=(int)$offset;
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
       ORDER BY a.date_enregistrement ASC
       LIMIT {$offset},2 
    ");
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ 
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ 
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
  }
  if(isset($_POST['tri']) && $_POST['tri']==='trier par date de la plus récente à la plus ancienne'){
    $offset=$_POST['offset'];
    $offset=(int)$offset;
    $resultat = $pdo -> prepare(
      "SELECT 
        a.*
        , m.pseudo AS membre
        , p.photo1 AS photo
        , c.titre
      FROM annonce a
      LEFT JOIN membre m ON a.membre_id = m.id_membre
      LEFT JOIN photo p ON a.photo_id = p.id_photo
      LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
       ORDER BY a.date_enregistrement DESC
       LIMIT {$offset},2 
    ");
      $resultat -> execute();
      $nbreEnreng=$resultat->rowCount();
      $annonces = $resultat->fetchAll(PDO::FETCH_ASSOC);
      
      if($nbreEnreng==2){ 
        $response=AnnoncesSelectionnees($annonces,true);
      }
      else{ 
        $response=AnnoncesSelectionnees($annonces);
      }
      echo json_encode($response);
      exit();
  }