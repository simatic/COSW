-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 27 mars 2021 à 09:44
-- Version du serveur :  5.7.31
-- Version de PHP : 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `soutenance`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soutenance_id` int(11) NOT NULL,
  `auteur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BCA59B3775` (`soutenance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210323140152', '2021-03-23 14:04:39', 485),
('DoctrineMigrations\\Version20210323140709', '2021-03-23 14:07:15', 399);

-- --------------------------------------------------------

--
-- Structure de la table `fiche_evaluation`
--

DROP TABLE IF EXISTS `fiche_evaluation`;
CREATE TABLE IF NOT EXISTS `fiche_evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluateur_id` int(11) DEFAULT NULL,
  `soutenance_id` int(11) DEFAULT NULL,
  `note_final` double NOT NULL,
  `ponderation` double NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BD75A182231F139` (`evaluateur_id`),
  KEY `IDX_BD75A182A59B3775` (`soutenance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fiche_evaluation`
--

INSERT INTO `fiche_evaluation` (`id`, `evaluateur_id`, `soutenance_id`, `note_final`, `ponderation`, `nom`) VALUES
(1, 11, 1, 0, 1, 'Fiche 1');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rubrique_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` double NOT NULL,
  `bareme` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F1B251E3BD38833` (`rubrique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `rubrique_id`, `nom`, `note`, `bareme`) VALUES
(1, 1, 'Qualité', 0, 5);

-- --------------------------------------------------------

--
-- Structure de la table `rubrique`
--

DROP TABLE IF EXISTS `rubrique`;
CREATE TABLE IF NOT EXISTS `rubrique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fiche_evaluation_id` int(11) DEFAULT NULL,
  `commentaire` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8FA4097C13830278` (`fiche_evaluation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rubrique`
--

INSERT INTO `rubrique` (`id`, `fiche_evaluation_id`, `commentaire`, `nom`) VALUES
(1, 1, '', 'Code');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `date`, `nom`) VALUES
(1, '2016-01-01 00:00:00', 'Session du 05/05/2021');

-- --------------------------------------------------------

--
-- Structure de la table `soutenance`
--

DROP TABLE IF EXISTS `soutenance`;
CREATE TABLE IF NOT EXISTS `soutenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) DEFAULT NULL,
  `fiche_evaluation_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_soutenance` datetime NOT NULL,
  `note` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4D59FF6E613FECDF` (`session_id`),
  KEY `IDX_4D59FF6E13830278` (`fiche_evaluation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `soutenance`
--

INSERT INTO `soutenance` (`id`, `session_id`, `fiche_evaluation_id`, `titre`, `description`, `image`, `date_soutenance`, `note`) VALUES
(1, 1, NULL, 'Soutenance test', 'Soutenance', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `role`) VALUES
(9, 'toto', '$argon2i$v=19$m=65536,t=4,p=1$QUVsZUsuUlhvdGFpZ09CUA$fNrMFlYBdymfYLeSk19twvDt2VFwNdZGJI4JsI9oRPg', 'toto@gmail.com', 'a:1:{i:0;s:9:\"ROLE_USER\";}'),
(11, 'khalil', '$argon2i$v=19$m=65536,t=4,p=1$bHZUb2dKemhwaDcuczVXSw$iwrscjYjgA4JzAXPpu7M2Ti41Bkj6OdS/KjnwGOQc4Q', 'khalil.meziou@telecom-sudparis.eu', 'a:2:{i:0;s:10:\"ROLE_ADMIN\";i:1;s:9:\"ROLE_USER\";}');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BCA59B3775` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenance` (`id`);

--
-- Contraintes pour la table `fiche_evaluation`
--
ALTER TABLE `fiche_evaluation`
  ADD CONSTRAINT `FK_BD75A182231F139` FOREIGN KEY (`evaluateur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_BD75A182A59B3775` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenance` (`id`);

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_1F1B251E3BD38833` FOREIGN KEY (`rubrique_id`) REFERENCES `rubrique` (`id`);

--
-- Contraintes pour la table `rubrique`
--
ALTER TABLE `rubrique`
  ADD CONSTRAINT `FK_8FA4097C13830278` FOREIGN KEY (`fiche_evaluation_id`) REFERENCES `fiche_evaluation` (`id`);

--
-- Contraintes pour la table `soutenance`
--
ALTER TABLE `soutenance`
  ADD CONSTRAINT `FK_4D59FF6E13830278` FOREIGN KEY (`fiche_evaluation_id`) REFERENCES `fiche_evaluation` (`id`),
  ADD CONSTRAINT `FK_4D59FF6E613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
