-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 10 sep. 2019 à 10:40
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.3.7

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
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motcles` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motcles`) VALUES
(55, 'Emploi', 'Offres d\'emploi'),
(56, 'Vehicule', 'Voiture, Motos, Bateaux, VÃ©los, Equipement'),
(57, 'Immobilier', 'Ventes, Locations, Colocations, Bureaux, Logement'),
(58, 'Vacances', 'Camping, HÃ´tels, HÃ´te'),
(59, 'Multimedia', 'Jeux vidÃ©os, Informatique, Image, Son, TÃ©lÃ©phone'),
(60, 'Loisirs', 'Films,  Musique, Livres'),
(61, 'Materiel', 'Outillage, Fourniture de bureau, MatÃ©riel Agricole, ...'),
(62, 'Services', 'Prestations de services, EvÃ©nements, ...'),
(63, 'Maison', 'Ameublement, ElectromÃ©nager, Bricolage, Jardinage, ...'),
(64, 'Vetements', 'Jean, Chemise, Robe, Chaussure, ...'),
(65, 'Autres', '...');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
