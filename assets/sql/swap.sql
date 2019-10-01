-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 24 sep. 2019 à 16:08
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `swap`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

DROP TABLE IF EXISTS `annonce`;
CREATE TABLE IF NOT EXISTS `annonce` (
  `id_annonce` int(3) NOT NULL AUTO_INCREMENT,
  `titreA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_courte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_longue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` float NOT NULL,
  `pays` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` int(5) NOT NULL,
  `membre_id` int(3) DEFAULT NULL,
  `photo_id` int(3) DEFAULT NULL,
  `categorie_id` int(3) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_annonce`),
  KEY `fk_annonce_membre` (`membre_id`),
  KEY `fk_annonce_photo` (`photo_id`),
  KEY `fk_annonce_categorie` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titreA`, `description_courte`, `description_longue`, `prix`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`, `date_enregistrement`) VALUES
(1, 'Mon annonce', 'Voiture à vendre', 'Je vends ma voiture, j\'ai roulé juste 1 an avec donc cassez pas les couilles.', 2000, 'France', 'Suresnes', '9 allée des orangers', 92150, NULL, 1, 56, '2019-09-10 17:27:00'),
(2, 'Développeur web', 'Emploi', 'Jerecherche un emploie de développeur web', 500, 'France', 'Dunkerque', '9 allée des orangers', 92150, 25, 2, 55, '2019-09-10 17:29:00'),
(3, 'Titre', 'Description Courte fsdfdsfd', 'Description Longuefdsfdsfdsfsdfdsf sdfdsfsdfsdfsdfsdfd sdfdsfdsfdsf', 1000, 'France', 'Suresnes', '9 allÃ©e des orangers', 92150, NULL, NULL, NULL, '2019-09-14 17:17:36'),
(4, 'Nouvelle annonce', 'dqfqdsfqdsfqdsfqdsfqdsf', 'sdfqdsfqdsfqdsfqdsfqdsfqdsfqdsf', 315, 'qsdfqdsf', 'qsdfqdsf', 'qsd dsfq sdf qsd', 77546, NULL, 31, 60, '2019-09-14 17:31:28'),
(5, 'dsfdsfdsf', 'dsfdsfsdfsd', 'dsfdsfsdf', 50, 'dfsdfdsf', 'dsfdsfdsf', 'fsdfdsfdsfds', 92150, NULL, 35, 55, '2019-09-15 20:41:00'),
(6, 'TÃ©lÃ©phone', 'Je vend mon tÃ©lephone', 'Je vends mon iphone 10', 500, 'France', 'Suresnes', '9 allÃ©e des orangers', 92150, NULL, 36, 59, '2019-09-17 16:16:08'),
(7, 'Smartphone', 'Je vends mon smartphone', 'Je vend mon samsung s8 quasiment neuf', 600, 'France', 'Suresnes', '9 allée des orangers', 92150, 28, 37, 59, '2019-09-22 15:38:27');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int(3) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motcles` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motcles`) VALUES
(55, 'Emploi', 'Offres d\'emploi'),
(56, 'Véhicule', 'Voiture, Motos, Bateaux, Vélos, Equipement'),
(57, 'Immobilier', 'Ventes, Locations, Colocations, Bureaux, Logement'),
(58, 'Vacances', 'Camping, Hôtels, Hôte'),
(59, 'Multimedia', 'Jeux vidéos, Informatique, Image, Son, Téléphone'),
(60, 'Loisirs', 'Films,  Musique, Livres'),
(61, 'Materiel', 'Outillage, Fourniture de bureau, Matériel Agricole, ...'),
(62, 'Services', 'Prestations de services, Evénements, ...'),
(63, 'Maison', 'Ameublement, ElectromÃ©nager, Bricolage, Jardinage, ...'),
(64, 'Vetements', 'Jean, Chemise, Robe, Chaussure, ...'),
(65, 'Autres', '...');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(3) NOT NULL AUTO_INCREMENT,
  `membre_id` int(3) NOT NULL,
  `motcles` text COLLATE utf8mb4_unicode_ci,
  `annonce_id` int(3) NOT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_commentaire`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `membre_id`, `motcles`, `annonce_id`, `date_enregistrement`) VALUES
(2, 25, 'Je suis Ã  votre disposition pour tout demande', 2, '2019-09-17 17:19:54');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `civilite` enum('m','f') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` int(1) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(25, 'Brittany', '$2y$10$6QWLifbQhG24J0FCM.Z.Auu4/dFv/aHqQPpy/niF7wHlyY/jWaLYa', 'Lugemba', 'Brittany', '066666666', 'Brit@hotmail.fr', 'f', 1, '2019-09-16 20:14:30'),
(26, 'Britt', '$2y$10$StMQetMmknakYU1fJNHkAe28.wsZhQ0.ONmnh33shH0cYfMO9EOSu', 'Ines', 'Brittany', '0669696969', 'Britt@hotmail.fr', 'm', 0, '2019-09-16 20:17:44'),
(28, 'Admin1', '$2y$10$3tL/Xz6NaWHrnMCtZj/.HeZddd9D.8tenqk6TLgK/vRFATwuxon4K', 'Fouchal', 'Sami', '0649716105', 'samy_fouchal@hotmail.fr', 'm', 1, '2019-09-22 12:14:41'),
(29, 'Admin2', '$2y$10$GjcAA77JvzawgBJHD0Y.0eQFXKmQE8IpS0nL1TQjSikt1F5cf9MsG', 'Cvoric', 'Svetlana', '0649716100', 'cvoricsvetlana@hotmail.fr', 'f', 0, '2019-09-22 13:51:02');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int(3) NOT NULL AUTO_INCREMENT,
  `membre_id1` int(3) DEFAULT NULL,
  `membre_id2` int(3) DEFAULT NULL,
  `etoile` int(3) NOT NULL,
  `avis` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  PRIMARY KEY (`id_note`),
  KEY `fk_membreUn` (`membre_id1`),
  KEY `fk_membreDeux` (`membre_id2`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id_note`, `membre_id1`, `membre_id2`, `etoile`, `avis`, `date_enregistrement`) VALUES
(2, 26, 25, 2, 'L\'un des meilleurs vendeur !', '2019-09-21 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int(3) NOT NULL AUTO_INCREMENT,
  `photo1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo5` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`) VALUES
(1, '7668bba0992501c94316952a6d626a3c.jpg', '7668bba0992501c94316952a6d626a3c.jpg', '7668bba0992501c94316952a6d626a3c.jpg', '7668bba0992501c94316952a6d626a3c.jpg', '7668bba0992501c94316952a6d626a3c.jpg'),
(2, 'd5294deebf934d12c594ca62f10db327.jpg', 'd5294deebf934d12c594ca62f10db327.jpg', 'd5294deebf934d12c594ca62f10db327.jpg', 'd5294deebf934d12c594ca62f10db327.jpg', 'd5294deebf934d12c594ca62f10db327.jpg'),
(22, '71882f048ecf110614015090acbe5199.jpg', '71882f048ecf110614015090acbe5199.jpg', '71882f048ecf110614015090acbe5199.jpg', '71882f048ecf110614015090acbe5199.jpg', '71882f048ecf110614015090acbe5199.jpg'),
(23, '1509505391c6c25507b5ca41d44cc5e7.jpg', '1509505391c6c25507b5ca41d44cc5e7.jpg', '1509505391c6c25507b5ca41d44cc5e7.jpg', '1509505391c6c25507b5ca41d44cc5e7.jpg', '1509505391c6c25507b5ca41d44cc5e7.png'),
(24, '067a6f8b1301af87683e36e2d5f7a614.jpg', 'e0d426073dd701dc69993c4257b348b3.png', 'd5f7224fc5efe9b54a70c52a17862739.jpg', 'dc65027963fd29e8f2e18c3cf099589f.jpg', '7a7e0af50ff4a2c4e1ed7f70ca1ad8e7.jpg'),
(25, '488fde5f01c28e4d857f22d571882270.jpg', '88a4ffb9eaff5b9f56c24a76b77db08d.jpg', '8ad406089be36322a3a02f502a7b41c4.jpg', '2dd69811e17ce0e18374b0dc99d9acd1.jpg', '0f3f9db973a99758068975c1fd7fe228.jpg'),
(26, '102426845cbfc5753b1fa142d9255306.jpg', '1f2710a99cda0b7f943b01af11dc62cd.jpg', '2652062eb4abba7a20987dc54654fc82.jpg', '3c9853969f97c660a73ad5104dac2a98.jpg', '170ee9ee769c44133b883dacca108f8e.jpg'),
(27, '1aae70e15e5c90e686fd4daea52f8025.jpg', '48fc91ec449a3527672bee11acc0ef22.jpg', '1ee3b335830f0fc2b5e2ec6c8e57e3fe.jpg', 'a0b6abfd19116da9d47ab438f8495a8c.jpg', '3e1d6888755ece1f9dd6d6fe22e2bf72.jpg'),
(28, '00966b6355b242f8caac22979e9f5b8f.jpg', 'a8b0f70985baf2a03a46337cfa5803ec.jpg', 'a86c9bdae4105456c6afad3a3ebf431b.jpg', 'a3364813671d1d6eea99d11a08d461bb.jpg', '5c2eaa56b3a81ac318fdfe320cf4e3a6.jpg'),
(29, '1dad3d195281cb9499bf4bdad6ad72ed.jpg', '9f00ca9254d55fe6007a89c62f9d46f7.jpg', 'bbf704eff6ebaccfb87dc23208e2bb83.jpg', 'a0f3b9311440659b8041a19372b9c7af.jpg', 'ec213fc78700b462e8dae4affe0e95bc.jpg'),
(30, '545f41201b33659102918f58ef278347.jpg', 'f1bdfd6f61b05a8d3660c1b733ed1742.jpg', 'e809bfba6cbae939da3d50035cd9b28e.jpg', 'dfbcb45f42644ee5d0dfaccb27d73797.jpg', 'a7e32d0bd9febf588b9c53c70dbdb633.jpg'),
(31, 'a541c01b83ae45dbc94fd642f976cf52.jpg', '249438ee58753117b0c2c0ee5150a720.jpg', 'ac2ce720bb153ec79c6a6d37487a0e84.jpg', 'b5330c8c498b2fecec59aa9a5033d8d7.jpg', '7ffae3960e7a19cb95faeff0a0a650d6.jpg'),
(32, '25d43477ca8c95feb072ed5636dfb118.jpg', '687ff32b53d2c40d27080325d2847f12.jpg', '6c4006898748bf2e2572753a0d52ebab.png', '4095cc6e4c4aeaa0b29bc83d97640d1c.jpg', '106a5614d7c9dda664993819dd8df049.jpg'),
(33, 'ce540492c744e0670f15f40acc7d982c.jpg', '32d97691b6f7cafe5bdb0b049650af7b.jpg', '47605963434dcf8a862803a221c0f112.png', '0d8b2e34727a9e7d99eba81401a6fff3.jpg', 'dba60043c34b89238db8acb2db649a0f.jpg'),
(34, '5d505cbe9ed3db8fe30330dfc002d250.jpg', 'cb6e51eeb1c4a3a5dd10098a229b77b3.jpg', 'a22832fecbbac131c3dfc2420df24a6e.png', '54da54395e6aadd77ca639476be4149a.jpg', 'f85fcc7692f4038444568e130f60bf19.jpg'),
(35, 'adfb11dd3494d11bd75634e3f6246b70.jpg', 'b829ab4a12bd9c101ba60701f053dc2b.jpg', '58f817d740989dbfbc7decda4ac2dd09.jpg', '13cec118d824243c1afa0b3eb4b4f8de.jpg', 'db28038d2db3c47a4a746cb53e680230.jpg'),
(36, '18e65cdd86aa1c1bf6ed28e5fc138437.jpg', '41e1c63f644cd2655bbb508011a1e93c.jpg', 'ada37732740efd2d360d49c61636687f.jpg', '42f8bce2dbb0f8b23ecd401b99a92098.jpg', '7d8fc13315bcbb42e2dc67d43f28a5de.jpg'),
(37, '8e9e37bab471465557285e3f011cc8f2.jpg', 'ce3ee8ea342bfde5d2c4d74bae0b0e35.jpg', '319d696bf9fc6e8d8d4d7940eedbfd97.jpg', 'e219f2e177c6521832e425a289995401.jpg', 'cccb76fce54c18c880bfaf41def56053.jpg');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `fk_annonce_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_annonce_membre` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_annonce_photo` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`) ON DELETE SET NULL;

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `fk_membreDeux` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_membreUn` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
