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


//Modification 
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
  $resultat = $pdo -> prepare("SELECT * FROM categorie WHERE id_categorie = :id");
  $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $resultat -> execute();
  if ($resultat -> rowCount() > 0) {
      $produit_a_modifier = $resultat -> fetch();
  }
}
$titre = (isset($produit_a_modifier)) ? $produit_a_modifier['titre'] : '';
$mots = (isset($produit_a_modifier)) ? $produit_a_modifier['motcles'] : '';

$page_title = 'catégories'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>

<h2 class="text-center">Gestion des catégories</h2>
<?php include __DIR__ . '/../assets/includes/flash.php'; ?>

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
    

<a class="btn btn-primary" href="fiche_categorie.php?id=<?= $detail['id_categorie'] ?>" role="button"><i class="fa fa-eye" aria-hidden="true"></i></a>
<a class="btn btn-primary" href="fiche_categorie.php?id=<?= $detail['id_categorie'] ?>" role="button"><i class="far fa-edit" aria-hidden="true"></i></a>
<a class="btn btn-primary" href="fiche_categorie.php?id=<?= $detail['id_categorie'] ?>" role="button"><i class="far fa-trash-alt" aria-hidden="true"></i></a>


          
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
					<input type="text" class="form-control" name="titre" />
                </div>
                
                <div class="form-group">
					<label>Mots clés :</label>
					<textarea class="form-control" name="motcles" ></textarea>
                </div>

                <div class="form-group">
				<input type="submit" class="btn btn-success" name="enregistrer" value="Enregistrer" />
                </div>
               
        </form>  
    </div>
</div>



<?php

include __DIR__ . '/../assets/includes/footer_admin.php';