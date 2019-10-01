<?php

class AnnonceDao
{

    public static function retrieveAnnoncesByMembre(PDO $pdo, $pseudo): array
    {
        $query = "SELECT a.*  FROM annonce a, membre m
            WHERE 1=1 AND a.membre_id = m.id_membre
            AND m.pseudo = :pseudo
            ORDER BY a.date_enregistrement desc";

        $req = $pdo->prepare($query);

        $req->execute([
            'pseudo' => $pseudo,
        ]);

        $annonces = $req->fetchAll(PDO::FETCH_ASSOC);
        return $annonces;
    }

    public static function retrieveMoreOlderAnnonces(PDO $pdo)
    {
        $query = "SELECT a.titreA, a.date_enregistrement, (datediff(now(), a.date_enregistrement)) as nbdays  
            FROM annonce a
            ORDER BY nbdays desc
            LIMIT 0,5";

        $req = $pdo->prepare($query);

        $execute = $req->execute();

        $moreOlderAnnonces = $req->fetchAll(PDO::FETCH_ASSOC);
        return $moreOlderAnnonces;
    }

    public static function retrieveBestCategories(PDO $pdo)
    {
        $query = "SELECT c.titre, count(a.titreA) as nbannonce 
            FROM categorie c
             inner join annonce a on c.id_categorie = a.categorie_id
            group by c.titre
            ORDER BY nbannonce desc
            LIMIT 0,5";

        $req = $pdo->prepare($query);

        $execute = $req->execute();

        $bestCategories = $req->fetchAll(PDO::FETCH_ASSOC);
        return $bestCategories;
    }

    public static function retrieveAnnonceById(PDO $pdo, int $annonceId)
    {
        $query = "SELECT a.* 
            FROM annonce a
            where 1=1
            and id_annonce = :id";

        $req = $pdo->prepare($query);

        $req->execute([
            'id' => $annonceId,
        ]);

        $annonces = $req->fetchAll(PDO::FETCH_ASSOC);
        if (count($annonces)==1) return $annonces[0];
        return null;
    }

    public static function retrieveAllAnnonces(PDO $pdo)
    {
/*        $query = "SELECT a.id_annonce, a.titre, a.description_courte, a.description_longue, a.prix, a.pays, a.ville, a.cp, a.adresse, a.cp, a.date_enregistrement, m.prenom, c.titre, p.photo1
FROM annonce a, membre m, categorie c, photo p
WHERE (a.membre_id = m.id_membre)
AND (a.categorie_id = c.id_categorie)
AND (a.photo_id = p.id_photo)
ORDER BY prix LIMIT 0,10";*/

        $query = "SELECT a.* FROM annonce a order by a.date_enregistrement desc";

        $req = $pdo->prepare($query);

        $req->execute();

        $annonces = $req->fetchAll(PDO::FETCH_ASSOC);
        return $annonces;
    }

    public static function addAnnonce(PDO $pdo, array $annonce)
    {
        $req = $pdo->prepare(
            'insert annonce (titreA, description_courte, description_longue, prix, photo, pays,
            ville, cp, adresse, membre_id, photo_id, categorie_id, date_enregistrement) 
            values (:titreA, :description_courte, :description_longue, :prix, :photo, :pays,
            :ville, :cp, :adresse, :membre_id, :photo_id, :categorie_id, now())'
        );

        $result = $req->execute([
            'titreA'=>$annonce['titreA'],
        'description_courte'=>$annonce['description_courte'],
        'description_longue'=>$annonce['description_longue'],
        'prix'=>$annonce['prix'],
        'photo'=>$annonce['photo'],
        'pays'=>$annonce['pays'],
        'ville'=>$annonce['ville'],
        'cp'=>$annonce['cp'],
        'adresse'=>$annonce['adresse'],
        'membre_id'=>$annonce['membre_id'],
        'photo_id'=>$annonce['photo_id'],
        'categorie_id'=>$annonce['categorie_id'],

        ]);

        if ($result) {
            alertMessage('success', 'Vous données de profile ont bien été enregistrées !');

        } else {
            $errorCode = $req->errorCode();
            print ('errorCode = '.$errorCode.'</br>');print_r($req->errorInfo());print ('</br>');
            alertMessage('error', "Une erreur est survenue (code : '$errorCode' - msg : '???')!");
           }
        return $result;
    }

}

?>
