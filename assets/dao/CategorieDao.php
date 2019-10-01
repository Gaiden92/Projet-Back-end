<?php

class CategorieDao {

    public static function retrieveAllCategories(PDO $pdo)
    {

        $query = "SELECT c.* FROM categorie c";

        $req = $pdo->prepare($query);

        $req->execute();

        $categories = $req->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
}
?>