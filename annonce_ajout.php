<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';


debug($_POST);
debug($_FILES);
//recupérer les categories pour le selecteur
$resultat = $pdo -> query("SELECT * FROM categorie");
$categories = $resultat -> fetchAll();

//Traitement formulaire
if (isset($_POST['enregistrer']) || isset($_POST['modifier'])) {

    //verif titre
    if (empty($_POST['titreA']) || strlen($_POST['titreA']) > 255) {
        alertMessage('danger', 'Le titre doit contenir entre 1 et 255 caractères.');

    // Vérification descriptionCourte
    } elseif (empty($_POST['description_courte']) || strlen($_POST['description_courte']) > 255) {
        alertMessage('danger', 'Votre description doit contenir entre 1 & 255 caractères.');
        
    // Vérification descriptionLongue
    } elseif (empty($_POST['description_longue']) || strlen($_POST['description_longue']) > 2000) {
        alertMessage('danger', 'Votre description doit contenir entre 1 & 2000 caractères.');

    // Vérification prix
    } elseif (empty($_POST['prix']) || !is_numeric($_POST['prix'])) {
        alertMessage('danger', 'le prix doit contenir uniquement des chiffres.');

    // Vérification ville
    } elseif (empty($_POST['ville'])) {
        alertMessage('danger', 'ville non valide. ');
        
    // Vérification pays
    } elseif (empty($_POST['pays']) || is_numeric($_POST['pays'])) {
        alertMessage('danger', 'pays non valide. ');

    // Vérification adresse
    } elseif (empty($_POST['adresse']) || strlen($_POST['adresse']) > 50) {
        alertMessage('danger', 'adresse non valide. Elle ne doit pas contenir plus de 50 caractères. ');

    // Vérification CP
    } elseif (empty($_POST['cp']) || strlen($_POST['cp']) > 5 || !is_numeric($_POST['cp'])) {
        alertMessage('danger', 'Le code postal  ne doit contenir que 5 chiffres. ');

    ///////////////////////////////////////////////////////////////
    } elseif ($_FILES['photo1']['error'] !== UPLOAD_ERR_OK) {
        alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo1']['error']);
    } elseif ($_FILES['photo1']['size'] < 12 || exif_imagetype($_FILES['photo1']['tmp_name']) === false) {
        alertMessage('danger', 'Le fichier envoyé n\'est pas une image');
    ///////////////////////////////////////////////////////////////
    } elseif ($_FILES['photo2']['error'] !== UPLOAD_ERR_OK) {
        alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo2']['error']);
    } elseif ($_FILES['photo2']['size'] < 12 || exif_imagetype($_FILES['photo2']['tmp_name']) === false) {
        alertMessage('danger', 'Le fichier envoyé n\'est pas une image');
    ///////////////////////////////////////////////////////////////
    } elseif ($_FILES['photo3']['error'] !== UPLOAD_ERR_OK) {
        alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo3']['error']);
    } elseif ($_FILES['photo3']['size'] < 12 || exif_imagetype($_FILES['photo3']['tmp_name']) === false) {
        alertMessage('danger', 'Le fichier envoyé n\'est pas une image');
    ///////////////////////////////////////////////////////////////
    } elseif ($_FILES['photo4']['error'] !== UPLOAD_ERR_OK) {
        alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo2']['error']);
    } elseif ($_FILES['photo2']['size'] < 12 || exif_imagetype($_FILES['photo2']['tmp_name']) === false) {
        alertMessage('danger', 'Le fichier envoyé n\'est pas une image');
    ///////////////////////////////////////////////////////////////
    } elseif ($_FILES['photo5']['error'] !== UPLOAD_ERR_OK) {
        alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo5']['error']);
    } elseif ($_FILES['photo5']['size'] < 12 || exif_imagetype($_FILES['photo5']['tmp_name']) === false) {
        alertMessage('danger', 'Le fichier envoyé n\'est pas une image');
    //////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////OK on enregistre tout//////////////////////////////////////////////////////
   

 /////////////etape 1 - sil y a un id ds lurl alors on est modif
 //////////////////////////////////////////////////////////////////
    } else{
        if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
            //photo1
            if ($_FILES['photo1']['error'] === UPLOAD_ERR_OK) {
                $extension1 = pathinfo($_FILES['photo1']['name'], PATHINFO_EXTENSION);
                $path = __DIR__ . '/assets/img';

                do {
                    $filename = bin2hex(random_bytes(16));
                    $complete_path = $path . '/' . $filename . '.' . $extension1;
                } while (file_exists($complete_path));

                $upload = move_uploaded_file($_FILES['photo1']['tmp_name'], $complete_path);
                $new_file1 = $filename . '.' . $extension1;
                // Si okon supprime l'ancienne
                if ($upload) {
                    unlink(__DIR__ . '/assets/img/' . $photo1);
                }
            }
            /* S'il n'y a pas de nouvelle image
            } else {
            $upload = true;
            $new_file = $_POST['photo1'];
            }*/

            //photo2
            elseif ($_FILES['photo2']['error'] === UPLOAD_ERR_OK) {
                $extension2 = pathinfo($_FILES['photo2']['name'], PATHINFO_EXTENSION);
                $path = __DIR__ . '/assets/img';

                do {
                    $filename = bin2hex(random_bytes(16));
                    $complete_path = $path . '/' . $filename . '.' . $extension2;
                } while (file_exists($complete_path));

                $upload = move_uploaded_file($_FILES['photo2']['tmp_name'], $complete_path);
                $new_file2 = $filename . '.' . $extension2;
                // Si la nouvelle image est enregistrée, on supprime l'ancienne
                if ($upload) {
                    unlink(__DIR__ . '/assets/img/' . $photo2);
                }

                // S'il n'y a pas de nouvelle image
            } /*else {
                $upload = true;
                $new_file =$_POST['photo2'];
            }*/

            //photo3
            elseif ($_FILES['photo3']['error'] === UPLOAD_ERR_OK) {
                $extension3 = pathinfo($_FILES['photo3']['name'], PATHINFO_EXTENSION);
                $path = __DIR__ . '/assets/img';

                do {
                    $filename = bin2hex(random_bytes(16));
                    $complete_path = $path . '/' . $filename . '.' . $extension3;
                } while (file_exists($complete_path));

                $upload = move_uploaded_file($_FILES['photo3']['tmp_name'], $complete_path);
                $new_file3 = $filename . '.' . $extension3;
                // Si la nouvelle image est enregistrée, on supprime l'ancienne
                if ($upload) {
                    unlink(__DIR__ . '/assets/img/' . $photo3);
                }

                // S'il n'y a pas de nouvelle image
            } /*else {
                $upload = true;
                $new_file = $_POST['photo3'];
            }*/

            //photo4
            elseif ($_FILES['photo4']['error'] === UPLOAD_ERR_OK) {
                $extension4 = pathinfo($_FILES['photo4']['name'], PATHINFO_EXTENSION);
                $path = __DIR__ . '/assets/img';

                do {
                    $filename = bin2hex(random_bytes(16));
                    $complete_path = $path . '/' . $filename . '.' . $extension4;
                } while (file_exists($complete_path));

                $upload = move_uploaded_file($_FILES['photo4']['tmp_name'], $complete_path);
                $new_file4 = $filename . '.' . $extension4;
                // Si la nouvelle image est enregistrée, on supprime l'ancienne
                if ($upload) {
                    unlink(__DIR__ . '/assets/img/' . $photo4);
                }

                // S'il n'y a pas de nouvelle image
            } /*else {
                $upload = true;
                $new_file = $_POST['photo4'];
            }*/

            //photo5
            elseif ($_FILES['photo5']['error'] === UPLOAD_ERR_OK) {
                $extension5 = pathinfo($_FILES['photo5']['name'], PATHINFO_EXTENSION);
                $path = __DIR__ . '/assets/img';

                do {
                    $filename = bin2hex(random_bytes(16));
                    $complete_path = $path . '/' . $filename . '.' . $extension5;
                } while (file_exists($complete_path));

                $upload = move_uploaded_file($_FILES['photo5']['tmp_name'], $complete_path);
                $new_file5 = $filename . '.' . $extension5;
                // Si la nouvelle image est enregistrée, on supprime l'ancienne
                if ($upload) {
                    unlink(__DIR__ . '/assets/img/' . $photo5);
                }

                // S'il n'y a pas de nouvelle image
            } /*else {
                $upload = true;
                $new_file = $_POST['photo5'];
            }*/
        
            //enregistrement modif en bdd
            ////////////////////requete photo
            $req = $pdo->prepare(
                'UPDATE photo set 
                id_photo = :id_photo
                photo1 = :photo1, 
                photo2 = :photo2, 
                photo3= :photo3, 
                photo4 = :photo4, 
                photo5 = :photo5
            WHERE id_photo = :id_photo
                '
            );
            $req->bindParam(':id_photo', $_POST['photoID']);
            $req->bindValue(':photo1',  $new_file1 . '.' . $extension1);
            $req->bindValue(':photo2',  $new_file2 . '.' . $extension2);
            $req->bindValue(':photo3',  $new_file3. '.' . $extension3);
            $req->bindValue(':photo4',  $new_file4 . '.' . $extension4);
            $req->bindValue(':photo5',  $new_file5 . '.' . $extension5);
    
            $req->execute();
            //requete annonce
    
            $req3 = $pdo->prepare(
                'UPDATE annonce
                SET     
                    id_annonce =:id
                    titreA = :titreA, 
                    description_courte = :description_courte, 
                    description_longue = :description_longue, 
                    prix = :prix, 
                    photo_id = :photo_id, 
                    categorie_id = :categorie_id, 
                    pays = :pays, 
                    ville = :ville, 
                    adresse = :adresse, 
                    cp = :cp,
                    membre_id = :membre_id, 
                    date_enregistrement = :date_enregistrement
   
             WHERE id_annonce =:id

        ');

            $req3->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $req3->bindParam(':titreA', $_POST['titreA']);
            $req3->bindParam(':description_courte', $_POST['description_courte']);
            $req3->bindParam(':description_longue', $_POST['description_longue']);
            $req3->bindParam(':prix', $_POST['prix']);
         
            $req3->bindParam(':photo_id', $_POST['photoID'], PDO::PARAM_INT);

            $req3->bindParam(':categorie_id', $_POST['categorieID'], PDO::PARAM_INT);
            $req3->bindParam(':pays', $_POST['pays']);
            $req3->bindParam(':ville', $_POST['ville']);
            $req3->bindParam(':adresse', $_POST['adresse']);
            $req3->bindParam(':cp', $_POST['cp'], PDO::PARAM_INT);
            $req3->bindValue(':membre_id', getMember()['id_membre'], PDO::PARAM_INT);
            $req3->bindValue(':date_enregistrement', (new DateTime())->format('Y-m-d H:i:s'));
            $req3->execute();
            //Pour vider le formulaire
            //unset($_POST);
            alertMessage('success', 'Les modifications de votre annonces ont bien été enregistrées!');
            session_commit();
            header("location:index.php");
            
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////
        ////////////ETAPE 2 - Nouvelle annonce//////////////////////////////////////////////////////
        else {
            $extension1= pathinfo($_FILES['photo1']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename1 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename1 . '.' . $extension1;
            } while (file_exists($complete_path));

            if (!move_uploaded_file($_FILES['photo1']['tmp_name'], $complete_path)) {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }
            ///////////////
            $extension2 = pathinfo($_FILES['photo2']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename2 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename2 . '.' . $extension2;
            } while (file_exists($complete_path));
            if (!move_uploaded_file($_FILES['photo2']['tmp_name'], $complete_path)) {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }
            ///////////////
            $extension3 = pathinfo($_FILES['photo3']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename3 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename3 . '.' . $extension3;
            } while (file_exists($complete_path));
            if (!move_uploaded_file($_FILES['photo3']['tmp_name'], $complete_path)) {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }
            ///////////////
            $extension4 = pathinfo($_FILES['photo4']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename4 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename4 . '.' . $extension4;
            } while (file_exists($complete_path));
            if (!move_uploaded_file($_FILES['photo4']['tmp_name'], $complete_path)) {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }
            ///////////////
            $extension5 = pathinfo($_FILES['photo5']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename5 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename5 . '.' . $extension5;
            } while (file_exists($complete_path));
            if (!move_uploaded_file($_FILES['photo5']['tmp_name'], $complete_path)) {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }
    
            ////////////////////requete photo
            $req = $pdo->prepare(
                'INSERT INTO photo (photo1, photo2, photo3, photo4, photo5)
                VALUES (:photo1, :photo2, :photo3, :photo4, :photo5)
                '
            );
            $req->bindValue(':photo1', $filename1 . '.' . $extension1);
            $req->bindValue(':photo2', $filename2 . '.' . $extension2);
            $req->bindValue(':photo3', $filename3 . '.' . $extension3);
            $req->bindValue(':photo4', $filename4 . '.' . $extension4);
            $req->bindValue(':photo5', $filename5 . '.' . $extension5);
      
            $req->execute();

            $last_insert_id_photo = $pdo->lastInsertId();


            //requete annonce
            $req3 = $pdo->prepare(
                'INSERT INTO annonce (titreA, description_courte, description_longue, prix, photo_id, categorie_id, pays, ville, adresse, cp, membre_id, date_enregistrement)
            VALUES (:titreA, :description_courte, :description_longue, :prix, :photo_id, :categorie_id, :pays, :ville, :adresse, :cp, :membre_id, :date_enregistrement)'
            );
            $req3->bindParam(':titreA', $_POST['titreA']);
            $req3->bindParam(':description_courte', $_POST['description_courte']);
            $req3->bindParam(':description_longue', $_POST['description_longue']);
            $req3->bindParam(':prix', $_POST['prix']);
            $req3->bindParam(':photo_id', $last_insert_id_photo);
            $req3->bindParam(':categorie_id', $_POST['categorie']);
            $req3->bindParam(':pays', $_POST['pays']);
            $req3->bindParam(':ville', $_POST['ville']);
            $req3->bindParam(':adresse', $_POST['adresse']);
            $req3->bindParam(':cp', $_POST['cp'], PDO::PARAM_INT);
            $req3->bindValue(':membre_id', getMember()['id_membre'], PDO::PARAM_INT);
            $req3->bindValue(':date_enregistrement', (new DateTime())->format('Y-m-d H:i:s'));
            $req3->execute();
            //Pour vider le formulaire
            unset($_POST);
            alertMessage('success', 'Votre annonce a été enregistrer!');
            session_commit();
            header("location:index.php");
        
        }
    }
    }



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////modification anonce//////////////////////////////////////////////////////////////////////
//aperçu pour Modification 
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare("
    SELECT 
        a.*, 
        m.prenom, 
        c.*, 
        p.*
    FROM annonce a, membre m, categorie c, photo p
    WHERE a.id_annonce =:id
    AND a.membre_id = m.id_membre
    AND a.categorie_id = c.id_categorie
    AND a.photo_id = p.id_photo
    ");

    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    if ($resultat -> rowCount() > 0) {
        $annonce_a_modifier = $resultat -> fetch();
    }
}

    $titreA = (isset($annonce_a_modifier)) ? $annonce_a_modifier['titreA'] : '';
    $descC = (isset($annonce_a_modifier)) ? $annonce_a_modifier['description_courte'] : '';
    $descL = (isset($annonce_a_modifier)) ? $annonce_a_modifier['description_longue'] : '';
    $px = (isset($annonce_a_modifier)) ? $annonce_a_modifier['prix'] : '';
    $titre = (isset($annonce_a_modifier)) ? $annonce_a_modifier['titre'] : '';
    $categorieID = (isset($annonce_a_modifier)) ? $annonce_a_modifier['categorie_id'] : '';
    $photoID = (isset($annonce_a_modifier)) ? $annonce_a_modifier['photo_id'] : '';
    $photo1 = (isset($annonce_a_modifier)) ? $annonce_a_modifier['photo1'] : '';
    $photo2 = (isset($annonce_a_modifier)) ? $annonce_a_modifier['photo2'] : '';
    $photo3 = (isset($annonce_a_modifier)) ? $annonce_a_modifier['photo3'] : '';
    $photo4 = (isset($annonce_a_modifier)) ? $annonce_a_modifier['photo4'] : '';
    $photo5 = (isset($annonce_a_modifier)) ? $annonce_a_modifier['photo5'] : '';
    $pays = (isset($annonce_a_modifier)) ? $annonce_a_modifier['pays'] : '';
    $ville = (isset($annonce_a_modifier)) ? $annonce_a_modifier['ville'] : '';
    $adresse = (isset($annonce_a_modifier)) ? $annonce_a_modifier['adresse'] : '';
    $cp = (isset($annonce_a_modifier)) ? $annonce_a_modifier['cp'] : '';

/////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//affichage
$page_title = 'annonce'; 
include __DIR__ . '/assets/includes/header.php';
?>

    <?php if(isset($_GET['id'])) : ?>

        <h1 class="text-center">Modifier une annonce</h1>
        <p class="text-center">Veuillez modifier le formulaire ci-dessous </p>
    <?php else:?>
        <h1 class="text-center">Déposer une annonce</h1>
        <p class="text-center">Veuillez compléter le formulaire ci-dessous </p>

    <?php endif;?>



<div class="row  mt-4 p-4">
    <div class="col-md-6">
    <?php if(isset($_GET['id'])) : ?>
        <form action="annonce_ajout.php?id=<?= $_GET['id'];?>" method="post" enctype="multipart/form-data">
    <?php else:?>
        <form action="annonce_ajout.php" method="post" enctype="multipart/form-data">
    <?php endif;?>

    
				<div class="form-group">
					<label>Titre:</label>
					<input type="text" class="form-control" name="titreA" value="<?=$titreA?><?= $_POST['titreA'] ?? ''; ?>" />
                </div>
                
                <div class="form-group">
					<label>Description Courte :</label>
					<textarea class="form-control" name="description_courte"><?=$descC?><?= $_POST['description_courte'] ?? ''; ?></textarea>
                </div>
                
                <div class="form-group">
					<label>Description Longue:</label>
					<textarea class="form-control" name="description_longue"><?=$descL?><?= $_POST['description_longue'] ?? ''; ?></textarea>
				</div>
                
                <div class="form-group">
					<label>Prix :</label>
					<input type="text" class="form-control" name="prix" value="<?=$px?><?= $_POST['prix'] ?? ''; ?>"/>
                </div>
                
				<div class="form-group">
                    <label>Catégories:</label>
                
                        <input type="text" name="categorieID" value="<?=$categorieID?>"/>

                        <select name="categorie" id=categorie  class="form-control mb-2" aria-placeholder="categories"> 

                            <?php if(isset($_GET['id'])) : ?>
                                <option><?=$titre?></option>
                                <?php foreach($categories as $cat) : ?>   
                                    <option value="<?= $cat['id_categorie'] ?>">
                                    <?=$cat['titre']?>    
                                <?php endforeach;?>                                                
                                </option>

                            <?php else:?>
                                <?php foreach($categories as $cat) : ?>   
                                    <option value="<?= $cat['id_categorie'] ?>">
                                    <?=$cat['titre']?>    
                                <?php endforeach;?>                                        
                                </option>
                            <?php endif;?>  

                        </select>
                </div>		
              
            </div>
            
			<div class="col-md-6">
            <label>Photos :</label><br>
                <div class="form-group d-flex flex-wrap ">
                <?php if(isset($_GET['id'])) : ?>   

                <input type="text" name="photoID" value="<?=$photoID?>"/>  

                    <table class="table table-bordered table-striped table-hover">
                        <input type="text">
                        <tr class="text-center">
		                    <th class="col-4">Photo actuelle</th>
		                    <th>Choisir une nouvelle photo</th>
                        </tr>
		                <tr>      
                            <td><img src="assets/img/<?=$photo1?>" class="img-thumbnail" width=200 height=150></td>
                            <td><input type="file" name="photo1"/></td>           
                        </tr>
                        <tr>      
                            <td><img src="assets/img/<?=$photo2?>" class="img-thumbnail" width=200 height=150></td>
                            <td><input type="file" name="photo2"/></td>           
                        </tr>
                        <tr>      
                            <td><img src="assets/img/<?=$photo3?>" class="img-thumbnail" width=200 height=150></td>
                            <td><input type="file" name="photo3"/></td>           
                        </tr>
                        <tr>      
                            <td> <img src="assets/img/<?=$photo4?>" class="img-thumbnail" width=200 height=150></td>
                            <td><input type="file" name="photo4"/></td>           
                        </tr>
                        <tr>      
                            <td><img src="assets/img/<?=$photo5?>" class="img-thumbnail" width=200 height=150> </td>
                            <td><input type="file" name="photo5"/></td>           
		                </tr>
                    </table>
                 <?php else:?>        
                    <input type="file" class="form-control" name="photo1" />
                    <input type="file" class="form-control" name="photo2" />
                    <input type="file" class="form-control" name="photo3" />
                    <input type="file" class="form-control" name="photo4" />
                    <input type="file" class="form-control" name="photo5" />                 
                <?php endif;?>  
                </div>

				<div class="form-group">
					<label>Pays:</label>
					<input type="text" class="form-control" name="pays" value="<?=$pays?><?= $_POST['pays'] ?? ''; ?>" />
				</div>
							
				<div class="form-group">
					<label>Ville :</label>
					<input type="text" class="form-control" name="ville" value="<?=$ville?><?= $_POST['ville'] ?? ''; ?>"/>
				</div>
						
				<div class="form-group">
					<label>adresse :</label>
					<input type="text" class="form-control" name="adresse" value="<?=$adresse?><?= $_POST['adresse'] ?? ''; ?>"/>
				</div>
				
				<div class="form-group">
					<label>Code Postal :</label>
					<input type="text" class="form-control" name="cp" value="<?=$cp?><?= $_POST['cp'] ?? ''; ?>"/>
				</div>
						
            </div>	
          
            <?php if(isset($_GET['id'])) : ?>
                <div class="form-group col-md-6">
                    <input type="submit" class="btn btn-success col offset-6 mt-4" name="modifier" value="Modifier" />
                </div>
            <?php else :?>
                <div class="form-group col-md-6">
                    <input type="submit" class="btn btn-success col offset-6 mt-4" name="enregistrer" value="Enregistrer" />
                </div>
            <?php endif;?>   

            </form>  
         
</div> 
         
  
<?php

include __DIR__ . '/assets/includes/footer.php';