DROP DATABASE IF EXISTS swap;
CREATE DATABASE swap CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE swap;

CREATE TABLE annonce (
    id_annonce INT(3) NOT NULL AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    description_courte VARCHAR(255) NOT NULL,
    description_longue TEXT NOT NULL, 
    prix FLOAT NOT NULL,
    photo VARCHAR(200)NOT NULL,
    pays VARCHAR(20)NOT NULL,
    ville VARCHAR(20)NOT NULL,
    adresse VARCHAR(50)NOT NULL,
    cp INT(5)NOT NULL,
    membre_id INT(3) DEFAULT NULL,/*mettre default null sur les fk*/
    photo_id INT(3)DEFAULT NULL,
    categorie_id INT(3)DEFAULT NULL,
    date_enregistrement DATETIME,
    PRIMARY KEY (id_annonce),
    CONSTRAINT fk_annonce_membre/* un nom quont choisis*/
    FOREIGN KEY (membre_id)/* la foreign key sortie*/
    REFERENCES membre(id_membre)/*l entree sur l'autre table et la clef primaire*/
    ON DELETE SET NULL,/*quand il sera effacer il restera le null*/
    CONSTRAINT fk_annonce_photo
    FOREIGN KEY (photo_id)
     REFERENCES photo(id_photo)
     ON DELETE SET NULL,
     CONSTRAINT fk_annonce_categorie
    FOREIGN KEY (categorie_id)
    REFERENCES categorie(id_categorie)
    ON DELETE SET NULL

) ENGINE=INNODB;

CREATE TABLE photo (
    id_photo INT(3) NOT NULL AUTO_INCREMENT,
    photo1 VARCHAR(255)  NOT NULL,
    photo2 VARCHAR(255) NOT NULL,
    photo3 VARCHAR(255) NOT NULL,
    photo4 VARCHAR(255) NOT NULL,
    photo5 VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_photo)
   
) ENGINE=INNODB;

CREATE TABLE categorie (
    id_categorie INT(3) NOT NULL AUTO_INCREMENT,
    titre VARCHAR (255) NOT NULL,
    motcles TEXT NOT NULL,
    PRIMARY KEY (id_categorie)
   
) ENGINE=INNODB;

CREATE TABLE commentaire(
    id_commentaire INT(3) NOT NULL AUTO_INCREMENT,
    membre_id INT (3) NOT NULL,
    motcles TEXT,
    PRIMARY KEY (id_commentaire)

   
) ENGINE=INNODB;


CREATE TABLE note(
    id_note INT(3) NOT NULL AUTO_INCREMENT,
    membre_id1 INT (3)DEFAULT NULL,
    membre_id2 INT (3)DEFAULT NULL,
    note INT(3)NOT NULL,
    AVIS TEXT NOT NULL,
    date_enregistrement DATETIME,
    PRIMARY KEY (id_note),
    CONSTRAINT fk_membreUn
    FOREIGN KEY(membre_id1)
    REFERENCES membre(id_membre)
     ON DELETE SET NULL,
     CONSTRAINT fk_membreDeux
    FOREIGN KEY(membre_id2)
    REFERENCES membre(id_membre)
     ON DELETE SET NULL,

   
) ENGINE=INNODB;



CREATE TABLE membre (
    id_membre INT(3) NOT NULL AUTO_INCREMENT,
    pseudo VARCHAR(20) NOT NULL,
    mdp VARCHAR(60) NOT NULL,
    nom VARCHAR(20) NOT NULL,
    prenom VARCHAR(20),
    telephone VARCHAR(20),
    email VARCHAR(50),
    civilite ENUM('m','f'),
    statut INT(1),
    date_enregistrement DATETIME,
    PRIMARY KEY (id_membre)
   
) ENGINE=INNODB;



