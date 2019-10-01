<?php
require_once __DIR__ . '/assets/config/configurationprincipale.php';

$page_title ='Inscription';
include __DIR__ . '/assets/includes/header.php';

# Traitement du formulaire
if (isset($_POST['inscription'])) {
   
    if (getMemberBy($pdo, 'pseudo', $_POST['pseudo']) !== null) {
        alertMessage('danger', 'Ce pseudo est déjà pris.');

       
    } elseif(strlen($_POST['pseudo']) < 3 || strlen($_POST['pseudo']) > 25) {
        alertMessage('danger', 'Le pseudo doit contenir entre 3 et 25 caractères.');
        
    } elseif(!preg_match('~^[a-zA-Z0-9_-]+$~', $_POST['pseudo'])) {
        alertMessage('danger', 'Le pseudo contient des caractères non-autorisés.');
    
    } elseif(empty($_POST['nom'])) {
        alertMessage('danger', 'Veuillez indiquer un nom.');

    } elseif(!preg_match('~^[a-zA-Z]+$~', $_POST['nom'])) {
        alertMessage('danger', 'Le nom contient des caractères non-autorisés.');

    } elseif(empty($_POST['prenom'])) {
        alertMessage('danger', 'Veuillez indiquer un prénom.');

    } elseif(!preg_match('~^[a-zA-Z]+$~', $_POST['prenom'])) {
        alertMessage('danger', 'Le prénom contient des caractères non-autorisés.');

    } elseif(empty($_POST['email'])) {
        alertMessage('danger', 'Veuillez indiquer un email.');

        
    } elseif(getMemberBy($pdo, 'email', $_POST['email']) !== null) {
        alertMessage('danger', 'Cette adresse email est déjà utilisée.');

        
    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        alertMessage('danger', 'Veuillez indiquer une adresse email valide.');
    
    } elseif(empty($_POST['telephone'])) {
        alertMessage('danger', 'Veuillez indiquer un numéro de téléphone.');

        
    } elseif(!preg_match('~^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$~', $_POST['password'])) {
        alertMessage('danger', 'Le mot de passe doit contenir au minimum: 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.');

        
    } elseif($_POST['password'] !== $_POST['confirmation']) {
        alertMessage('danger', 'Les mots de passe ne correspondent pas.');

    } elseif(empty($_POST['civilite'])){
        alertMessage('danger', 'Veuillez indiquer votre civiltié.');
    

    } else {
        
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
        //alertMessage('info', 'Vous pouvez vous connecter une fois votre activation effectué.');
        session_write_close();
       
    }
}
?>


    <!--Affichage du formulaire-->
    <div class="container border mt-4 p-3 col-4">
        <h1>Inscription</h1>

        <?php include __DIR__ . '/assets/includes/flash.php'; ?>

        <form action="inscription.php" method="post">
            <div class="form-group">
                <label>Pseudo</label>
                <input type="text" name="pseudo" class="form-control" value="<?= $_POST['pseudo'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="Choisissez un mot de passe">
            </div>

            <div class="form-group">
                <label>Confirmation du mot de passe</label>
                <input type="password" name="confirmation" class="form-control" placeholder="Confirmez votre mots de passe">
            </div>

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" placeholder="Votre nom" value="<?= $_POST['nom'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control" placeholder="Votre prénom" value="<?= $_POST['prenom'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Votre email" value="<?= $_POST['email'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Téléphone</label>
                <input type="tel" name="telephone" class="form-control" placeholder="Votre téléphone" value="<?= $_POST['telephone'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Votre sexe</label>
                    <div>
                       <select name="civilite">
                            <option class="form-control" value="">Choisissez une civilité</option>
                            <option class="form-control" value="f">Féminin</option>
                            <option class="form-control" value="m">Masculin</option>
                        </select>
                    </div> 
            </div>

  
            <input type="submit" name="inscription" value="inscrire" class="btn btn-lg btn-success">
        </form>
    </div>

    
<?php
include __DIR__ . '/assets/includes/footer.php'; 
