<?php 

    require_once __DIR__ . '/../assets/config/configurationprincipale.php';

    $page_title = 'Gestion commentaires'; 
    require_once __DIR__ . '/../assets/includes/header_admin.php';
    
?>

<?php 



    //Préparation puis execution de la requete pour le tableau
    $query = 'SELECT c.id_commentaire, c.membre_id, c.motcles, c.annonce_id, c.date_enregistrement, m.id_membre, m.email,                   a.titreA
                FROM commentaire c, membre m, annonce a
                WHERE c.membre_id = m.id_membre
                AND c.annonce_id = a.id_annonce';
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
                    <th>id commentaire</th>
                    <th>id membre</th>
                    <th>id annonce</th>
                    <th>commentaire</th>
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
                    <td><?php echo $ligne['id_commentaire']; ?></td>
                    <td><?php echo $ligne['membre_id']. ' - ' . $ligne['email']; ?></td>
                    <td><?php echo $ligne['annonce_id']. ' - ' . $ligne['titreA'] ; ?></td>
                    <td><?php echo $ligne['motcles']; ?></td>
                    <td><?php echo $ligne['date_enregistrement']; ?></td>
                    <td>
                        <a class="btn btn-primary" id="btnVoir" href="fiche_commentaire.php?id=<?=$ligne['id_commentaire'];?>"role="button">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-primary" id="btnVoir" href="fiche_commentaire.php?id=<?=$ligne['id_commentaire'];?>" role="button">
                            <i class="far fa-edit" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-primary" id="btnVoir" href="fiche_commentaire.php?id=<?=$ligne['id_commentaire'];?>" role="button">
                            <i class="far fa-trash-alt" aria-hidden="true"></i>
                        </a>        
                    </td>
                </tr>
    <?php
        } // Fin condition foreach
    ?>
        </tbody>
        </table>
        
    <?php
        } else { 
            echo 'Il n\'y a aucun commentaires à afficher.';
        }
        //Fin condition if
    ?>
    <!--Inclusion message flesh-->
    <?php include __DIR__ . '/../assets/includes/flash.php'; ?>



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