-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 26 jan. 2023 à 23:40
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `volley`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `email` varchar(75) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `email`, `mdp`) VALUES
(0, 'kewin@gmail.com', '$2y$10$f.s6ZdOrBz/8kHn2FB1zR.IU.pIJ2upqQKOc27zyeJoii1oT3YXz2');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `numLicense` char(10) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `taille` int(11) DEFAULT NULL,
  `poids` varchar(50) DEFAULT NULL,
  `postePrefere` varchar(50) DEFAULT NULL,
  `commentaire` varchar(50) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`numLicense`, `nom`, `dateNaissance`, `prenom`, `photo`, `taille`, `poids`, `postePrefere`, `commentaire`, `statut`) VALUES
('10', 'Shoyo', '2002-02-09', 'Hinata', 'uploads/photoJoueur/Hinata.png', 180, '70', 'Attaquant', 'Excellent joueur', 'Actif'),
('11', 'Kageyama', '2003-06-04', 'Tobio', 'uploads/photoJoueur/kageyama.png', 190, '85', 'Defenseur', 'Joueur équilibré', 'Actif'),
('12', 'Tanaka', '2001-06-06', 'Ryunosuke', 'uploads/photoJoueur/tanaka.png', 195, '90', 'Attaquant', 'Tres bon', 'Actif'),
('13', 'Azumane', '2002-07-25', 'Asahi', 'uploads/photoJoueur/Azumane.png', 200, '90', 'Defenseur', 'Un mur', 'Actif'),
('14', 'Sugawara', '2003-12-15', 'Koshi', 'uploads/photoJoueur/sugawara.png', 170, '65', 'Attaquant', 'Tres rapide', 'Actif'),
('15', 'Kazuhito', '2001-05-25', 'Narita', 'uploads/photoJoueur/Kazuhito.png', 185, '75', 'Attaquant', 'En forme en ce moment', 'Actif'),
('16', 'Tadashi', '2003-11-17', 'Yamaguchi', 'uploads/photoJoueur/tadashi.png', 173, '60', 'Attaquant', 'Bon', 'Blessé');

-- --------------------------------------------------------

--
-- Structure de la table `matchvolley`
--

CREATE TABLE `matchvolley` (
  `id_match` int(11) NOT NULL,
  `dateMatch` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `equipeAdverse` varchar(50) DEFAULT NULL,
  `Domicile` tinyint(1) DEFAULT NULL,
  `resultatDomicile` char(1) DEFAULT NULL,
  `resultatExterieur` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matchvolley`
--

INSERT INTO `matchvolley` (`id_match`, `dateMatch`, `heure`, `equipeAdverse`, `Domicile`, `resultatDomicile`, `resultatExterieur`) VALUES
(4, '2023-03-21', '16:00:00', 'Tournefeuille', 1, NULL, NULL),
(5, '2023-01-25', '19:00:00', 'Castanet', 1, '3', '1');

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

CREATE TABLE `participer` (
  `numLicense` char(10) NOT NULL,
  `id_match` int(11) NOT NULL,
  `notation` int(11) DEFAULT NULL,
  `titulaire` tinyint(1) DEFAULT NULL,
  `posteMatch` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participer`
--

INSERT INTO `participer` (`numLicense`, `id_match`, `notation`, `titulaire`, `posteMatch`) VALUES
('10', 4, NULL, 1, NULL),
('11', 4, NULL, 1, NULL),
('12', 4, NULL, 1, NULL),
('13', 4, NULL, 1, NULL),
('14', 4, NULL, 1, NULL),
('15', 4, NULL, 1, NULL),
('16', 4, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `setdesmatch`
--

CREATE TABLE `setdesmatch` (
  `id_set` int(11) NOT NULL,
  `numeroSet` char(1) NOT NULL,
  `resultatDomicile` int(11) NOT NULL,
  `resultatExterieur` int(11) NOT NULL,
  `id_match` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `setdesmatch`
--

INSERT INTO `setdesmatch` (`id_set`, `numeroSet`, `resultatDomicile`, `resultatExterieur`, `id_match`) VALUES
(14, '1', 25, 20, 5),
(15, '2', 15, 25, 5),
(16, '3', 25, 10, 5),
(17, '4', 25, 5, 5);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`numLicense`);

--
-- Index pour la table `matchvolley`
--
ALTER TABLE `matchvolley`
  ADD PRIMARY KEY (`id_match`);

--
-- Index pour la table `participer`
--
ALTER TABLE `participer`
  ADD PRIMARY KEY (`numLicense`,`id_match`) USING BTREE,
  ADD KEY `id_match` (`id_match`),
  ADD KEY `numLicense` (`numLicense`);

--
-- Index pour la table `setdesmatch`
--
ALTER TABLE `setdesmatch`
  ADD PRIMARY KEY (`id_set`),
  ADD KEY `id_match` (`id_match`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `matchvolley`
--
ALTER TABLE `matchvolley`
  MODIFY `id_match` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `setdesmatch`
--
ALTER TABLE `setdesmatch`
  MODIFY `id_set` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participer`
--
ALTER TABLE `participer`
  ADD CONSTRAINT `participer_ibfk_1` FOREIGN KEY (`numLicense`) REFERENCES `joueur` (`numLicense`),
  ADD CONSTRAINT `participer_ibfk_2` FOREIGN KEY (`id_match`) REFERENCES `matchvolley` (`id_match`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
