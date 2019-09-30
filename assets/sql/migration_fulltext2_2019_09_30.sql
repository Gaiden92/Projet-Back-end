Use swap;

/*
Pour pouvoir utiliser la fonctionnalité de "recherche de texte entier"
il faut créer un index Full Text sur les colonnes concernées
*/

CREATE FULLTEXT INDEX ft_motcles_recherche
ON categorie (titre, motcles);