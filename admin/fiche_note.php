<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';

// fiche_note.php?id=
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    
    $resultat = $pdo -> prepare(
        'SELECT  n.id_note, n.membre_id1, n.membre_id2, n.etoile, n.avis, n.date_enregistrement, m1.id_membre, m1.email,   m2.id_membre, m2.email AS email2
            FROM note n
                inner join
                    membre m1
                    on n.membre_id1 = m1.id_membre
                inner join
                    membre m2
                    on n.membre_id2 = m2.id_membre
            ORDER BY n.id_note ASC'
    );
    
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    
    if ($resultat -> rowCount() > 0) {
        $note = $resultat -> fetch(PDO::FETCH_ASSOC);
        extract($note);
    }   
    
    } else {
        alertMessage('danger', 'erreur note non valide / id non récupérer');
    
    }

//enregistrement modification
if(isset($_POST['modifier'])){
    //Si la case note est vide
    if(empty($_POST['etoile'])) {
        alertMessage('danger', 'Veuillez indiquer une note.');

    //si la note contient des caractéres spéciaux interdit 
    } elseif(!preg_match('~^[0-5]+$~', $_POST['etoile'])) {
    alertMessage('danger', 'La note contient des caractères non-autorisés.');

    //si la note contient des caractéres spéciaux interdit
    } elseif(!preg_match('~^[0-5]$~', $_POST['etoile'])) {
        alertMessage('danger', 'La note dépasse la note maximale autorisé.');

    //si la case avis est vide
    } elseif(empty($_POST['avis'])) {
        alertMessage('danger', 'Veuillez indiquer un avis.');

    //Sinon si toutes les conditions sont remplies on envoie la requête
    } else {
        $resultat = $pdo->prepare(
            'UPDATE note
                SET avis= :avis, etoile= :etoile'
        );
        
        $resultat->bindParam(':avis', $_POST['avis']);
        $resultat->bindParam(':etoile', $_POST['etoile']);
       
        $resultat->execute();             
        alertMessage('success', 'La modification a été enregistré');
        session_commit();
        header("location:gestion_notes.php");  
                      
}

}


// Formulaire: supprimer un avis
if(isset($_POST['supprimer'])) {
    if(!isset($_POST['suppr'])) {
        alertMessage('danger','Veuillez cocher la case pour confirmer la suppression');
    }else{ 
        $req = $pdo -> prepare("DELETE FROM note WHERE id_note=:id " ); 
        $req->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
        $req->execute();
        alertMessage('success',"L'avis a bien été supprimé ");
        session_commit();
        header("location:gestion_notes.php");  
    }   
}

$page_title = 'Note'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>

<!------------afficher touts les avis-------------------------------------->
<?php include __DIR__ . '/../assets/includes/flash.php'; ?>
    <h2 class="text-center">Affichage de l'avis</h2>

        <table class="table table-bordered table-striped table-hover">
            <tr class="text-center">
                <th>ID commentaire</th>
                <th>id membre 1 </th>
                <th>id membre 2 </th>
                <th>Note</th>
                <th>Avis</th>
                <th>date_enregistrement</th>
            </tr>
            <tr>      
                <td><?= $_GET['id']; ?></td>
                <td><?=$note['membre_id1']. '-' . $note['email'];?></td>
                <td><?=$note['membre_id2']. '-'. $note['email2'];?></td>
                <td><?=$note['etoile'];?></td>
                <td><?=$note['avis']?></td>
                <td><?=$note['date_enregistrement']?></td>
            </tr>
        </table>

<!------------modifier un avis-------------------------------------->
<div class="col-md-6 offset-3">
    <?php include __DIR__ . '/../assets/includes/flash.php'; ?>

    <form action="fiche_note.php?id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data" >
        

            <div class="form-group">
                <label>ID note:</label>
                <input type="text" disabled class="form-control" name="id_note" value="<?=$note['id_note'];?>"/>
            </div> 

            <div class="form-group">
                <label>id membre 1</label>
                <input type="text" disabled value="<?=$note['membre_id1']?>" class="form-control" name="membre_id1">
            </div>

            <div class="form-group">
                <label>Id membre 2:</label>
                <input type="text" disabled value="<?=$note['membre_id2'];?>" class="form-control" name="membre_id2">
            </div>

            
            

            <div class="form-group">
                <label>Note:</label>
                    <select class="etoiles flex-row w-100" name="etoile">
                        <option type="text" value="1">*</option>
                        <option type="text" value="2">**</option>
                        <option type="text" value="3">***</option>
                        <option type="text" value="4">****</option>
                        <option type="text" value="5">*****</option>

                        
                    </select>
                    
            </div>
                

            <div class="form-group">
                <label>Avis:</label>
                <textarea type="text" class="form-control" name="avis"><?=$note['avis'];?></textarea>
            </div>

            <div class="form-group">
                <label>Date d'enregistrement:</label>
                <input type="text" value="<?=$note['date_enregistrement']?>" disabled class="form-control" type="text" name="date_enregistrement">
            </div>

        <input type="submit" class="btn btn-success" value="modifier" name="modifier"/>            
    </form>  

</div>

<!------------supprimer l'avis en entier-------------------------------------->
<h2 class="text-center mt-4">Supprimer l'avis</h2>
        <div class="col-md-6 offset-4">
            <form  method="post" action="fiche_note.php?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
                <input type="hidden" name="id_note" value="<?= $_GET['id'] ?>"/>
                    <div class="form-group form-check " >
                        <input type="checkbox" class="form-check-input" name="suppr" id="suppr"> 
                        <label for="supprimer" class="form-check-label">Je confirme vouloir supprimer</label><br>              
                    </div>
                <input type="submit" class="btn btn-danger" name='supprimer' value="supprimer"/>
    
            </form>
        </div>
  

<?php

include __DIR__ . '/../assets/includes/footer_admin.php';