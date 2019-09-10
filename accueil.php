<?php 

require_once __DIR__ . '/assets/config/configurationprincipale.php';


$page_title = 'Accueil'; 
include __DIR__ . '/assets/includes/header.php';
?>

<!--Barre de trie-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <form>
                <div class="form-group">
                        <div>
                            <select>
                                <option>Trier par prix (du moins cher au plus cher)</option>
                                <option>Trier par prix (du plus cher au moins cher)</option>
                                <option>Trier par date (du plus récent au plus ancien)</option>
                                <option>Trier par date (du plus ancien au plus récent)</option>
                                
                                
                            </select>
                        </div>
                </div>
        </form>
    </div>





<!--Menu de gauche-->
   
    <form>
        <div class="form-group">
        <label for="régions">Catégorie</label>
                <div>
                    <select>
                    <option>Toutes les catégories</option>
                        <option>Emploi</option>
                        <option>Véhicule</option>
                        <option>Immobilier</option>
                        <option>Vacances</option>
                        <option>Multimédia</option>
                        <option>Loisirs</option>
                        <option>Matériel</option>
                        <option>Services</option>
                        <option>Maison</option>
                        <option>Vêtements</option>
                        <option>Autres</option>
                    </select>
                </div>
        </div>

        <div class="form-group">
            <label for="régions">Région</label>
                <div>
                    <select>
                        <option>Toutes les régions</option>
                        <option>Auvergne-Rhône-Alpes</option>
                        <option>Bourgogne-Franche-Comté</option>
                        <option>Bretagne</option>
                        <option>Centre-Val de Loire</option>
                        <option>Grand Est</option>
                        <option>Corse</option>
                        <option>Hauts-de-France</option>
                        <option>Île-de-France</option>
                        <option>Normandie</option>
                        <option>Nouvelle-Aquitaine</option>
                        <option>Occitanie</option>
                        <option>Pays de la Loire</option>
                        <option>Provence-Alpes-Côte d'Azur</option>
                    </select>
                </div>
        </div>

        <div class="form-group">
            <label for="régions">Membre</label>
                <div>
                    <select>
                        <option>Toutes les membres</option>
                        <option>Marie Thoyer</option>
                        <option>Julien Cottet</option>
                        <option>Guillaume Miller</option>
                    </select>
                </div>
        </div>

        <div class="form-group">
            <label for="formControlRange" >Prix</label>
            <input type="range" class="form-control-range col-4 col-lg-1" id="formControlRange">
        </div>

    </form>
    </div>
   

   

      

<?php

include __DIR__ . '/assets/includes/footer.php';



?>