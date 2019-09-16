<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';


debug($_POST);
debug($_FILES);
//recupérer les categories
$resultat = $pdo -> query("SELECT * FROM categorie");
$categories = $resultat -> fetchAll();

//Traitement formulaire
if(isset($_POST['enregistrer'])){

    //verif titre
    if (empty($_POST['titreA']) || strlen($_POST['titreA']) > 255) 
    {
        alertMessage('danger', 'Le titre doit contenir entre 1 et 255 caractères.');

            // Vérification descriptionCourte
        }elseif(empty($_POST['description_courte']) || strlen($_POST['description_courte']) > 255) 
        {
            alertMessage('danger', 'Votre description doit contenir entre 1 & 255 caractères.');
        
            // Vérification descriptionLongue
        }elseif(empty($_POST['description_longue']) || strlen($_POST['description_longue']) > 2000)
        {
            alertMessage('danger', 'Votre description doit contenir entre 1 & 2000 caractères.');

            // Vérification prix
        }elseif(empty($_POST['prix']) || !is_numeric($_POST['prix']))
        {
            alertMessage('danger', 'le prix doit contenir uniquement des chiffres.');

            // Vérification ville
        }elseif(empty($_POST['ville']) )
        {
            alertMessage('danger', 'ville non valide. ');
        
            // Vérification pays
        }elseif(empty($_POST['pays']) || is_numeric($_POST['pays']))
        {
            alertMessage('danger', 'pays non valide. ');

            // Vérification adresse
        }elseif(empty($_POST['adresse']) || strlen($_POST['adresse']) > 50)
        {
            alertMessage('danger', 'adresse non valide. Elle ne doit pas contenir plus de 50 caractères. ');

            // Vérification CP
        }elseif(empty($_POST['cp']) || strlen($_POST['cp']) > 5 || !is_numeric($_POST['cp']) )
        {
            alertMessage('danger', 'Le code postal  ne doit contenir que 5 chiffres. ');

      


///////////////////////////////////////////////////////////////
        }elseif($_FILES['photo1']['error'] !== UPLOAD_ERR_OK) 
        {
            alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo1']['error']);

        } elseif ($_FILES['photo1']['size'] < 12 || exif_imagetype($_FILES['photo1']['tmp_name']) === false) 
        {
            alertMessage('danger', 'Le fichier envoyé n\'est pas une image');
///////////////////////////////////////////////////////////////
        }elseif ($_FILES['photo2']['error'] !== UPLOAD_ERR_OK) 
        {
            alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo2']['error']);
        } elseif ($_FILES['photo2']['size'] < 12 || exif_imagetype($_FILES['photo2']['tmp_name']) === false) 
        {
            alertMessage('danger', 'Le fichier envoyé n\'est pas une image');
  ///////////////////////////////////////////////////////////////
        }elseif ($_FILES['photo3']['error'] !== UPLOAD_ERR_OK) 
        {
            alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo3']['error']);
        } elseif ($_FILES['photo3']['size'] < 12 || exif_imagetype($_FILES['photo3']['tmp_name']) === false) 
        {
            alertMessage('danger', 'Le fichier envoyé n\'est pas une image');   
///////////////////////////////////////////////////////////////
        }elseif ($_FILES['photo4']['error'] !== UPLOAD_ERR_OK) 
        {
            alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo2']['error']);
        } elseif ($_FILES['photo2']['size'] < 12 || exif_imagetype($_FILES['photo2']['tmp_name']) === false) 
        {
            alertMessage('danger', 'Le fichier envoyé n\'est pas une image');   
///////////////////////////////////////////////////////////////
        }elseif ($_FILES['photo5']['error'] !== UPLOAD_ERR_OK) 
        {
            alertMessage('warning', 'Problème lors de l\'envoi du fichier. Code ' . $_FILES['photo5']['error']);
        } elseif ($_FILES['photo5']['size'] < 12 || exif_imagetype($_FILES['photo5']['tmp_name']) === false) 
        {
            alertMessage('danger', 'Le fichier envoyé n\'est pas une image');  

///////////////////////OK on enregistre tout//////////////////////////////////
} else {
            $extension1= pathinfo($_FILES['photo1']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename1 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename1 . '.' . $extension1;
            } while (file_exists($complete_path));

            if (!move_uploaded_file($_FILES['photo1']['tmp_name'], $complete_path)) 
            {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }    
                ///////////////
            $extension2 = pathinfo($_FILES['photo2']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename2 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename2 . '.' . $extension2;
            } while (file_exists($complete_path));
            if (!move_uploaded_file($_FILES['photo2']['tmp_name'], $complete_path)) 
            {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }   
            ///////////////
            $extension3 = pathinfo($_FILES['photo3']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename3 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename3 . '.' . $extension3;
            } while (file_exists($complete_path));
            if (!move_uploaded_file($_FILES['photo3']['tmp_name'], $complete_path)) 
            {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }   
            ///////////////
            $extension4 = pathinfo($_FILES['photo4']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename4 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename4 . '.' . $extension4;
            } while (file_exists($complete_path));
            if (!move_uploaded_file($_FILES['photo4']['tmp_name'], $complete_path)) 
            {
                alertMessage('danger', 'L\'image n\'a pas pu être enregistrée.');
            }    
            ///////////////
            $extension5 = pathinfo($_FILES['photo5']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/assets/img';
            do {
                $filename5 = bin2hex(random_bytes(16));
                $complete_path = $path . '/' . $filename5 . '.' . $extension5;
            } while (file_exists($complete_path));
            if (!move_uploaded_file($_FILES['photo5']['tmp_name'], $complete_path)) 
            {
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

            // ICI ON VIENT D'AJOUTER LES PHOTOS CORRESPONDANTES A L'ANNONCE
            // IL FAUT PILE POIL A CE MOMENT RECUPERER L'ID DE LA 'LIGNE' PHOTO

            // CETTE REQUETE RECUPERE LE TOUT DERNIER ID GENERE (DU COUP CELUI DES PHOTOS)
            // ON ENREGISTRE L'ID DANS LA VARIABLE $last_insert_id_photo (enfin libre à vous de modifier le nom ;)
            $last_insert_id_photo = $pdo->lastInsertId();

            /**
             * 
             * PAS BESOIN DE CREER LA CATEGORIE : ELLE EXISTE DEJA
             * -> LE SEUL ENDROIT OU ON AJOUTE/SUPPRIME UNE CATEGORIE EST DANS LE BACKOFFICE
             *      A LA GESTION DES CATEGORIES
             */
            // //////////////////////////requete categorie
            // $req2 = $pdo->prepare(
            //     'INSERT INTO categorie
            //     SELECT categorie_id
            //     FROM CATEGORIE
            //     WHERE id_categorie=' . $_POST["categorie"]
                
            // );
            // $req2->bindParam(':categorie', $_POST['categorie']);
            // $req2->execute();




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
    
   
    }  

}

//affichage
$page_title = 'ajout annonce'; 
include __DIR__ . '/assets/includes/header.php';
?>


<h1 class="text-center">Déposer une annonce</h1>
<p class="text-center">Veuillez compléter le formulaire ci-dessous </p>

<div class="row  mt-4 p-4">
    <div class="col-md-6">
        <form action="annonce_ajout.php" method="post" enctype="multipart/form-data">
       

				<div class="form-group">
					<label>Titre:</label>
					<input type="text" class="form-control" name="titreA" value="" />
                </div>
                
                <div class="form-group">
					<label>Description Courte :</label>
					<textarea class="form-control" name="description_courte"></textarea>
                </div>
                
                <div class="form-group">
					<label>Description Longue:</label>
					<textarea class="form-control" name="description_longue"></textarea>
				</div>
                
                <div class="form-group">
					<label>Prix :</label>
					<input type="text" class="form-control" name="prix" value=""/>
                </div>
                
				<div class="form-group">
                    <label>Catégories:</label>
                    <select name="categorie" id=categorie  class="form-control mb-2" aria-placeholder="categories">
                        <?php foreach($categories as $cat) : ?>           
                            <option value="<?= $cat['id_categorie'] ?>"><?= ucfirst($cat['titre']); ?></option>
                        <?php endforeach;?>
                    </select>
                </div>		
                
            </div>
            
			<div class="col-md-6">
                <div class="form-group">
                    <label>Photo :</label><br>
                    
                	<input type="file" class="form-control" name="photo1"/>
        	
					<input type="file" class="form-control" name="photo2"/>

                	<input type="file" class="form-control" name="photo3"/>
		
					<input type="file" class="form-control" name="photo4"/>

                	<input type="file" class="form-control" name="photo5"/>
                </div>
				<div class="form-group">
					<label>Pays:</label>
					<input type="text" class="form-control" name="pays" value=""/>
				</div>
							
				<div class="form-group">
					<label>Ville :</label>
					<input type="text" class="form-control" name="ville" value=""/>
				</div>
						
				<div class="form-group">
					<label>adresse :</label>
					<input type="text" class="form-control" name="adresse" value=""/>
				</div>
				
				<div class="form-group">
					<label>Code Postal :</label>
					<input type="text" class="form-control" name="cp" value=""/>
				</div>
						
            </div>	

            <div class="form-group">
				<input type="submit" class="btn btn-success" name="enregistrer" value="Enregistrer" />
            </div>
        

         </div>
    </form>  
<?php

include __DIR__ . '/assets/includes/footer.php';