<?php

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
