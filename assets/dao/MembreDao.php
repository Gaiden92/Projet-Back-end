<?php

class MembreDao {

public static function retrieveMembreByPseudo(PDO $pdo, $pseudo): array
{
    $errors=array();

    $req = $pdo->prepare(
        'select * from membre where pseudo=:pseudo'
    );

    $req->execute([
        'pseudo' => $pseudo,
    ]);

    $profiles = $req->fetchAll(PDO::FETCH_ASSOC);

    if (count($profiles) == 1) {
        //Cas normal
        $profil = $profiles[0];
    } else if (count($profiles) >= 2) {
        // Cas anormal car pseudo censé être unique
        $errors['sql'] = "Plusieurs pseudo '$pseudo' ont été trouvé en base de données !";
    } else {
        // Pas trouvé
        $errors['sql'] = "Aucun pseudo appelé '$pseudo' n'a été trouvé en base de données !";
    }
    return array($profil, $errors);
}

    public static function retrieveBestMembres(PDO $pdo)
    {
        $req = $pdo->prepare(
            'select ven.nom, ven.prenom, n.etoile, count(1) as nb_avis
            from note n
            inner join membre ven on n.membre_id1 = ven.id_membre 
            group by ven.nom, ven.prenom, n.etoile 
            union
            select ach.nom, ach.prenom, n.etoile, count(1) as nb_avis 
            from note n
            inner join membre ach on n.membre_id2 = ach.id_membre
            group by ach.nom, ach.prenom, n.etoile
            order by etoile desc, nb_avis desc
            LIMIT 0,5'
        );

        $execute = $req->execute();

        $bestMembres = $req->fetchAll(PDO::FETCH_ASSOC);

        return $bestMembres;
    }

    public static function retrieveMoreActivesMembres(PDO $pdo)
    {
        $req = $pdo->prepare(
            'select mm.nom, mm.prenom, sum(nb) as total
            from (select m.nom, m.prenom, count(1) as nb 
                from membre m
                inner join annonce a on a.membre_id = id_membre
                group by nom, prenom
                union
                select ven.nom, ven.prenom, count(1) as nb
                from note n
                inner join membre ven on n.membre_id1 = id_membre 
                group by nom, prenom 
                union
                select ach.nom, ach.prenom, count(1) as nb 
                from note n
                inner join membre ach on n.membre_id2 = id_membre
                group by nom, prenom) mm
            group by mm.nom, mm.prenom
            order by total desc
            LIMIT 0,5'
        );

        $execute = $req->execute();

        $moreActivesMembres = $req->fetchAll(PDO::FETCH_ASSOC);

        return $moreActivesMembres;
    }

    public static function retrieveMembreByAnnonceId(PDO $pdo, int $annonceId)
    {
        $query = "SELECT m.* 
            FROM membre m
            inner join annonce a on m.id_membre = a.membre_id
            where 1=1
            and a.id_annonce = :id";

        $req = $pdo->prepare($query);

        $req->execute([
            'id' => $annonceId,
        ]);

        $membres = $req->fetchAll(PDO::FETCH_ASSOC);
        if (count($membres)==1) {
            return $membres[0];
        }
        return null;
    }
}

?>
