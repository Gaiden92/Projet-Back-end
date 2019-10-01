<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';
require_once __DIR__ . '/assets/dao/MembreDao.php';
require_once __DIR__ . '/assets/dao/AnnonceDao.php';
require_once __DIR__ . '/assets/dao/NoteDao.php';

$page_title = 'Profil';
include __DIR__ . '/assets/includes/header.php';
function replaceAllCharByStar($char) {
return str_repeat("*", strlen($char));
}

// Traitement du formulaire

$errors = array();
$messages = array();

$mode = 'display-profil'; // mode par défaut : affichage
if (isset($_POST['mode'])) {
    $mode = isset($_POST['mode']);
}

// Affichage ou edition, on récupère les info de la BDD pour le pseudo en question
$pseudo = getMember()['pseudo'];

if ($mode == 'edit-profil' || $mode == 'display-profil') {
    list($profil, $errors) = MembreDao::retrieveMembreByPseudo($pdo, $pseudo);
    $annonces = AnnonceDao::retrieveAnnoncesByMembre($pdo, $pseudo);
    $comments = NoteDao::retrieveCommentsByMembre($pdo, $pseudo);
}

if ($mode == 'save-profil') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $confirmation = $_POST['confirmation'];
    $password = $_POST['password'];
    $civilite = $_POST['civilite'];

    if (empty($nom)) {
        alertMessage('danger', 'Veuillez indiquer un nom.');
    } elseif (!preg_match('~^[a-zA-Z]+$~', $nom)) {
        alertMessage('danger', 'Le nom contient des caractères non-autorisés.');
    } elseif (empty($prenom)) {
        alertMessage('danger', 'Veuillez indiquer un prénom.');
    } elseif (!preg_match('~^[a-zA-Z]+$~', $prenom)) {
        alertMessage('danger', 'Le prénom contient des caractères non-autorisés.');
    } elseif (empty($telephone)) {
        alertMessage('danger', 'Veuillez indiquer un numéro de téléphone.');
    } elseif (empty($civilite)) {
        alertMessage('danger', 'Veuillez indiquer votre civiltié.');
    }

    $errors = recupererAlerteMessages();

    if (count($errors)<=0) {
        $req = $pdo->prepare(
            'UPDATE membre set mdp=:mdp, nom=:nom, '.
            ' prenom=:prenom, statut=:statut, '.
            ' email=:email,'.
            ' telephone=:telephone, civilite=:civilite, date_enregistrement=NOW()'.
            ' where pseudo=:pseudo'
        );

        $result = $req->execute([
            'mdp' => password_hash($password, PASSWORD_DEFAULT),
            'nom' => $nom,
            'prenom' => $prenom,
            'statut' => ROLE_USER,
            'email' => $email,
            'telephone' => $telephone,
            'civilite' => $civilite,
            'pseudo' => $_POST['pseudo']
        ]);

        if ($result) {
            alertMessage('success', 'Vous données de profile ont bien été enregistrées !');
            $messages = recupererAlerteMessages();
            $errors = array();
        } else {
            $errorCode = $req->errorCode();
            //$errorInfo = $req->errorInfo();
            alertMessage('error', "Une erreur est survenue (code : '$errorCode' - msg : '???')!");
            $errors = recupererAlerteMessages();
        }
        session_write_close();
    }

    if (count($errors)==0 && count($messages)==1) {
        $mode = 'display-profil';
        list($profil, $errors) = MembreDao::retrieveMembreByPseudo($pdo, $pseudo);
    } else {
        $mode = 'edit-profil';
    }
}

?>

<div class="container border mt-4 p-4">
    <?php
    if(isset($messages) && count($messages)>0) {
        ?>
    <div class="alert alert-success">
        <?php
        foreach ($messages as $message) {
            echo ("<span>Message d'erreur : $message</span><br>");
        }
        ?>
    </div>
        <?php
    }
    if(isset($errors) && count($errors)>0) {
    ?>
    <div class="alert alert-error">
    <?php
        foreach ($errors as $error) {
            if (is_array($error)) {
                foreach ($error as $err) {
                    echo ("<span>Message d'erreur : $err</span><br>");
                }
            } else {
            echo ("<span>Message d'erreur : $error</span><br>");
            }
        }
    ?>
    </div>
        <?php
    }
    ?>
</div>


    <div class="container border mt-4 p-4">
        <h2>Profil utilisateur : <b><?= $pseudo ?></b></h2>

        <?php if ($mode == 'display-profil') {
            ?>
            <div class="form-group">
                <label>Pseudo</label>
                <span class="form-control"><?= $profil['pseudo'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <span class="form-control"><?= replaceAllCharByStar($profil['mdp']) ?? ''; ?></span>
            </div>

            <div class="form-group">
                <label>Nom</label>
                <span class="form-control"><?= $profil['nom'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <label>Prénom</label>
                <span class="form-control"><?= $profil['prenom'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <label>Email</label>
                <span class="form-control"><?= $profil['email'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <label>Téléphone</label>
                <span class="form-control"><?= $profil['telephone'] ?? ''; ?></span>
            </div>

            <div class="form-group">
                <label>Votre sexe</label>
                <span class="form-control"><?php $profil['civilite']=='m' ? print('Masculin') : print('Féminin'); ?></span>
            </div>

            <form action="profil.php" method="post">
                <input hidden="hidden" type="text" name="pseudo" value="<?= $profil['pseudo'] ?? ''; ?>"/>
                <input hidden="hidden" type="text" name="mode" value="edit-profil"/>

                
            </form>
            <?php
        } 
        ?>
    </div>

    <div class="container border mt-4 p-4">
        <h2>Annonces postées en tant que vendeur : <b><?= $pseudo ?></b></h2>

        <?php
        if (count($annonces)>=1) // Vendeur ?
        {
        ?>
            <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Adresse</th>
                            <th>Pays</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($annonces as $annonce) {
                            $line=
                            "<tr>".
                            "<th>".$annonce['id_annonce']."</th>".
                            "<th>".$annonce['titreA']."</th>".
                            "<th>".$annonce['description_courte']."</th>".
                            "<th>".$annonce['prix']."</th>".
                            "<th>".$annonce['adresse']." - ".$annonce['cp']." ".$annonce['ville']."</th>".
                            "<th>".$annonce['pays']."</th>".
                            "<th>".$annonce['date_enregistrement']."</th>".
                        "</tr>";
                            print($line);
                        }
                        ?>
                        </tbody>
                    </table>
        <?php
        }else {
            ?>
            <h2>Rien à afficher</h2>
       <?php
        }
        ?>

        <h2>Commentaires postées sur annonce : <b><?= $pseudo ?></b></h2>
        <?php
        if (count($comments)>=1) // Vendeur ?
        {
            ?>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Commentaire</th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($comments as $comment) {
                    $line=
                        "<tr>".
                        "<th>".$annonce['id_annonce']."</th>".
                        "<th>".$comment['motcles']."</th>".
                        "</tr>";
                    print($line);
                }
                ?>
                </tbody>
            </table>
            <?php
        }else {
            ?>
            <h2>Rien à afficher</h2>
            <?php
        }
        ?>

    </div>
<?php

include __DIR__ . '/assets/includes/footer.php';