<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';

// fiche_commentaire.php?id=
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    
    $resultat = $pdo -> prepare(
        'SELECT c.id_commentaire, c.membre_id, c.motcles, c.annonce_id, c.date_enregistrement, m.id_membre, m.email, a.titreA
        FROM commentaire c, membre m, annonce a
        WHERE c.membre_id = m.id_membre
        AND c.annonce_id = a.id_annonce'
    );
    
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    
    if ($resultat -> rowCount() > 0) {
        $commentaire = $resultat -> fetch(PDO::FETCH_ASSOC);
        extract($commentaire);
    }   
    
    } else {
        alertMessage('danger', 'erreur commentaire non valide / id non récupérer');
    
    }

//Si le champs commentaire est vide
if (isset($_POST['modifier'])) {
    if(empty($_POST['motcles'])) {
        alertMessage('danger', 'Veuillez indiquer un nom.');
    }else{
        //Préparation de la requête
        $resultat = $pdo->prepare(
            'UPDATE commentaire
                SET motcles= :motcles'
        );
        $resultat->bindParam(':motcles', $_POST['motcles']);

        //execution de la requête
        $resultat->execute();             
        alertMessage('success', 'La modification a été enregistré');
        session_commit();                    
}

}


// Formulaire: supprimer un commentaire
if(isset($_POST['supprimer'])) {
    if(!isset($_POST['suppr'])) {
        alertMessage('danger','Veuillez cocher la case pour confirmer la suppression');
    }else{ 
        $req = $pdo -> prepare("DELETE FROM commentaire WHERE id_commentaire=:id " ); 
        $req->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
        $req->execute();
        alertMessage('success',"L'commentaire a bien été supprimé ");
        session_commit();
        header("location:gestion_commentaires.php");  
    }   
}

$page_title = 'commentaires'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>

<!------------afficher touts les commentaires-------------------------------------->
<?php include __DIR__ . '/../assets/includes/flash.php'; ?>
    <h2 class="text-center">Affichage du commentaire</h2>

        <table class="table table-bordered table-striped table-hover">
            <tr class="text-center">
                <th>ID commentaire</th>
                <th>id membre</th>
                <th>id annonce</th>
                <th>commentaire</th>
                <th>date_enregistrement</th>
            </tr>
            <tr>      
                <td><?= $_GET['id']; ?></td>
                <td><?=$commentaire['membre_id']?></td>
                <td><?=$commentaire['annonce_id'];?></td>
                <td><?=$commentaire['motcles'];?></td>
                <td><?=$commentaire['date_enregistrement']?></td>
            </tr>
        </table>

<!------------modifier un commentaire-------------------------------------->
<div class="col-md-6 offset-3">
    <?php include __DIR__ . '/../assets/includes/flash.php'; ?>

    <form action="fiche_commentaire.php?id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data" >
        
            <div class="form-group">
                <label>ID commentaire:</label>
                <input type="text" disabled class="form-control" name="annonce_id" value="<?=$commentaire['annonce_id'];?>"/>
            </div> 

            <div class="form-group">
                <label>id membre</label>
                <input type="text" disabled value="<?=$commentaire['membre_id']?>" class="form-control" name="membre_id">
            </div>

            <div class="form-group">
                <label>Commentaire:</label>
                <input type="text" value="<?=$commentaire['motcles'];?>" class="form-control" name="motcles">
            </div>

            <div class="form-group">
                <label>Date d'enregistrement:</label>
                <input type="text" value="<?=$commentaire['date_enregistrement']?>" disabled class="form-control" type="email" name="date_enregistrement">
            </div>

        <input type="submit" class="btn btn-success" value="modifier" name="modifier"/>            
    </form>  

</div>

<!------------suppr le commentaire-------------------------------------->
<h2 class="text-center mt-4">Supprimer le commentaire</h2>
        <div class="col-md-6 offset-4">
            <form  method="post" action="fiche_commentaire.php?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
                <input type="hidden" name="id_commentaire" value="<?= $_GET['id'] ?>"/>
                    <div class="form-group form-check " >
                        <input type="checkbox" class="form-check-input" name="suppr" id="suppr"> 
                        <label for="supprimer" class="form-check-label">Je confirme vouloir supprimer</label><br>              
                    </div>
                <input type="submit" class="btn btn-danger" name='supprimer' value="supprimer"/>
            </form>
        </div>



<?php

include __DIR__ . '/../assets/includes/footer_admin.php';