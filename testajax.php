

/////////////////////////////////////////////////////////////////////

<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';


$resultat = $pdo -> prepare('SELECT 
a.titreA as titreA
, a.description_courte 
, a.prix 
, m.pseudo AS membre
, p.photo1 AS photo
, c.titre  
FROM annonce a
LEFT JOIN membre m ON a.membre_id = m.id_membre
LEFT JOIN photo p ON a.photo_id = p.id_photo
LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
WHERE m.pseudo = ' . $_POST['id_membre'] .'
AND c.titre = '. $_POST['categorie_id'] .'
ORDER BY a.date_enregistrement DESC');

  $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $resultat -> bindParam(':id_categorie', $_POST['categorie_id'], PDO::PARAM_INT);
  $resultat -> execute();
  
  if ($resultat -> rowCount() > 0) {
      $annonces = $resultat -> fetchAll()(PDO::FETCH_ASSOC);
      extract($annonces);
  }else {
      alertMessage('danger', 'erreur annonce non valide / id non récupérer');
  
}

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


$(document).ready(function(){
    $('#categorie').change(function(event){
        //event.preventDefault();
        var id = $('#categorie').val(); // on récupère le contenu de l'attribut "value" du selecteur, donc l'id de l'employé
        console.log(id);

        var categorie = $('#categorie option:selected').text(); // on récupère la valeur entre les balises '<option>'
        console.log(categorie); 

        var parameters = "id="+id+"&categorie="+categorie; // on définit les paramètres a envoyés avec la requete AJAX "aller" | on transmet à la requete à la fois l'id et la cat 
        // le signe "&" permet d'ajouter des paramètres à la requete AJAX "aller"
        console.log(categorie);
        
        $.post("assets/ajax/select.php", parameters, function(data,status){
            console.log(status);
            console.log(data.resultat);
            $('#details').html(data.resultat); // on remplace le selecteur de la page index.php par le selecteur que nous avons mis à jour dans le fichier ajax2.php
        }, 'json');
    });
        
});


$query =
    "SELECT a.*, m.prenom, c.titre, p.photo1, p.*
    FROM annonce a
    LEFT JOIN membre m ON a.membre_id = m.id_membre
    LEFT JOIN photo p ON a.photo_id = p.id_photo
    LEFT JOIN categorie c ON a.categorie_id = c.id_categorie
     WHERE a.categorie_id = '$_POST[id_categorie]'
      AND a.photo_id = p.id_photo";
        
  $stmt = $pdo->query($query);
  $annonces = $stmt->fetch(PDO::FETCH_ASSOC);

  //on redéclare nos annonces
  $tab['resultat'] = '<div class="card mb-3"><div class="row no-gutters"><div class="col-md-4">'; 

      $tab['resultat'] .= '<img src="" class="card-img" alt="photo">';
      $tab['resultat'] .=  '</div><div class="col-md-8"><div class="card-body">';
      foreach ($annonces as $cat) {
          $tab['resultat'] .=  '<h5 class="card-title">'.$cat['titreA'].'</h5>';
      }
      $tab['resultat'] .= ' <p class="card-text" style="text-align: justify; margin-bottom: 20px;"></p>
    <p>avis</p>';
      $tab['resultat'] .='<p style="text-align: right; margin-bottom: 20px;"><span style="font-weight: bold;">€</span></p>';
      $tab['resultat'] .='</div></div></div>';
      $tab['resultat'] .=' <a href="" class="stretched-link"></a> ';
  
  

    $tab['resultat'] .= '</div>';

    echo json_encode($tab);
}else{
  alertMessage('danger',"Il n'y a aucune annonce dans cette catégorie");
}


