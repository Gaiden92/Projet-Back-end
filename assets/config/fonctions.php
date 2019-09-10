<?php
function debug($var){
	echo '<div style="background:#' . rand(111111, 999999) . '; color: white; padding: 5px;">';
	$trace = debug_backtrace(); // Retourne un array contenant des infos sur la ligne exécutée
	$info = array_shift($trace); // Extrait la 1ere valeur d'un ARRAY
	
	echo 'Le debug a été demandé dans le fichier ' . $info['file'] .  ' à la ligne '. $info['line'] . '<hr/>'; 
	
	echo '<pre>'; 
	print_r($var);
	echo '</pre>';

	echo '</div>';	
}
/**
 * Fonction pour ajouter un message flash
 * @param string 
 * @param string 
 * @return void
 */
function alertMessage(string $type, string $message) : void
{
  
    $_SESSION['flash'][] = [
        'type' => $type,
        'message' => $message,
    ];
}

/**
 * Fonction pour récupérer les messages flash
 * @return array
 */

function recupereralerteMessage() : array
{  
    $messages = $_SESSION['flash'] ?? [];    
    unset($_SESSION['flash']);
    return $messages;
}

/**
 * @return array|null
 */

function getMember() : ?array
{
    return $_SESSION['membre'] ?? null;
}


/**
 * Récupérer un utilisateur par un critère
 * @param PDO $pdo
 * @param string $colonne       nom de la colonne sur laquelle rechercher
 * @param mixed $valeur         valeur de la $colonne
 */
function getMemberBy(PDO $pdo, string $colonne, $valeur) : ?array
{
    $req = $pdo->prepare(sprintf(
        'SELECT *
        FROM membre
        WHERE %s = :valeur',
        $colonne
    ));
    $req->bindParam(':valeur', $valeur);
    $req->execute();

    $utilisateur = $req->fetch(PDO::FETCH_ASSOC);
    return $utilisateur ?: null;
}

/**
 * verification du statut
 * @param int $statut
 * @return bool
 */

 function statut(int $statut) : bool
 {
     if(getMember() === null){
         return false;
     }

     return getMember()['statut'] == $statut;
 }
