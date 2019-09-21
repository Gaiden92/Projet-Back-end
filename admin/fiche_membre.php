<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';

// fiche_membre.php?id=

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $resultat = $pdo -> prepare("SELECT * FROM membre WHERE id_membre = :id");
    $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $resultat -> execute();
    
    if ($resultat -> rowCount() > 0) {
        $membre = $resultat -> fetch();
        extract($membre);
    }   
    
} else {
        alertMessage('danger', 'erreur');
    
}


//enregistrement modification
if(isset($_POST['modifier'])){
    //verif pseudo
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
    //si le mail est non valide 

    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        alertMessage('danger', 'Veuillez indiquer une adresse email valide.');
    
    //si la case téléphone est vide
    } elseif(empty($_POST['telephone'])) {
        alertMessage('danger', 'Veuillez indiquer un numéro de téléphone.');

    //si un champs civilité n'est pas selectionné
    } elseif(empty($_POST['civilite'])){
        alertMessage('danger', 'Veuillez indiquer votre civiltié.');

        //Sinon si toutes les conditions sont remplies on envoie la requête
    } else
    {
      
            
      $pseudo= $_POST['pseudo'];

        $resultat = $pdo->prepare(
            'UPDATE membre 
            SET id_membre=:id, pseudo=:pseudo, nom=:nom, prenom=:prenom, email= :email, telephone= :telephone, civilite= :civilite, statut= :statut
            WHERE id_membre=:id'
        );
            $resultat->bindParam(':id', $_POST['id_membre'], PDO::PARAM_INT);
            $resultat->bindParam(':pseudo', $_POST['pseudo']);
            $resultat->bindParam(':nom', $_POST['nom']);
            $resultat->bindParam(':prenom', $_POST['prenom']);
            $resultat->bindParam(':email', $_POST['email']);
            $resultat->bindParam(':telephone', $_POST['telephone']);
            $resultat->bindParam(':civilite', $_POST['civilite']);
            $resultat->bindParam(':statut', $_POST['statut']);

            $resultat->execute();             
            alertMessage('success', 'La modification a été enregistré');
            session_commit();
            header("location:gestion_membres.php");                      
    }
}
//aperçu pour Modification 
    if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
        $resultat = $pdo -> prepare("SELECT * FROM membre WHERE id_membre = :id");
        $resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $resultat -> execute();
        if ($resultat -> rowCount() > 0) {
            $membre_a_modifier = $resultat -> fetch();           
        }
    }
    $pseudo = (isset($membre_a_modifier)) ? $membre_a_modifier['pseudo'] : '';
    $nom = (isset($membre_a_modifier)) ? $membre_a_modifier['nom'] : '';
    $prenom = (isset($membre_a_modifier)) ? $membre_a_modifier['prenom'] : '';
    $email = (isset($membre_a_modifier)) ? $membre_a_modifier['email'] : '';
    $telephone = (isset($membre_a_modifier)) ? $membre_a_modifier['telephone'] : '';
    $civilite = (isset($membre_a_modifier)) ? $membre_a_modifier['civilite'] : '';
    $statut =(isset($membre_a_modifier)) ? $membre_a_modifier['statut'] : '';

// Formulaire: supprimer un membre
if(isset($_POST['supprimer'])) {
    if(!isset($_POST['suppr'])) {
        alertMessage('danger','Veuillez cocher la case pour confirmer la suppression du membre');
    }else{ 
        $req = $pdo -> prepare("DELETE FROM membre WHERE id_membre=:id " ); 
        $req->bindParam(':id',  $_POST['id_membre'],PDO::PARAM_INT);
        $req->execute();
        alertMessage('success','Le membre a bien été supprimé ');
        session_commit();
        header("location:gestion_membres.php");  
    }   
}

$page_title = 'membre'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Pseudo</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Civilité</th>
        <th>Statut</th>
	</tr>
		<tr>      
			<td><?= $_GET['id']; ?></td>
			<td><?= $membre['pseudo'];?></td>
            <td><?= $membre['nom']; ?></td>
            <td><?= $membre['prenom']; ?></td>
            <td><?= $membre['email']; ?></td>
            <td><?= $membre['telephone']; ?></td>
            <td><?= $membre['civilite']; ?></td>
            <td><?= $membre['statut']; ?></td>

		</tr>
</table>

<!------------modifier le membre-------------------------------------->
<div class="col-md-6 offset-3">
    <?php include __DIR__ . '/../assets/includes/flash.php'; ?>

    <form action="fiche_membre.php?id=<?= $_GET['id']; ?>" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="id_membre" value="<?=$id_membre?>"/>

            <div class="form-group">
                <label>Pseudo:</label>
                <input type="text" class="form-control" name="pseudo" value="<?= $pseudo?>"/>
            </div> 

            <div class="form-group">
                <label>Nom:</label>
                <input type="text" value="<?=$nom?>" class="form-control" name="nom">
            </div>

            <div class="form-group">
                <label>Prénom:</label>
                <input type="text" value="<?=$prenom?>" class="form-control" name="prenom">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="text" value="<?=$email?>" class="form-control" type="email" name="email">
            </div>

            <div class="form-group">
                <label>Téléphone:</label>
                <input type="text" class="form-control" value="<?=$telephone?>" name="telephone">
            </div>

            <div class="input-group mb-3">
                    <select name="civilite" value="<?=$civilite?>">
                        <option value="m">Homme</option>
                        <option value="f">Femme</option>
                    </select>
            </div>

            <div class="input-group mb-3">
                    <select name="statut" value="<?=$statut?>">
                        <option value="1">Admin</option>
                        <option value="0">Membre</option>
                    </select>
            </div>
        <input type="submit" class="btn btn-success" value="modifier" name="modifier"/>            
    </form>  
<!---------------suppr le membre----------->
    <form  method="post" action="fiche_membre.php?id=<?=$id_membre?>" enctype="multipart/form-data">
        <input type="hidden" name="id_membre" value="<?= $id_membre ?>"/>
            <div class="form-group form-check " >
                <input type="checkbox" class="form-check-input" name="suppr" id="suppr"> 
                <label for="supprimer" class="form-check-label">Je confirme vouloir supprimer</label><br>              
            </div>
        <input type="submit" class="btn btn-danger" name='supprimer' value="supprimer"/>
    
    </form>
</div>


<?php

include __DIR__ . '/../assets/includes/footer_admin.php';