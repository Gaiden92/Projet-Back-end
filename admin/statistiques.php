<?php
require_once __DIR__ . '/../assets/config/configurationprincipale.php';
require_once __DIR__ . '/../assets/dao/NoteDao.php';
require_once __DIR__ . '/../assets/dao/AnnonceDao.php';
require_once __DIR__ . '/../assets/dao/MembreDao.php';

$page_title = 'catégorie';

$bestMembres = MembreDao::retrieveBestMembres($pdo);
$moreActivesMembres = MembreDao::retrieveMoreActivesMembres($pdo);
$moreOlderAnnonces = AnnonceDao::retrieveMoreOlderAnnonces($pdo);
$bestCategories = AnnonceDao::retrieveBestCategories($pdo);

include __DIR__ . '/../assets/includes/header_admin.php';
?>
    <!------------aff de ttes les cat-------------------------------------->
    <h2 class="text-center">Affichage des statistiques</h2>

    <div class="col-6">
        <table class="table table-bordered table-striped table-hover">
            <tr class="text-center">
                <td>Top 5 des membres les mieux notés</td>
            </tr>
            <tr class="text-center d-flex">
                <?php
                $position = 1;
                foreach ($bestMembres as $bestMembre) {
                    $line = "N°: " . ($position++) . "<br> Membre : " . $bestMembre['prenom'] . "  " . $bestMembre['nom'] . "<br>Note:   " . $bestMembre['etoile']. "<br> Nombre d'avis: " . $bestMembre['nb_avis'];
                    print("<td>$line</td>");
                    
                }
               ?>
                
            </tr>
           
        </table>
    </div>

    <div class="col-10">
        <table class="table table-bordered table-striped table-hover">
            <tr class="text-center">
                <td>Top 5 des membres les plus actifs</td>
            </tr>
            <tr class="text-center d-flex">
                <?php
                $position = 1;
                foreach ($moreActivesMembres as $moreActivesMembre) {
                    $line = "N°: " . ($position++) . " <br> Membre : " . $moreActivesMembre['prenom'] . " " . $moreActivesMembre['nom'] . "<br> Nombre total d'activité: " . $moreActivesMembre['total'];
                    print("<td>$line</td>");
                }
                ?>
            </tr>
        </table>
    </div>

    <div>
        <table class="table table-bordered table-striped table-hover">
            <tr class="text-center">
                <td>Top 5 des annonces les plus vieilles</td>
            </tr>
            <tr class="text-center d-flex">
                <?php $position = 1;
                foreach ($moreOlderAnnonces as $moreOlderAnnonce) {
                    $line = "N°: " . ($position++) . " <br> Titre de l'annonce: " . $moreOlderAnnonce['titreA'] . "<br> Posté le:  " . $moreOlderAnnonce['date_enregistrement'] . "<br>Jours écoulés: " . $moreOlderAnnonce['nbdays'] . " jours";
                    print("<td>$line</td>");
                }
                ?>
            </tr>
        </table>
    </div>

    <div class="col-8">
        
        <table class="table table-bordered table-striped table-hover">
            <tr class="text-center">
                <td>Top 5 des meilleurs catégories</td>
            </tr>
        
            <tr class="text-center d-flex">
                <?php $position = 1;
                foreach ($bestCategories as $bestCategorie) {
                    $line = "N°: " . ($position++) . "<br>Catégorie : " . $bestCategorie['titre'] . "<br>Nombre d'annonce: " . $bestCategorie['nbannonce'];
                    print("<td>$line</td>");
                }
                ?>
            </tr>
        </table>
    </div>


<?php
//debug($_POST);
include __DIR__ . '/../assets/includes/footer_admin.php';
?>