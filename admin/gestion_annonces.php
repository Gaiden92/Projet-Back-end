<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';


$page_title = 'Profil'; 
include __DIR__ . '/../assets/includes/header_admin.php';
?>
<h2 class="text-center mt-5 mb-5">Gestion des annonces</h2>


<?php     
//Préparation puis execution de la requete pour le tableau
        $query = "SELECT a.id_annonce, a.titre, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1
        FROM annonce a, membre m, categorie c, photo p
        WHERE a.membre_id = m.id_membre
        AND a.categorie_id = c.id_categorie
        AND a.photo_id = p.id_photo";

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

    <div class="row justify-content-center">
        <form>
                <div class="form-group">
                        <div>
                            <select>
                                <option>Trier par catégorie</option>
                                
                            </select>
                        </div>
                </div>
        </form>
    </div>

    <hr>

    
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
                <th>membre</th>
                <th>catégorie</th>
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
                <td><?php echo $ligne['id_annonce']; ?></td>
                <td><?php echo $ligne['titre']; ?></td>
                <td><?php echo $ligne['description_courte']; ?></td>
                <td><?php echo $ligne['description_longue']; ?></td>
                <td><?php echo $ligne['prix']; ?></td>
                <td><img src="../assets/img/<?= $ligne['photo1']; ?>" class="img-thumbnail"></td>
                <td><?php echo $ligne['pays']; ?></td>
                <td><?php echo $ligne['ville']; ?></td>
                <td><?php echo $ligne['adresse']; ?></td>
                <td><?php echo $ligne['cp']; ?></td>
                <td><?php echo $ligne['prenom']; ?></td>
                <td><?php echo $ligne['titre']; ?></td>
                <td><?php echo $ligne['date_enregistrement']; ?></td>
                <td>
                    <button class="btn btn-info btn-annonce" data-id="<?= $ligne['id_annonce'] ?>" data-toggle="modal" data-target="#annonce"> <i class="fa fa-eye" aria-hidden="true"> </i> </button>

                    <button class="btn btn-info btn-annonce" data-id="<?= $ligne['id_annonce'] ?>" data-toggle="modal" data-target="#annonce_edit"> <i class="far fa-edit"> </i> </button>

                    <button class="btn btn-info btn-produit" data-id="<?= $ligne['id_annonce'] ?>" data-toggle="modal" data-target="#annonce_suppr"> <i class="far fa-trash-alt"> </i> </button>
                </td>
            </tr>


            <!-- Modal 1 -->
        <div class="modal fade" id="annonce" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Détail annonce</h5>
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
        <div class="modal fade" id="annonce_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier annonce </h5>
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
        <div class="modal fade" id="annonce_suppr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Supprimer annonce</h5>
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


  













<?php

include __DIR__ . '/../assets/includes/footer_admin.php';