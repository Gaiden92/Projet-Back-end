<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';

// 1 - enregistrement d'une nvl categorie
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
         alertMessage('success', 'La catégorie à été enregistré avec succès!');
    }
}
    // 2 - affichage de ttes les categorie
    $query = 'SELECT * FROM categorie';
    $stmt = $pdo->query($query);
    $details = $stmt->fetchAll();

    /* récupération des id categorie
    if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
        $resultat = $pdo -> prepare("SELECT * FROM categorie WHERE id_categorie = :id");
        $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $resultat -> execute();
        
        if ($resultat -> rowCount() > 0) {
            $cat = $resultat -> fetch();
            extract($cat);
        }   
        
    } else {
            alertMessage('danger', 'erreur id non récuperer');
        
    }
    //récupération des id categorie ds le modal
    


    //enregistrement modification
    if(isset($_POST['modifier'])){
        //verif titre
        if (empty($_POST['titre']) || strlen($_POST['titre']) > 255) 
        {
            alertMessage('danger', 'Le titre doit contenir entre 1 et 255 caractères.');

                // Vérification mots
        }elseif(empty($_POST['motcles']) || strlen($_POST['motcles']) > 2000) 
        {
                alertMessage('danger', 'les mots clés ne doivent pas dépasser 2000 caractères.');          
        }else
        {
            $resultat = $pdo->prepare(
                'UPDATE categorie 
                SET id_categorie=:id, titre=:titre, motcles=:motcles
                WHERE id_categorie=:id '
            );
                $resultat->bindParam(':id', $_POST['id_categorie'], PDO::PARAM_INT);
                $resultat->bindParam(':titre', $_POST['titre']);
                $resultat->bindParam(':motcles', $_POST['motcles']);
                $resultat->execute();             
                alertMessage('success', 'La modification a été enregistré');
                session_commit();
                header("location:gestion_categories.php");                      
        }
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

    // Formulaire: supprimer une cat
    if(isset($_POST['supprimer'])) {
        if(!isset($_POST['suppr'])) {
            alertMessage('danger','Veuillez cocher la case pour confirmer la suppression');
        }else{ 
            $req = $pdo -> prepare("DELETE FROM categorie WHERE id_categorie=:id " ); 
            $req->bindParam(':id',  $_POST['id_categorie'],PDO::PARAM_INT);
            $req->execute();
            alertMessage('success','La catégorie a bien été supprimé ');
            session_commit();
            header("location:gestion_categories.php");  
        }   
    }*/

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
        <!------------- affichage cat----------------------->
            <?php foreach ($details as $detail) : ?>
                <tr>
                    <td><?=$detail['id_categorie']?></td>
                    <td><?= htmlspecialchars($detail['titre']); ?></td>
                    <td><?= htmlspecialchars($detail['motcles']); ?></td>
                    <td>
                <!--        <button type="button" class="btn btn-primary detailsCategorie"  data-toggle="modal" data-target=".detailsCategorie" data-id="<?=$detail['id_categorie'];?>"><i class="fa fa-eye" aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-primary"data-id="<?= $detail['id_categorie'] ?>" data-toggle="modal" data-target=".editCategorie"><i class="far fa-edit" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-primary"data-id="<?= $detail['id_categorie'] ?>" data-toggle="modal" data-target=".supprCategorie"><i class="fa fa-trash-alt" aria-hidden="true"></i></button>-->

                        <a class="btn btn-primary" href="fiche_categorie.php?id=<?= $detail['id_categorie'] ?>" role="button"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a class="btn btn-primary" href="fiche_categorie.php?id=<?= $detail['id_categorie'] ?>" role="button"><i class="far fa-edit" aria-hidden="true"></i></a>
                        <a class="btn btn-primary" href="fiche_categorie.php?id=<?= $detail['id_categorie'] ?>" role="button"><i class="far fa-trash-alt" aria-hidden="true"></i></a>        
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

<!------------- enreg nvl cat----------------------->
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

<!----------------------modal1--------------------->
<div class="modal fade bd-example-modal-xl detailsCategorie" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsCategorie">Détails de la catégorie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!----------------------modal2--------------------->
<div class="modal fade bd-example-modal-xl editCategorie" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCategorie">Détails de la catégorie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


            <form action="gestion_categorie.php?id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="id_categorie" value="<?=$id_categorie?>"/>
                <div class="form-group">
                    <label>Titre:</label>
                    <input type="text" class="form-control" name="titre" value="<?= $titre?>"/>
                </div>       
                <div class="form-group">
                    <label>Mots clés :</label>
                    <textarea class="form-control" name="motcles"><?=$mots?></textarea>
                </div>   
                    
            </form>  
                </div>

            <div class="modal-footer">
            <input type="submit" class="btn btn-success" value="modifier" name="modifier"/>   
            </div>

    </div>
  </div>
</div>
<!----------------------modal3--------------------->
<div class="modal fade bd-example-modal-xl supprCategorie" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="supprCategorie">Détails de la catégorie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

    <form  method="post" action="fiche_categorie.php?id=<?=$id_categorie?>" enctype="multipart/form-data">
        <input type="hidden" name="id_categorie" value="<?= $id_categorie ?>"/>
            <div class="form-group form-check " >
                <input type="checkbox" class="form-check-input" name="suppr" id="suppr"> 
                <label for="supprimer" class="form-check-label">Je confirme vouloir supprimer</label><br>              
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-danger" name='supprimer' value="supprimer"/>
            </div>
        
    </form>
    </div>
  </div>
</div>

<?php
debug($_POST);
include __DIR__ . '/../assets/includes/footer_admin.php';
?>