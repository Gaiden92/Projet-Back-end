<?php 

    require_once __DIR__ . '/../assets/config/configurationprincipale.php';

    $page_title = 'Profil'; 
    require_once __DIR__ . '/../assets/includes/header_admin.php';
    

    //Préparation puis execution de la requete pour le tableau
    $query = 'SELECT  n.id_note
                ,   n.membre_id1
                ,   n.membre_id2
                ,   n.etoile
                ,   n.avis
                ,   n.date_enregistrement
                ,   m1.id_membre
                ,   m1.email
                ,   m2.id_membre
                ,   m2.email AS email2
              FROM    note    n
                inner join
                    membre  m1
                    on  n.membre_id1 = m1.id_membre
                inner join
                    membre  m2
                on  n.membre_id2 = m2.id_membre
            ORDER BY n.id_note ASC
            ';
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
                <th>id note</th>
                <th>id membre 1</th>
                <th>id membre 2</th>
                <th>note</th>
                <th>avis</th>
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
                <td><?php echo $ligne['id_note']; ?></td>
                <td><?php echo $ligne['membre_id1']. ' - ' . $ligne['email']; ?></td>
                <td><?php echo $ligne['membre_id2']. ' - ' . $ligne['email2'] ?></td>
                <td><?php echo $ligne['etoile']; ?></td>
                <td><?php echo $ligne['avis']; ?></td>
                <td><?php echo $ligne['date_enregistrement']; ?></td>
                <td><a class="btn btn-primary" id="btnVoir" href="fiche_note.php?id=<?=$ligne['id_note'];?>"  role="button"><i  class="fa fa-eye" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" id="btnVoir" href="fiche_note.php?id=<?=$ligne['id_note'];?>" role="button"><i class="far fa-edit" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" id="btnVoir" href="fiche_note.php?id=<?=$ligne['id_note'];?>" role="button"><i class="far fa-trash-alt" aria-hidden="true"></i></a>        
                    </td>
			    
            </tr>
    <?php
        } // Fin condition foreach
    ?>
        </tbody>
        </table>
        
    <?php
        } else { 
            echo 'Il n\'y a aucune note à afficher.';
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