<?php
class CommentDao {

    public static function saveComment(PDO $pdo, array $comment)
    {
        $req = $pdo->prepare(
            'insert commentaire (membre_id, motcles) 
            values (:membre_id, :motcles)'
        );

        $result = $req->execute([
            'membre_id'=>$comment['membre_id'],
            'motcles'=>$comment['motcles']
        ]);

        if ($result) {
            alertMessage('success', 'Votre commentaire a bien été enregistrée !');
            

        } else {
            $errorCode = $req->errorCode();
            print ('errorCode = '.$errorCode.'</br>');print_r($req->errorInfo());print ('</br>');
            alertMessage('error', "Une erreur est survenue (code : '$errorCode' - msg : '???')!");
        }
        return $result;

    }
}
?>
