<?php
class NoteDao {
    public static function retrieveCommentsByMembre(PDO $pdo, $pseudo): array
    {
        $query = "SELECT c.*  FROM commentaire c, membre m
            WHERE 1=1 AND c.membre_id = m.id_membre
            AND m.pseudo = :pseudo
            ORDER BY c.date_enregistrement desc";

        $req = $pdo->prepare($query);

        $req->execute([
            'pseudo' => $pseudo,
        ]);

        $comments = $req->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }

    public static function saveNote($pdo, $note)
    {
        $req = $pdo->prepare(
            'insert note (membre_id1, membre_id2, etoile, avis, date_enregistrement) 
            values (:membre_id1, :membre_id2, :note, :avis, now())'
        );

        $result = $req->execute([
            'membre_id1'=>$note['membre_id1'],
            'membre_id2'=>$note['membre_id2'],
            'note'=>$note['note'],
            'avis'=>$note['avis']
        ]);

        if ($result) {
            alertMessage('success', 'Votre note a bien été enregistrée !');

        } else {
            $errorCode = $req->errorCode();
            print ('errorCode = '.$errorCode.'</br>');print_r($req->errorInfo());print ('</br>');
            alertMessage('error', "Une erreur est survenue (code : '$errorCode' - msg : '???')!");
        }
        return $result;
    }
}
?>
