<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';


$page_title = 'Profil'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>
<h2 class="text-center mt-5 mb-5">Gestion des annonces</h2>


<?php     
//Préparation puis execution de la requete pour le tableau
    $query = "SELECT * FROM annonce ORDER BY date_enregistrement ASC;";
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
    <h3 class="m-5">Tableaux des annonces</h3>
    <div class="">
        <table border="2" class="table">
        <thead class="thead-dark">
            <tr>
                <th>id annonce</th>
                <th>titre</th>
                <th>description courte</th>
                <th>description longue</th>
                <th>prix</th>
                <th>photo</th>
                <th>pays</th>
                <th>ville</th>
                <th>adresse</th>
                <th>cp</th>
                <th>membre_id</th>
                <th>categorie_id</th>
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
                <td><?php echo $ligne['id_annonce']; ?></td>
                <td><?php echo $ligne['titre']; ?></td>
                <td><?php echo $ligne['description_courte']; ?></td>
                <td><?php echo $ligne['description_longue']; ?></td>
                <td><?php echo $ligne['prix']; ?></td>
                <td><?php echo $ligne['photo']; ?></td>
                <td><?php echo $ligne['pays']; ?></td>
                <td><?php echo $ligne['ville']; ?></td>
                <td><?php echo $ligne['adresse']; ?></td>
                <td><?php echo $ligne['cp']; ?></td>
                <td><?php echo $ligne['membre_id']; ?></td>
                <td><?php echo $ligne['categorie_id']; ?></td>
                <td><?php echo $ligne['date_enregistrement']; ?></td>
                <td><i class="fas fa-search"></i> <i class="far fa-edit"></i><button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-trash-alt"></i></button></td>
            </tr>
    <?php
        } // Fin condition foreach
    ?>
        </tbody>
        </table>
    </div>   
    <?php
        } else { 
            echo 'Il n\'y a aucun membres à afficher.';
        }
        //Fin condition if
    ?>


  













<?php

include __DIR__ . '/../assets/includes/footer_admin.php';