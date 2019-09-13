<?php
require_once __DIR__ . '/../config/configurationprincipale.php';
$tab = array(); //on stock nos echos

$result= $bdd->query("SELECT * FROM categorie WHERE id_categorie='$_GET[id_categorie]'");

//on va redeclarer notre selecteur 
$tab['resultat'] = '<table class="table table-bordered text-ceter mt-4"><tr>' ;
for($i=0; $i<$result->columnCount(); $i++){
  $colonne = $result->getColumnMeta($i);
  $tab['resultat'] .= "<th>$colonne[name]</th>";

}
$tab['resultat'] .= '</tr>';

while($categories = $result->fetch(PDO::FETCH_ASSOC))
{
    $tab['resultat'] .= '<tr>';

    foreach($details as $detail)
    {
        $tab['resultat'] .= "<td>$value</td>";
    }
    $tab['resultat'] .= '</tr>';
}

$tab['resultat'] .= '</table>';

include __DIR__ . '/../includes/header_admin.php';
?>





<?php
include __DIR__ . '/../assets/includes/footer_admin.php';