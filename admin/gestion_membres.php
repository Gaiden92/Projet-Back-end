<?php 

    require_once __DIR__ . '/../assets/config/configurationprincipale.php';

    require_once __DIR__ . '/../assets/includes/header_admin.php';

?>



<?php 
    //Préparation puis execution de la requete
    $query = "SELECT * FROM membre ORDER BY id_membre ASC;";
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
	<table border="1" class="table">
	<thead class="thead-dark">
		<tr>
			<th>id membre</th>
			<th>pseudo</th>
            <th>nom</th>
            <th>prénom</th>
			<th>email</th>
            <th>téléphone</th>
            <th>civilité</th>
            <th>statut</th>
            <th>date_enregitrement</th>
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
			<td><?php echo $ligne['id_membre']; ?></td>
			<td><?php echo $ligne['pseudo']; ?></td>
            <td><?php echo $ligne['nom']; ?></td>
            <td><?php echo $ligne['prenom']; ?></td>
            <td><?php echo $ligne['email']; ?></td>
            <td><?php echo $ligne['telephone']; ?></td>
            <td><?php echo $ligne['civilite']; ?></td>
            <td><?php echo $ligne['statut']; ?></td>
            <td><?php echo $ligne['date_enregistrement']; ?></td>
            <td><i class="fas fa-search"></i> <i class="far fa-edit"></i> <i class="fas fa-trash-alt"></i></td>
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

    <div class="row">
        <form action="">
            <label>Pseudo</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" placeholder="Pseudo" aria-label="pseudo" aria-describedby="basic-addon1">
                </div>

            <label>Email</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="text" placeholder="votre email" aria-label="email" aria-describedby="basic-addon1">
                </div>
    

            <label>Mots de passe</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="text" placeholder="mot de passe" aria-label="mdp" aria-describedby="basic-addon1">
                </div>

            <label>Téléphone</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" placeholder="votre téléphone" aria-label="telephone" aria-describedby="basic-addon1">
                </div>

            <label>Nom</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" placeholder="votre nom" aria-label="nom" aria-describedby="basic-addon1">
                </div>
            <label>Prénom</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="text" placeholder="votre prénom" aria-label="prenom" aria-describedby="basic-addon1">
                </div>
            
            <label>Civilité</label>
                <div class="input-group mb-3">
                    <select name="" id="">
                        <option value="">Homme</option>
                        <option value="">Femme</option>
                    </select>
                </div>

            <label>Statut</label>
                <div class="input-group mb-3">
                    <select name="" id="">
                        <option value="">Admin</option>
                        <option value="">Membre</option>
                    </select>
                </div>



        </form>
    </div>
	

<?php
    require_once __DIR__ . '/../assets/includes/footer_admin.php';
?>