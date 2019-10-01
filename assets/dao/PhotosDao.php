<?php

class PhotosDao {

    public static function retrievePhotosById(PDO $pdo, int $photoId)
    {
        $query = "SELECT a.* 
            FROM photos a
            where 1=1
            and id_photo = :id";

        $req = $pdo->prepare($query);

        $req->execute([
            'id' => $photoId,
        ]);

        $photos = $req->fetchAll(PDO::FETCH_ASSOC);
        return $photos;
    }
}
?>