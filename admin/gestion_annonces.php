<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';
//affichage de ttes les annonces
    $query = 
    "SELECT 
      a.* 
      , m.*
      , p.*
      , c.*
    FROM annonce a
    LEFT JOIN membre m ON a.membre_id = m.id_membre
    LEFT JOIN photo p ON a.photo_id = p.id_photo
    LEFT JOIN categorie c ON a.categorie_id = c.id_categorie";

        $stmt = $pdo->query($query);
        $annonce = $stmt->fetchAll();

$page_title = 'Gestion annonces'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>
<h2 class="text-center mt-5 mb-5">Gestion des annonces</h2>
<?php include __DIR__ . '/../assets/includes/flash.php'; ?>
        <table border="2" class=" table table-bordered table-striped table-hover">
        <thead class="thead-dark text-center">
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
                <th>membre</th>
                <th>catégorie</th>
                <th>date_enregistrement</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($annonce as $ligne) :?>
            <tr>
                <td><?=$ligne['id_annonce']; ?></td>
                <td><?=$ligne['titreA']; ?></td>
                <td><?=$ligne['description_courte']; ?></td>
                <td><?=$ligne['description_longue']; ?></td>
                <td><?=number_format($ligne['prix'], 2, ',', ' ');?>€</td>

                <td><img src="../assets/img/<?= $ligne['photo1']; ?>" class="img-thumbnail"></td>

                <td><?=$ligne['pays']; ?></td>
                <td><?=$ligne['ville']; ?></td>
                <td><?=$ligne['adresse']; ?></td>
                <td><?=$ligne['cp']; ?></td>
                <td><?=$ligne['prenom']; ?></td>
                <td><?=$ligne['titre']; ?></td>
                <td><?=$ligne['date_enregistrement']; ?></td>
                <td>
                    <a class="btn btn-primary" id="btnVoir" href="fiche_annonce.php?id=<?=$ligne['id_annonce'];?>" role="button"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" id="btnEdit" href="../annonce_ajout.php?id=<?= $ligne['id_annonce'] ?>" role="button"><i class="far fa-edit" aria-hidden="true"></i></a>
                    <a class="btn btn-primary"  id="btnSuppr" href="fiche_annonce.php?id=<?= $ligne['id_annonce'] ?>" role="button"><i class="far fa-trash-alt" aria-hidden="true"></i></a> 
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
        </table>
    



  













<?php

include __DIR__ . '/../assets/includes/footer_admin.php';