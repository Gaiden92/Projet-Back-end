<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';

// fiche_annonce.php?id=
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare("SELECT a.id_annonce, a.titreA, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1, p.photo2, p.photo3, p.photo4, p.photo5
    FROM annonce a, membre m, categorie c, photo p
    WHERE a.id_annonce =:id
    AND a.categorie_id = c.id_categorie
    AND a.photo_id = p.id_photo
");
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    
    if ($resultat -> rowCount() > 0) {
        $annonce = $resultat -> fetch(PDO::FETCH_ASSOC);
        extract($annonce);
    }   
    
} else {
        alertMessage('danger', 'erreur annonce non valide / id non récupérer');
    
}

// Formulaire: supprimer une annponce
if(isset($_POST['supprimer'])) {
    if(!isset($_POST['suppr'])) {
        alertMessage('danger','Veuillez cocher la case pour confirmer la suppression');
    }else{ 
        $req = $pdo -> prepare("DELETE FROM annonce WHERE id_annonce=:id " ); 
        $req->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
        $req->execute();
        alertMessage('success',"L'annonce a bien été supprimé ");
        session_commit();
        header("location:gestion_annonces.php");  
    }   
}

$page_title = 'annonces'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>

<!------------aff de ttes les cat-------------------------------------->
<?php include __DIR__ . '/../assets/includes/flash.php'; ?>
    <h2 class="text-center">Affichage de l'annonce</h2>

        <table class="table table-bordered table-striped table-hover">
            <tr class="text-center">
                <th>ID</th>
                <th>titre</th>
                <th>description courte</th>
                <th>description longue</th>
                <th>prix</th>
                <th>photo1</th>
                <th>photo2</th>
                <th>photo3</th>
                <th>photo4</th>
                <th>photo5</th>
                <th>pays</th>
                <th>ville</th>
                <th>adresse</th>
                <th>cp</th>
                <th>membre</th>
                <th>catégorie</th>
                <th>date_enregistrement</th>
            </tr>
            <tr>      
                <td><?= $_GET['id']; ?></td>
                <td><?=$annonce['titreA']?></td>
                <td><?=$annonce['description_courte'];?></td>
                <td><?=$annonce['description_longue'];?></td>
                <td><?=number_format($annonce['prix'], 2, ',', ' ');?></td>
                <td><img src="../assets/img/<?=$annonce['photo1'];?>" class="img-thumbnail"><hr></td>
                <td><img src="../assets/img/<?=$annonce['photo2'];?>" class="img-thumbnail"><hr></td>
                <td><img src="../assets/img/<?=$annonce['photo3'];?>" class="img-thumbnail"><hr></td>
                <td><img src="../assets/img/<?=$annonce['photo4'];?>" class="img-thumbnail"><hr></td>
                <td><img src="../assets/img/<?=$annonce['photo5'];?>" class="img-thumbnail"><hr></td>
                <td><?=$annonce['pays'];?></td>
                <td><?=$annonce['ville'];?></td>
                <td><?=$annonce['adresse'];?></td>
                <td><?=$annonce['cp'];?></td>
                <td><?=$annonce['prenom'];?></td>
                <td><?=$annonce['titre'];?></td>
                <td><?=$annonce['date_enregistrement']?></td>
            </tr>
        </table>

<!------------modifier l'annonce-------------------------------------->
    <h2 class="text-center mt-4">Modifier l'annonce</h2>
        <div class="col-md-6 offset-4">
    
        <a class="btn btn-primary"  href="../annonce_ajout.php?id=<?= $_GET['id'] ?>" role="button">Modifier l'annonce</a>

    </div>

<!------------suppr l'annonce-------------------------------------->
<h2 class="text-center mt-4">Supprimer l'annonce</h2>
        <div class="col-md-6 offset-4">
      

        <form  method="post" action="fiche_annonce.php?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
        <input type="hidden" name="id_annonce" value="<?= $_GET['id'] ?>"/>
            <div class="form-group form-check " >
                <input type="checkbox" class="form-check-input" name="suppr" id="suppr"> 
                <label for="supprimer" class="form-check-label">Je confirme vouloir supprimer</label><br>              
            </div>
        <input type="submit" class="btn btn-danger" name='supprimer' value="supprimer"/>
    
    </form>

    </div>

 

    
</div>







<?php
//debug($_POST);
//debug($_FILES);
include __DIR__ . '/../assets/includes/footer_admin.php';
?>