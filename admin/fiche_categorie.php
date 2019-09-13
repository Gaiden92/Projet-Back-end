<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';

    $query = 'SELECT * FROM categorie';
    $stmt = $pdo->query($query);
    $details = $stmt->fetchAll();

// fiche_categorie.php?id=
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare("SELECT * FROM categorie WHERE id_categorie = :id");
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    
    if ($resultat -> rowCount() > 0) {
        $cat = $resultat -> fetch();
        extract($cat);
    }   
    
} else {
        alertMessage('danger', 'erreur');
    
}
//aperçu pour Modification 
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

//modification

if(isset($_POST['modifier'])){

    //verif titre
    if (empty($_POST['titre']) || strlen(empty($_POST['titre'])) > 255) 
    {
        alertMessage('danger', 'Le titre doit contenir entre 1 et 255 caractères.');

            // Vérification descriptionCourte
    }elseif(empty($_POST['motcles']) || strlen(empty($_POST['motcles'])) > 2000) 
    {
            alertMessage('danger', 'les mots clés ne doivent pas dépasser 2000 caractères.');
           
    }else
    {
        $resultat = $pdo->prepare(
            'UPDATE categorie 
            SET titre = :titre, mot = :motcles
            WHERE id_categorie = :id '
        );
            $resultat->bindParam(':id', $_POST['id_categorie'], PDO::PARAM_INT);
            $resultat->execute();
            alertMessage('success', 'La modification a été enregistré');
            header('Location: index.php');
            
    }
}




//suppression
if(isset($_POST['supprimer'])) {
    if(!isset($_POST['suppr'])) {
        alertMessage('danger','Veuillez cocher la case pour confirmer la suppression');
    }else{ 
        $req = $pdo -> prepare("DELETE FROM categorie WHERE id_categorie = :id " ); 
        $req->bindParam(':id',  $_GET['id_categorie'],PDO::PARAM_INT);
        $req->execute();


        alertMessage('success','La catégorie a bien été supprimé ');
        session_write_close();
        header("location:index.php");  
    }
     
}

$page_title = 'catégorie'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>titre</th>
		<th>mots</th>
	</tr>
		<tr>
       
			<td><?= $_GET['id']; ?></td>
			<td><?= $cat['titre'];?></td>
            <td><?= $cat['motcles']; ?></td>

		</tr>
</table>

<!-------------------------------------------------->

    <div class="col-md-6 offset-3">
    <?php include __DIR__ . '/../assets/includes/flash.php'; ?>

<form action="fiche_categorie.php?id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="id_categorie" value="<?= $id_produit ?>"/>
        <div class="form-group">
            <label>Titre:</label>
            <input type="text" class="form-control" name="titre" value="<?= $titre ?>"/>
        </div>
        
        <div class="form-group">
            <label>Mots clés :</label>
            <textarea class="form-control" name="motcles" value=""><?=$mots ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value="modifier" name="modifier"/>
      
	    </div>
       
</form>  

<form  method="post" action="fiche_categorie.php?id=<?=$id_categorie?>" enctype="multipart/form-data">
       
            <div class="form-group form-check " >
                <input type="checkbox" class="form-check-input" name="suppr" id="suppr"> 
                <label for="supprimer" class="form-check-label">Je confirme vouloir supprimer</label><br>              
            </div>
            <input type="submit" class="btn btn-danger" name='supprimer' value="supprimer"/>
    
    </form>
</div>


<?php

include __DIR__ . '/../assets/includes/footer_admin.php';