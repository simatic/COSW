-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 15 mai 2021 à 15:03
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
-- Structure de la table `account_request`
--

DROP TABLE IF EXISTS `account_request`;
CREATE TABLE IF NOT EXISTS `account_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'PENDING',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `account_request`
--

INSERT INTO `account_request` (`id`, `first_name`, `last_name`, `email`, `status`) VALUES
(1, 'Albert', 'Einstein', 'albert.einstein@gmail.com', 'PENDING'),
(9, 'Jack', 'O\'Lantern', 'jack.olantern@gmail.com', 'VALIDATED');

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
('DoctrineMigrations\\Version20210323140709', '2021-03-23 14:07:15', 399),
('DoctrineMigrations\\Version20210328101836', '2021-03-28 10:18:48', 1752),
('DoctrineMigrations\\Version20210328121632', '2021-03-28 12:16:48', 1569),
('DoctrineMigrations\\Version20210423100650', '2021-04-23 10:06:53', 2105);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soutenance_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note` double DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1323A575A59B3775` (`soutenance_id`),
  KEY `IDX_1323A575A76ED395` (`user_id`),
  KEY `IDX_1323A575126F525E` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eval_item`
--

DROP TABLE IF EXISTS `eval_item`;
CREATE TABLE IF NOT EXISTS `eval_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soutenance_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `note` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4C29623A126F525E` (`item_id`),
  KEY `IDX_4C29623AA59B3775` (`soutenance_id`),
  KEY `IDX_4C29623AA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eval_item`
--

INSERT INTO `eval_item` (`id`, `soutenance_id`, `user_id`, `item_id`, `note`) VALUES
(1, 6, 11, 12, 2);

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
  PRIMARY KEY (`id`),
  KEY `IDX_1F1B251E3BD38833` (`rubrique_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `rubrique_id`, `nom`, `note`) VALUES
(1, 1, 'Qualité', 20),
(2, 4, 'Qualité intrinsèque de la conceptualisation finition de l\'obje l’appli', 5),
(3, 4, 'Est-ce que l’objet et l’appli répondent à la problématique?', 5),
(4, 4, 'Originalité de l’objet l’appli', 5),
(5, 4, 'Facilité d’utilisation de l\'objet de l’appli', 5),
(6, 6, 'Fond', 10),
(7, 6, 'Forme', 10),
(8, 2, 'Pitch', 20),
(10, 3, 'vidéo', 20),
(11, 7, 'item1', 10),
(12, 7, 'item2', 10),
(13, 8, 'LOL1', 5),
(14, 8, 'LOL2', 5),
(15, 9, 'LOL1', 5),
(16, 9, 'LOL2', 5),
(17, 10, 'LOL1', 5),
(18, 10, 'LOL2', 5),
(19, 13, 'haha', 10),
(20, 13, 'lul', 10),
(21, 14, 'iteeems', 20),
(22, 15, 'iteeems', 10),
(23, 15, 'tezst', 10);

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

DROP TABLE IF EXISTS `modele`;
CREATE TABLE IF NOT EXISTS `modele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modele`
--

INSERT INTO `modele` (`id`, `name`) VALUES
(1, 'Classique'),
(2, 'Iot'),
(3, 'Modele_test'),
(4, 'Hello'),
(5, 'Modele_test7'),
(6, 'Modele_test4'),
(7, 'teste'),
(8, 'testeee'),
(9, 'eeeeeeee'),
(10, 'Modele_testde'),
(11, 'Modele_test8'),
(12, 'Modele_test8'),
(13, 'Modele_test8222'),
(14, 'Modele_test8222'),
(15, 'Modele_test_final'),
(16, 'modeletoto'),
(17, 'Modèle 1'),
(20, 'modelcsv20'),
(21, 'modelcsv20'),
(22, 'csv'),
(23, 'mdele'),
(24, 'amaaaaan'),
(25, 'trah');

-- --------------------------------------------------------

--
-- Structure de la table `modele_item`
--

DROP TABLE IF EXISTS `modele_item`;
CREATE TABLE IF NOT EXISTS `modele_item` (
  `modele_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`modele_id`,`item_id`),
  KEY `IDX_D99C5139AC14B70A` (`modele_id`),
  KEY `IDX_D99C5139126F525E` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modele_item`
--

INSERT INTO `modele_item` (`modele_id`, `item_id`) VALUES
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(13, 7),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 6),
(15, 7),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(16, 6),
(16, 7),
(16, 10),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 11),
(17, 12),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(22, 6),
(22, 7),
(23, 1),
(23, 8),
(23, 10),
(24, 2),
(24, 3),
(24, 4),
(24, 5),
(24, 10);

-- --------------------------------------------------------

--
-- Structure de la table `modele_rubrique`
--

DROP TABLE IF EXISTS `modele_rubrique`;
CREATE TABLE IF NOT EXISTS `modele_rubrique` (
  `modele_id` int(11) NOT NULL,
  `rubrique_id` int(11) NOT NULL,
  PRIMARY KEY (`modele_id`,`rubrique_id`),
  KEY `IDX_E77C377EAC14B70A` (`modele_id`),
  KEY `IDX_E77C377E3BD38833` (`rubrique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modele_rubrique`
--

INSERT INTO `modele_rubrique` (`modele_id`, `rubrique_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 4),
(2, 6),
(3, 1),
(3, 2),
(3, 4),
(4, 4),
(4, 6),
(5, 4),
(5, 6),
(6, 4),
(6, 6),
(7, 4),
(7, 6),
(8, 4),
(9, 4),
(10, 3),
(10, 4),
(10, 6),
(11, 3),
(11, 4),
(11, 6),
(12, 3),
(12, 4),
(12, 6),
(13, 4),
(13, 6),
(14, 4),
(14, 6),
(15, 4),
(15, 6),
(16, 3),
(16, 4),
(16, 6),
(17, 4),
(17, 7),
(20, 11),
(21, 12),
(22, 4),
(22, 6),
(23, 1),
(23, 2),
(23, 3),
(23, 12),
(24, 3),
(24, 4),
(25, 2),
(25, 3);

-- --------------------------------------------------------

--
-- Structure de la table `rubrique`
--

DROP TABLE IF EXISTS `rubrique`;
CREATE TABLE IF NOT EXISTS `rubrique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rubrique`
--

INSERT INTO `rubrique` (`id`, `commentaire`, `nom`) VALUES
(1, '', 'Code'),
(2, '', 'Pitch'),
(3, '', 'Vidéo'),
(4, '', 'Objet connecté'),
(6, '', 'Présentation oral'),
(7, '', 'Rubrique'),
(8, '', 'LOOl'),
(9, '', 'LOOl'),
(10, '', 'LOOl'),
(11, '', 'rubrique111'),
(12, '', 'rubrique111'),
(13, '', 'LOOL'),
(14, '', 'HAHAAHHAHAHA'),
(15, '', 'HAHAAHHAHAHAHEHEHEHEHEH');

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
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_soutenance` datetime NOT NULL,
  `note` double NOT NULL,
  `modele_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4D59FF6E613FECDF` (`session_id`),
  KEY `IDX_4D59FF6EAC14B70A` (`modele_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `soutenance`
--

INSERT INTO `soutenance` (`id`, `session_id`, `titre`, `description`, `image`, `date_soutenance`, `note`, `modele_id`) VALUES
(1, 1, 'Soutenance test', 'Soutenance', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 1),
(2, 1, 'Soutenance test 2', 'Test', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 11),
(3, 1, 'Soutenance test 25', 'dd', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 15),
(4, 1, 'Soutenance test', 'dd', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 15),
(5, 1, 'Soutenance test 1000', 'bla bla', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 16),
(6, 1, 'Soutenance', 'Description', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0, 17);

-- --------------------------------------------------------

--
-- Structure de la table `upload`
--

DROP TABLE IF EXISTS `upload`;
CREATE TABLE IF NOT EXISTS `upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `roles` json NOT NULL COMMENT '(DC2Type:array)',
  `type` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `roles`, `type`, `password`, `username`) VALUES
(1, 'Gibril', 'Gunder', 'gibril.gunder@telecom-sudparis.eu', '{\"0\": \"ROLE_ADMIN\"}', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$SWZjc3h5N2VlSEhpR0FhMg$YzWvqpFOwS2ebtIOcBkdgYKnkCD/XbJBnSy3pBI1W3E', NULL),
(2, 'Michel', 'Simatic', 'michel.simatic@telecom-sudparis.eu', '{\"0\": \"ROLE_CREATOR\"}', 'creator', '$argon2id$v=19$m=65536,t=4,p=1$dGUvMjVhNXJNaVk5dUFxcg$Rd1xjawBLtY2GbdNxT1mjZiR7WHkrqGY5EF68vJWoTM', NULL),
(7, 'John', 'Doe', 'john.doe@gmail.com', '{\"0\": \"ROLE_USER\"}', 'creator', '$argon2id$v=19$m=65536,t=4,p=1$aDlFMkdhN1IvUW9YUjhJcA$xO7gBGxpers0D/ppTD3t3MrddJAvhzQaxQOTR5iiMtA', NULL),
(9, 'Hello', 'World', 'hello.world@gmail.com', '{\"0\": \"ROLE_USER\", \"2\": \"ROLE_CREATOR\"}', 'creator', '$argon2id$v=19$m=65536,t=4,p=1$VVRjcUF0cFBJYXJHdEpsRg$vdaD8mMOCjFUvmuhBT1aKPQUObKlAJWQJ1+Q/RZRe+0', NULL),
(10, 'Zaki', 'Biroum', 'zaki.biroum@telecom-sudparis.eu', '{\"0\": \"ROLE_USER\", \"1\": \"ROLE_ADMIN\"}', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$WW1JUmZraHQ4a3huZ1h5bA$uweXy9doHQKoTDn4Flne2VjZLHqoLPgVx1L9yotS728', NULL),
(11, 'Khalil Mehdi', 'Meziou', 'khalil.meziou@telecom-sudparis.eu', '{\"0\": \"ROLE_USER\", \"1\": \"ROLE_ADMIN\"}', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$UGJzYkhyajRxYmVENGs2bQ$1dD52WNy7+RJBcouaAnVSQgo1Q7qKA4HP4bf+xG3yQA', NULL),
(12, 'Maxime', 'Verchain', 'maxime.verchain@telecom-sudparis.eu', '{\"0\": \"ROLE_USER\", \"1\": \"ROLE_ADMIN\"}', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$RG5tVjk3UVhqT28yWGxRbw$DYNFBDJwuHBU1xc8obK0wMhfPEpktEsl27l1s2BaTOc', NULL),
(13, 'a', 'b', 'a.b@hello.com', '{\"0\": \"ROLE_USER\", \"2\": \"ROLE_CREATOR\"}', 'creator', '$argon2id$v=19$m=65536,t=4,p=1$bVM4cHZlVWZZb1Q4N3pBdg$f0wbACFFZqLhjTV1jkMFNpaHx8kvELFw2HWAFa5XShY', NULL),
(14, 'khalil', 'meziou', 'khalilmeziou@yahoo.fr', '{\"0\": \"ROLE_USER\", \"2\": \"ROLE_ADMIN\"}', 'creator', '$argon2i$v=19$m=65536,t=4,p=1$YWF0Lnhvd1pRa0pWeHp0Sw$RjGVi6Ps6e/HSMvyhxpZjh2apqyf9RY2bPCcSNVsob8', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BCA59B3775` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenance` (`id`);

--
-- Contraintes pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `FK_1323A575126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_1323A575A59B3775` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenance` (`id`);

--
-- Contraintes pour la table `eval_item`
--
ALTER TABLE `eval_item`
  ADD CONSTRAINT `FK_4C29623A126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_4C29623AA59B3775` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenance` (`id`);

--
-- Contraintes pour la table `fiche_evaluation`
--
ALTER TABLE `fiche_evaluation`
  ADD CONSTRAINT `FK_BD75A182A59B3775` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenance` (`id`);

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_1F1B251E3BD38833` FOREIGN KEY (`rubrique_id`) REFERENCES `rubrique` (`id`);

--
-- Contraintes pour la table `modele_item`
--
ALTER TABLE `modele_item`
  ADD CONSTRAINT `FK_D99C5139126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D99C5139AC14B70A` FOREIGN KEY (`modele_id`) REFERENCES `modele` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `modele_rubrique`
--
ALTER TABLE `modele_rubrique`
  ADD CONSTRAINT `FK_E77C377E3BD38833` FOREIGN KEY (`rubrique_id`) REFERENCES `rubrique` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E77C377EAC14B70A` FOREIGN KEY (`modele_id`) REFERENCES `modele` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `soutenance`
--
ALTER TABLE `soutenance`
  ADD CONSTRAINT `FK_4D59FF6E613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `FK_4D59FF6EAC14B70A` FOREIGN KEY (`modele_id`) REFERENCES `modele` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
