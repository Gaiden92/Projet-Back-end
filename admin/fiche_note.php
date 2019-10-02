<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';

// fiche_note.php?id=

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare("SELECT * FROM note WHERE id_note = :id");
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    
    if ($resultat -> rowCount() > 0) {
        $note = $resultat -> fetch();
        extract($note);
    }   
    
} else {
        alertMessage('danger', 'erreur');
    
}


//enregistrement modification
if(isset($_POST['modifier'])){
    //verif note
    if(empty($_POST['etoile'])) {
        alertMessage('danger', 'Veuillez indiquer une note.');

    //si l'avis est vide
    } elseif(empty($_POST['avis'])) {
        alertMessage('danger', 'Veuillez indiquer un avis.');


        //Sinon si toutes les conditions sont remplies on envoie la requête
    } else
    {
      

        $resultat = $pdo->prepare(
            'UPDATE note 
            SET id_note=:id, avis=:avis, etoile=:etoile
            WHERE id_note=:id '
        );
            $resultat->bindParam(':id', $_POST['id_note'], PDO::PARAM_INT);
            $resultat->bindParam(':avis', $_POST['avis']);
            $resultat->bindParam(':etoile', $_POST['etoile']);
            $resultat->execute();             
            alertMessage('success', 'La modification a été enregistré');
            session_commit();
            header("location:gestion_notes.php");                      
    }
}
//aperçu pour Modification 
    if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
        $resultat = $pdo -> prepare("SELECT * FROM note WHERE id_note = :id");
        $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $resultat -> execute();
        if ($resultat -> rowCount() > 0) {
            $note_a_modifier = $resultat -> fetch();           
        }
    }
    $id_note = (isset($note_a_modifier)) ? $note_a_modifier['id_note'] : '';
    $avis = (isset($note_a_modifier)) ? $note_a_modifier['avis'] : '';
    $etoile = (isset($note_a_modifier)) ? $note_a_modifier['etoile'] : '';


// Formulaire: supprimer la note
if(isset($_POST['supprimer'])) {
    if(!isset($_POST['suppr'])) {
        alertMessage('danger','Veuillez cocher la case pour confirmer la suppression d\'une note');
    }else{ 
        $req = $pdo -> prepare("DELETE FROM note WHERE id_note=:id " ); 
        $req->bindParam(':id',  $_POST['id_note'],PDO::PARAM_INT);
        $req->execute();
        alertMessage('success','La note a bien été supprimé ');
        session_commit();
        header("location:gestion_notes.php");  
    }   
}

$page_title = 'Note'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Note</th>
        <th>Avis</th>

	</tr>
		<tr>      
			<td><?= $_GET['id']; ?></td>
			<td><?= $note['etoile'];?></td>
            <td><?= $note['avis']; ?></td>


		</tr>
</table>

<!------------modifier la note-------------------------------------->
<div class="col-md-6 offset-3">
    <?php include __DIR__ . '/../assets/includes/flash.php'; ?>

    <form action="fiche_note.php?id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="id_note" value="<?=$id_note?>"/>

            <div class="form-group">
                <label>Note:</label>
                    <select name="etoile" value="<?=$etoile?>">
                        <option value="1">*</option>
                        <option value="2">**</option>
                        <option value="3">***</option>
                        <option value="4">****</option>
                        <option value="5">*****</option> 
                    </select>
            </div>

            <div class="form-group">
                <label>Avis:</label>
                    <input type="text" class="form-control" name="avis" value="<?=$avis?>"/> 

                
            </div> 


            

            
        <input type="submit" class="btn btn-success" value="modifier" name="modifier"/>            
    </form>  
<!---------------suppr la note----------->
    <form  method="post" action="fiche_note.php?id=<?=$id_note?>" enctype="multipart/form-data">
        <input type="hidden" name="id_note" value="<?= $id_note ?>"/>
            <div class="form-group form-check " >
                <input type="checkbox" class="form-check-input" name="suppr" id="suppr"> 
                <label for="supprimer" class="form-check-label">Je confirme vouloir supprimer</label><br>              
            </div>
        <input type="submit" class="btn btn-danger" name='supprimer' value="supprimer"/>
    
    </form>
</div>


<?php

include __DIR__ . '/../assets/includes/footer_admin.php';