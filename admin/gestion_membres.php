<?php 

    require_once __DIR__ . '/../assets/config/configurationprincipale.php';

    $page_title = 'Profil'; 
    require_once __DIR__ . '/../assets/includes/header_admin.php';
    
?>

<?php //Traitement du formulaire

    if (isset($_POST['enregistrement'])) {
        //Si le pseudo existe déja
        if (getMemberBy($pdo, 'pseudo', $_POST['pseudo']) !== null) {
            alertMessage('danger', 'Ce pseudo est déjà pris.');
    
        //si le pseudo est est inférieur à 3 ou et supérieur à 25 caractéres 
        } elseif(strlen($_POST['pseudo']) < 3 || strlen($_POST['pseudo']) > 25) {
            alertMessage('danger', 'Le pseudo doit contenir entre 3 et 25 caractères.');

        //si le pseudo contient des caractéres interdit
        } elseif(!preg_match('~^[a-zA-Z0-9_-]+$~', $_POST['pseudo'])) {
            alertMessage('danger', 'Le pseudo contient des caractères non-autorisés.');

        //si la case "nom" est vide
        } elseif(empty($_POST['nom'])) {
            alertMessage('danger', 'Veuillez indiquer un nom.');

        //si le nom contient des chiffres ou des caractéres spéciaux interdit
        } elseif(!preg_match('~^[a-zA-Z]+$~', $_POST['nom'])) {
            alertMessage('danger', 'Le nom contient des caractères non-autorisés.');

        //si la case prénom est vide
        } elseif(empty($_POST['prenom'])) {
            alertMessage('danger', 'Veuillez indiquer un prénom.');

        //si le prénom contient des caractéres spéciaux interdit 
        } elseif(!preg_match('~^[a-zA-Z]+$~', $_POST['prenom'])) {
            alertMessage('danger', 'Le prénom contient des caractères non-autorisés.');

        //si le mail est vide
        } elseif(empty($_POST['email'])) {
            alertMessage('danger', 'Veuillez indiquer un email.');
    
        //si le mail existe déja entrer en bdd    
        } elseif(getMemberBy($pdo, 'email', $_POST['email']) !== null) {
            alertMessage('danger', 'Cette adresse email est déjà utilisée.');
    
        //si le mail est non valide  
        } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            alertMessage('danger', 'Veuillez indiquer une adresse email valide.');

        //si la case téléphone est vide
        } elseif(empty($_POST['telephone'])) {
            alertMessage('danger', 'Veuillez indiquer un numéro de téléphone.');
    
        //si le mdp ne correspond pas aux exigences demandées    
        } elseif(!preg_match('~^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$~', $_POST['password'])) {
            alertMessage('danger', 'Le mot de passe doit contenir au minimum: 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.');
        //si un champs civilité n'est pas selectionné
        } elseif(empty($_POST['civilite'])){
            alertMessage('danger', 'Veuillez indiquer votre civiltié.');
        
    
        } else {
            //Requête
            $req = $pdo->prepare(
                'INSERT INTO membre (pseudo, mdp, nom, prenom, statut, email, telephone, civilite, date_enregistrement)
                VALUES (:pseudo, :mdp, :nom, :prenom, :statut, :email, :telephone, :civilite, NOW())'
            );
            $req->execute([
                'pseudo' => $_POST['pseudo'],
                'mdp' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'statut' => ROLE_USER,
                'email' => $_POST['email'],
                'telephone' => $_POST['telephone'],
                'civilite' => $_POST['civilite'],
    
            ]);
     
            alertMessage('success', 'Vous avez bien été inscrit !');
            alertMessage('info', 'Vous pouvez vous connecter une fois votre activation effectué.');
            session_write_close();
        }
    }




    //Préparation puis execution de la requete pour le tableau
    $query = "SELECT * FROM membre ORDER BY membre_id ASC;";
    try {
        $req = $pdo->prepare($query);
        $req->execute();
        $NbreDonnee = $req->rowCount();	// nombre d'enregistrements (lignes)
        $ligneToute = $req->fetchAll();
    } catch (PDOException $e){ echo 'Erreur SQL : '. $e->getMessage().'<br/>'; die(); }


    // affichage du tableau
    if ($NbreDonnee != 0) 
    {
    ?>
        <table border="2" class="table">
        <thead class="thead-dark">
            <tr>
                <th>membre id</th>
                <th>pseudo</th>
                <th>nom</th>
                <th>prénom</th>
                <th>email</th>
                <th>téléphone</th>
                <th>civilité</th>
                <th>statut</th>
                <th>date_enregistrement</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
        // Début de la condition Foreach : pour chaque ligne (chaque enregistrement)
        foreach ( $ligneToute as $ligne ) 
        {
            // DONNEES A AFFICHER dans chaque cellule de la ligne
    ?>
            <tr>
                <td><?php echo $ligne['membre_id']; ?></td>
                <td><?php echo $ligne['pseudo']; ?></td>
                <td><?php echo $ligne['nom']; ?></td>
                <td><?php echo $ligne['prenom']; ?></td>
                <td><?php echo $ligne['email']; ?></td>
                <td><?php echo $ligne['telephone']; ?></td>
                <td><?php echo $ligne['civilite']; ?></td>
                <td><?php echo $ligne['statut']; ?></td>
                <td><?php echo $ligne['date_enregistrement']; ?></td>
                <td>
                <button class="btn btn-info btn-membre" data-id="<?= $ligne['membre_id'] ?>" data-toggle="modal" data-target="#membre"><i class="fa fa-eye" aria-hidden="true"></i></button>

                <button class="btn btn-info btn-membre" data-id="<?= $ligne['membre_id'] ?>" data-toggle="modal" data-target="#membre_edit"><i class="far fa-edit"></i></button>

                <button class="btn btn-info btn-produit" data-id="<?= $ligne['membre_id'] ?>" data-toggle="modal" data-target="#membre_suppr"><i class="far fa-trash-alt"></i></button>
			    </td>
            </tr>
    <?php
        } // Fin condition foreach
    ?>
        </tbody>
        </table>
        
    <?php
        } else { 
            echo 'Il n\'y a aucun membres à afficher.';
        }
        //Fin condition if
    ?>
    <!--Inclusion message flesh-->
    <?php include __DIR__ . '/../assets/includes/flash.php'; ?>

    <!--Formulaire-->

    <form action="gestion_membres.php" method="post" class="d-flex justify-content-center bd-highlight">
    
    <div class="p-2 flex-grow-1 bd-highlight">
            <label>Pseudo</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="pseudo" value="<?= $_POST['pseudo'] ?? ''; ?>" placeholder="Pseudo" aria-label="pseudo" aria-describedby="basic-addon1">
                </div>

            <label>Mots de passe</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="text" placeholder="mot de passe" name="password" aria-label="mdp" aria-describedby="basic-addon1">
                </div>

            <label>Nom</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" placeholder="votre nom" name="nom" value="<?= $_POST['nom'] ?? ''; ?>" aria-label="nom" aria-describedby="basic-addon1">
                </div>
            <label>Prénom</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" placeholder="votre prénom" name="prenom" value="<?= $_POST['prenom'] ?? ''; ?>" aria-label="prenom" aria-describedby="basic-addon1">
                </div>
    </div>




    <div>
            <label>Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="text" name="email" value="<?= $_POST['email'] ?? ''; ?>" placeholder="votre email" aria-label="email" aria-describedby="basic-addon1">
                </div>
    
            <label>Téléphone</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" placeholder="votre téléphone" name="telephone" value="<?= $_POST['telephone'] ?? ''; ?>" aria-label="telephone" aria-describedby="basic-addon1">
                </div>
   
            
            <label>Civilité</label>
                <div class="input-group mb-3">
                    <select name="civilite" id="">
                        <option value="m">Homme</option>
                        <option value="f">Femme</option>
                    </select>
                </div>

            <label>Statut</label>
                <div class="input-group mb-3">
                    <select name="statut">
                        <option value="1">Admin</option>
                        <option value="0">Membre</option>
                    </select>
                </div>
                
    </div>
        
        </form>


    <!-- Modal 1 -->
        <div class="modal fade" id="membre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Détail du membre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="details">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
                </div>
            </div>
        </div>

    <!-- Modal 2 -->
        <div class="modal fade" id="membre_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier membre </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="details">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
                </div>
            </div>
        </div>
    <!-- Modal 3 -->
        <div class="modal fade" id="membre_suppr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Supprimer membre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="details">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
                </div>
            </div>
        </div>
	
<?php
    require_once __DIR__ . '/../assets/includes/footer_admin.php';
?>