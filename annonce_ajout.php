<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';

//Traitement
if(isset($_POST['enregistrer'])  &&getMember() !== null){

    //verif titre
    if (empty($_POST['titre']) || strlen($_POST['titre']) > 255) 
    {
        alertMessage('danger', 'Le titre doit contenir entre 1 et 255 caractères.');

         // Vérification descriptionCourte
    }elseif(empty($_POST['descriptionCourte']) || strlen($_POST['descriptionCourte']) > 255) 
    {
        alertMessage('danger', 'Votre description doit contenir entre 1 & 255 caractères.');
      
        // Vérification descriptionLongue
    }elseif(empty($_POST['descriptionLongue']) || strlen($_POST['descriptionLongue']) > 2000)
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
    }elseif(empty($_POST['pays']) || !is_numeric($_POST['pays']))
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

    }else{
       //photo 	
		$photo1 = 'default.jpg';
		$photo2 = 'default.jpg';
		$photo3 = 'default.jpg';
        $photo4 = 'default.jpg';
        $photo5 = 'default.jpg';

        if ($_FILES['photo1']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['photo1']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/../assets/img';

            do {
                $filename = bin2hex(random_bytes(16));    
                $complete_path = $path . '/' . $filename . '.' . $extension;
    
            } while (file_exists($complete_path));

            $upload = move_uploaded_file($_FILES['photo1']['tmp_name'], $complete_path);
            $new_file = $filename . '.' . $extension;
            // Si la nouvelle image est enregistrée, on supprime l'ancienne
            if ($upload) {
                unlink(__DIR__ . '/../assets/img/' . $post['img']);
            }

        if ($_FILES['photo2']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['photo2']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/../assets/img';

            do {
                $filename = bin2hex(random_bytes(16));    
                $complete_path = $path . '/' . $filename . '.' . $extension;
    
            } while (file_exists($complete_path));

            $upload = move_uploaded_file($_FILES['photo2']['tmp_name'], $complete_path);
            $new_file = $filename . '.' . $extension;
            $req = $pdo->prepare(
                'INSERT INTO photo (photo2)
                VALUES (:photo2 )
                '
            );
            $req->bindValue(':photo2', $new_file);

        }    
        if ($_FILES['photo3']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['photo3']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/../assets/img';

            do {
                $filename = bin2hex(random_bytes(16));    
                $complete_path = $path . '/' . $filename . '.' . $extension;
    
            } while (file_exists($complete_path));

            $upload = move_uploaded_file($_FILES['photo3']['tmp_name'], $complete_path);
            $new_file = $filename . '.' . $extension;
            $req = $pdo->prepare(
                'INSERT INTO photo (photo3)
                VALUES (:photo3)
                '
            );
            $req->bindValue(':photo3', $new_file);

        }    
        if ($_FILES['photo4']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['photo4']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/../assets/img';

            do {
                $filename = bin2hex(random_bytes(16));    
                $complete_path = $path . '/' . $filename . '.' . $extension;
    
            } while (file_exists($complete_path));

            $upload = move_uploaded_file($_FILES['photo4']['tmp_name'], $complete_path);
            $new_file = $filename . '.' . $extension;
            $req = $pdo->prepare(
                'INSERT INTO photo (photo4)
                VALUES (:photo4 )
                '
            );
            $req->bindValue(':photo4', $new_file);

        }    
        if ($_FILES['photo5']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['photo5']['name'], PATHINFO_EXTENSION);
            $path = __DIR__ . '/../assets/img';

            do {
                $filename = bin2hex(random_bytes(16));    
                $complete_path = $path . '/' . $filename . '.' . $extension;
    
            } while (file_exists($complete_path));

            $upload = move_uploaded_file($_FILES['photo5']['tmp_name'], $complete_path);
            $new_file = $filename . '.' . $extension;
            $req = $pdo->prepare(
                'INSERT INTO photo (photo5)
                VALUES (:photo5)
                '
            );
            $req->bindValue(':photo5', $new_file);

        }    
       
    //}else{
        //categorie
        













        //enregistrement en bdd
    }else{
        $req = $pdo->prepare(
            'INSERT INTO annonce (titre, description_courte, description_longue, prix, pays, ville,
            adresse, cp, date_enregistrement)
            VALUES (:titre, :descriptionCourte, :descriptionLongue, :prix,: pays, :ville, :adresse, :cp, NOW())
            '
        );
        $req->execute(
            [
                'membre' => getMember()['id_membre'],
                'annonce' => $_POST['id_annonce'],              
            ]);
            alertMessage('success', 'Votre annonce a bien été enregistré.');
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
					<input type="text" class="form-control" name="titre" value="" />
                </div>
                
                <div class="form-group">
					<label>Description Courte :</label>
					<textarea class="form-control" name="descriptionCourte"></textarea>
                </div>
                
                <div class="form-group">
					<label>Description Longue:</label>
					<textarea class="form-control" name="descriptionLongue"></textarea>
				</div>
                
                <div class="form-group">
					<label>Prix :</label>
					<input type="text" class="form-control" name="prix" value=""/>
                </div>
                
				<div class="form-group">
					<label>Categorie :</label>
					<input type="text" class="form-control" name="categorie" value=""/>
				</div>		
            </div>
            
			<div class="col-md-6">
                <div class="form-group">
					<label>Photo :</label>
                	<input type="file" class="form-control" name="photo" multiple/>
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
				<input type="submit" class="btn btn-success" name="enregistrer"value="Enregistrer" />
            </div>
        

         </div>
    </form>  
<?php

include __DIR__ . '/assets/includes/footer.php';