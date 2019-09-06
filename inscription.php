<?php
include __DIR__ . '/assets/includes/header.php'; 


?>

    <div class="container border mt-4 p-3 col-4">
        <h1>Inscription</h1>

   

        <form action="register.php" method="post">
            <div class="form-group">
                <label>Pseudo</label>
                <input type="text" name="pseudo" class="form-control" placeholder="Choisissez un pseudo" value="<?= $_POST['pseudo'] ?? ''; ?>">
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
                       <select>
                            <option name="sexe" class="form-control" value="<?= $_POST['f'] ?? ''; ?>">Féminin</option>
                            <option name="sexe" class="form-control" value="<?= $_POST['m'] ?? ''; ?>">Masculin</option>
                        </select>
                    </div> 
            </div>

  
            <input type="submit" name="register" value="S'inscrire" class="btn btn-lg btn-success">
        </form>
    </div>

    
<?php
include __DIR__ . '/assets/includes/footer.php'; 
