<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';

// fiche_commentaire.php?id=

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare("SELECT * FROM commentaire WHERE id_commentaire = :id");
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    
    if ($resultat -> rowCount() > 0) {
        $commentaire = $resultat -> fetch();
        extract($commentaire);
    }   
    
} else {
        alertMessage('danger', 'erreur');
    
}


//enregistrement modification
if(isset($_POST['modifier'])){
    //verif pseudo
    if(empty($_POST['motcles'])) {
        alertMessage('danger', 'Veuillez indiquer un commentaire.');

    } else
    {
      
            
      

        $resultat = $pdo->prepare(
            'UPDATE commentaire 
            SET id_commentaire=:id, motcles=:motcles
            WHERE id_commentaire=:id '
        );
            $resultat->bindParam(':id', $_POST['id_commentaire'], PDO::PARAM_INT);
            $resultat->bindParam(':motcles', $_POST['motcles']);
            $resultat->execute();             
            alertMessage('success', 'La modification a été enregistré');
            session_commit();
            header("location:gestion_commentaires.php");                      
    }
}
//aperçu pour Modification 
    if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
        $resultat = $pdo -> prepare("SELECT * FROM commentaire WHERE id_commentaire = :id");
        $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $resultat -> execute();
        if ($resultat -> rowCount() > 0) {
            $commentaire_a_modifier = $resultat -> fetch();           
        }
    }
    $id_commentaire = (isset($commentaire_a_modifier)) ? $commentaire_a_modifier['id_commentaire'] : '';
    $motcles = (isset($commentaire_a_modifier)) ? $commentaire_a_modifier['motcles'] : '';



// Formulaire: supprimer un commentaire
if(isset($_POST['supprimer'])) {
    if(!isset($_POST['suppr'])) {
        alertMessage('danger','Veuillez cocher la case pour confirmer la suppression d\'un commentaire');
    }else{ 
        $req = $pdo -> prepare("DELETE FROM commentaire WHERE id_commentaire=:id " ); 
        $req->bindParam(':id',  $_POST['id_commentaire'],PDO::PARAM_INT);
        $req->execute();
        alertMessage('success','Le commentaire a bien été supprimé ');
        session_commit();
        header("location:gestion_commentaires.php");  
    }   
}

$page_title = 'commentaire'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Commentaire</th>
        

	</tr>
		<tr>      
			<td><?= $_GET['id']; ?></td>
			<td><?= $commentaire['motcles'];?></td>
            


		</tr>
</table>

<!------------modifier le commentaire-------------------------------------->
<div class="col-md-6 offset-3">
    <?php include __DIR__ . '/../assets/includes/flash.php'; ?>

    <form action="fiche_commentaire.php?id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="id_commentaire" value="<?=$id_commentaire?>"/>

            <div class="form-group">
                <label>Id commentaire:</label>
                    <input type="text" class="form-control" name="id_commentaire" value="<?=$id_commentaire?>"/>            
            </div> 

            <div class="form-group">
                <label>Commentaire:</label>
                    <input type="text" class="form-control" name="motcles" value="<?=$motcles?>"/> 
            </div> 


            

            
        <input type="submit" class="btn btn-success" value="modifier" name="modifier"/>            
    </form>  
<!---------------suppr le commentaire----------->
    <form  method="post" action="fiche_commentaire.php?id=<?=$id_commentaire?>" enctype="multipart/form-data">
        <input type="hidden" name="id_commentaire" value="<?= $id_commentaire ?>"/>
            <div class="form-group form-check " >
                <input type="checkbox" class="form-check-input" name="suppr" id="suppr"> 
                <label for="supprimer" class="form-check-label">Je confirme vouloir supprimer</label><br>              
            </div>
        <input type="submit" class="btn btn-danger" name='supprimer' value="supprimer"/>
    
    </form>
</div>


<?php

include __DIR__ . '/../assets/includes/footer_admin.php';