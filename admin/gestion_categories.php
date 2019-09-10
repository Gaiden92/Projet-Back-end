<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';


if(isset($_POST['enregistrer'])){

    //verif titre
    if (empty($_POST['titre']) || strlen($_POST['titre']) > 255) 
    {
        alertMessage('danger', 'Le titre doit contenir entre 1 et 255 caractères.');

            // Vérification descriptionCourte
    }elseif(empty($_POST['motcles']) || strlen($_POST['motcles']) > 2000) 
    {
            alertMessage('danger', 'les mots clés ne doivent pas dépasser 2000 caractères.');
           
    }else{
        $req = $pdo->prepare( 
        'INSERT INTO categorie (titre, motcles)
        VALUES (:titre, :motcles)
        ');
         $req->bindParam(':titre', $_POST['titre']);
         $req->bindParam(':motcles', $_POST['motcles']);
         $req->execute();  

    }
}

$query = 'SELECT * FROM categorie';
$stmt = $pdo->query($query);
$details = $stmt->fetchAll();


$page_title = 'catégories'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>
<h2 class="text-center">Gestion des catégories</h2>


<!------------------------------------------------>
<table class="table table-bordered table-striped table-hover">
	<tr class="text-center">
		<th>ID</th>
		<th>Titre</th>
		<th>Mots clés</th>
	
		<th></th>
	</tr>
	<?php foreach ($details as $detail) : ?>
		<tr>
			<td><?= $detail['id_categorie'] ?></td>
			<td><?= $detail['titre'] ?></td>
			<td><?= $detail['motcles'] ?></td>

			<td>
                <button class="btn btn-info btn-categorie" data-id="<?= $detail['id_categorie'] ?>" data-toggle="modal" data-target="#categorie"><i class="fa fa-eye" aria-hidden="true"></i></button>

                <button class="btn btn-info btn-categorie" data-id="<?= $detail['id_categorie'] ?>" data-toggle="modal" data-target="#categorie_edit"><i class="far fa-edit"></i></button>

                <button class="btn btn-info btn-produit" data-id="<?= $detail['id_categorie'] ?>" data-toggle="modal" data-target="#categorie_suppr"><i class="far fa-trash-alt"></i></button>

          
			</td>
		</tr>
	<?php endforeach; ?>
</table>
<!------------------------------------>
<div class="row  mt-4 p-4">
    <div class="col-md-6 offset-3">

        <form action="gestion_categories.php" method="post" >

				<div class="form-group">
					<label>Titre:</label>
					<input type="text" class="form-control" name="titre"/>
                </div>
                
                <div class="form-group">
					<label>Mots clés :</label>
					<textarea class="form-control" name="motcles"></textarea>
                </div>

                <div class="form-group">
				<input type="submit" class="btn btn-success" name="enregistrer" value="Enregistrer" />
                </div>
               
        </form>  
    </div>
</div>


<!-- Modal 1 -->
<div class="modal fade" id="categorie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Détail produit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="details">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal 2 -->
<div class="modal fade" id="categorie_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="details">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal 3 -->
<div class="modal fade" id="categorie_suppr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Supprimer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="details">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


<?php

include __DIR__ . '/../assets/includes/footer_admin.php';