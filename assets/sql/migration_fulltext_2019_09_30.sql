Use swap;

/*
Pour pouvoir utiliser la fonctionnalité de "recherche de texte entier"
il faut créer un index Full Text sur les colonnes concernées
*/

CREATE FULLTEXT INDEX ft_annonce_recherche
ON annonce (titreA, description_courte, description_longue);