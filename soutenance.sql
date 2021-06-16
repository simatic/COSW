-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 16 juin 2021 à 09:47
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
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F2BC9BD7E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BCA59B3775` (`soutenance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `soutenance_id`, `auteur`, `contenu`) VALUES
(4, 1, 'khalilmeziou@yahoo.fr', 'Bien');

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
('DoctrineMigrations\\Version20210525114254', '2021-05-25 11:43:27', 24253),
('DoctrineMigrations\\Version20210530124412', '2021-05-30 12:44:15', 331),
('DoctrineMigrations\\Version20210612192104', '2021-06-12 19:21:20', 598),
('DoctrineMigrations\\Version20210613112945', '2021-06-13 11:29:50', 431),
('DoctrineMigrations\\Version20210614093232', '2021-06-14 09:32:41', 331),
('DoctrineMigrations\\Version20210614093311', '2021-06-14 09:33:22', 412),
('DoctrineMigrations\\Version20210616093738', '2021-06-16 09:37:49', 575);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soutenance_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `note` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1323A575A59B3775` (`soutenance_id`),
  KEY `IDX_1323A575A76ED395` (`user_id`),
  KEY `IDX_1323A575126F525E` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evaluation`
--

INSERT INTO `evaluation` (`id`, `soutenance_id`, `user_id`, `item_id`, `note`) VALUES
(1, 3, 14, 2, 3),
(2, 3, 14, 3, 3),
(3, 3, 14, 4, 3),
(4, 3, 14, 5, 3),
(5, 3, 14, 6, 6),
(6, 3, 14, 7, 6),
(7, 7, 14, 2, 4),
(8, 7, 14, 3, 3.5),
(9, 7, 14, 4, 3),
(10, 7, 14, 5, 2.5),
(11, 7, 14, 6, 5),
(12, 7, 14, 7, 9),
(13, 1, 9, 2, 3),
(14, 1, 9, 3, 3),
(15, 1, 9, 4, 3),
(16, 1, 9, 5, 3),
(17, 1, 9, 6, 6),
(18, 1, 9, 7, 6),
(19, 1, 10, 2, 4.5),
(20, 1, 10, 3, 4.5),
(21, 1, 10, 4, 4.5),
(22, 1, 10, 5, 4.5),
(23, 1, 10, 6, 9),
(24, 1, 10, 7, 9),
(25, 1, 2, 2, 2.5),
(26, 1, 2, 3, 2.5),
(27, 1, 2, 4, 2.5),
(28, 1, 2, 5, 2.5),
(29, 1, 2, 6, 5),
(30, 1, 2, 7, 5),
(31, 1, 14, 2, 2.5),
(32, 1, 14, 3, 2.5),
(33, 1, 14, 4, 2.5),
(34, 1, 14, 5, 2.5),
(35, 1, 14, 6, 5),
(36, 1, 14, 7, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`id`, `rubrique_id`, `nom`, `note`) VALUES
(1, 1, 'Qualité', 100),
(2, 4, 'Qualité intrinsèque de la conceptualisation finition de l\'obje l’appli', 25),
(3, 4, 'Est-ce que l’objet et l’appli répondent à la problématique?', 25),
(4, 4, 'Originalité de l’objet l’appli', 25),
(5, 4, 'Facilité d’utilisation de l\'objet de l’appli', 25),
(6, 6, 'Fond', 50),
(7, 6, 'Forme', 50),
(8, 2, 'Pitch', 100),
(10, 3, 'vidéo', 100),
(11, 7, 'item1', 50),
(12, 7, 'item2', 50),
(24, 16, 'Adéquation entre le sujet du projet et la réponse des étudiants :', 50),
(25, 16, 'Maîtrise technique sur les points clés', 50),
(26, 17, 'Fond', 35),
(27, 17, 'Forme', 35),
(28, 17, 'Support', 30);

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

DROP TABLE IF EXISTS `modele`;
CREATE TABLE IF NOT EXISTS `modele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modele`
--

INSERT INTO `modele` (`id`, `name`) VALUES
(1, 'Classique'),
(2, 'Iot'),
(10, 'Modele_testde'),
(15, 'Modele_test_final'),
(16, 'modeletoto'),
(17, 'Modèle 1'),
(20, 'modelcsv20'),
(21, 'modelcsv20'),
(22, 'csv'),
(23, 'mdele'),
(24, 'modele_soutenance');

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
(24, 24),
(24, 25),
(24, 26),
(24, 27),
(24, 28);

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
(10, 3),
(10, 4),
(10, 6),
(15, 4),
(15, 6),
(16, 3),
(16, 4),
(16, 6),
(17, 4),
(17, 7),
(22, 4),
(22, 6),
(23, 1),
(23, 2),
(23, 3),
(24, 16),
(24, 17);

-- --------------------------------------------------------

--
-- Structure de la table `rubrique`
--

DROP TABLE IF EXISTS `rubrique`;
CREATE TABLE IF NOT EXISTS `rubrique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rubrique`
--

INSERT INTO `rubrique` (`id`, `nom`) VALUES
(1, 'Code'),
(2, 'Pitch'),
(3, 'Vidéo'),
(4, 'Objet connecté'),
(6, 'Présentation oral'),
(7, 'Rubrique'),
(16, 'Appréciation du résultat du projet (sur la base de la soutenance orale finale)'),
(17, 'Appréciation de la soutenance orale finale');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `liste_etudiant` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `liste_jury` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte_mail_etudiant` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte_mail_jury` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `date_debut`, `date_fin`, `nom`, `description`, `liste_etudiant`, `liste_jury`, `texte_mail_etudiant`, `texte_mail_jury`, `uid`) VALUES
(1, '2016-01-01 00:00:00', '2016-01-01 00:00:00', 'Session 1', 'Description', 'nom,prenom,courriel,groupe\r\nNom1,Prenom1,Courriel1,Groupe1\r\nNom2,Prenom2,Courriel2,Groupe1\r\nNom3,Prenom3,Courriel3,Groupe2\r\nNom4,Prenom4,Courriel4,Groupe2\r\n', '\r\n', '{{Balise 1}} exemple de mail', '', '3692ad5a1948713f3ea98179984fe34ffb30bc64');

-- --------------------------------------------------------

--
-- Structure de la table `session_user`
--

DROP TABLE IF EXISTS `session_user`;
CREATE TABLE IF NOT EXISTS `session_user` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`session_id`,`user_id`),
  KEY `IDX_4BE2D663613FECDF` (`session_id`),
  KEY `IDX_4BE2D663A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `soutenance`
--

DROP TABLE IF EXISTS `soutenance`;
CREATE TABLE IF NOT EXISTS `soutenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) DEFAULT NULL,
  `modele_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_soutenance` datetime NOT NULL,
  `note` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4D59FF6E613FECDF` (`session_id`),
  KEY `IDX_4D59FF6EAC14B70A` (`modele_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `soutenance`
--

INSERT INTO `soutenance` (`id`, `session_id`, `modele_id`, `titre`, `description`, `image`, `date_soutenance`, `note`) VALUES
(1, 1, 15, 'Soutenance 1', 'Soutenance', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(2, 1, 15, 'Soutenance 2', 'Test', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(3, 1, 15, 'Soutenance 3', 'dd', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(4, NULL, 15, 'Soutenance 4', 'dd', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(5, NULL, 16, 'Soutenance 5', 'bla bla', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(6, NULL, 17, 'Soutenance 6', 'Description', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(7, 1, 15, 'Soutenance test 4', 'Description', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0);

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
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D5428AEDE7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `roles`, `type`, `password`, `username`, `uid`) VALUES
(1, 'Gibril', 'Gunder', 'gibril.gunder@telecom-sudparis.eu', '{\"0\": \"ROLE_ADMIN\"}', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$SWZjc3h5N2VlSEhpR0FhMg$YzWvqpFOwS2ebtIOcBkdgYKnkCD/XbJBnSy3pBI1W3E', NULL, 'f48e0d32ecfc030cb4199e5d6cbee13ce235f3bd'),
(2, 'Michel', 'Simatic', 'michel.simatic@telecom-sudparis.eu', '{\"0\": \"ROLE_CREATOR\"}', 'creator', '$argon2id$v=19$m=65536,t=4,p=1$dGUvMjVhNXJNaVk5dUFxcg$Rd1xjawBLtY2GbdNxT1mjZiR7WHkrqGY5EF68vJWoTM', NULL, '8b80abf6b2064894fae6b47cfe5fc718b2c162b5'),
(7, 'John', 'Doe', 'john.doe@gmail.com', '{\"0\": \"ROLE_USER\"}', 'creator', '$argon2id$v=19$m=65536,t=4,p=1$aDlFMkdhN1IvUW9YUjhJcA$xO7gBGxpers0D/ppTD3t3MrddJAvhzQaxQOTR5iiMtA', NULL, '86867d90eb86ab3d74247b60e52ba331d8058d46'),
(9, 'Hello', 'World', 'hello.world@gmail.com', '{\"0\": \"ROLE_USER\", \"2\": \"ROLE_CREATOR\"}', 'creator', '$argon2id$v=19$m=65536,t=4,p=1$VVRjcUF0cFBJYXJHdEpsRg$vdaD8mMOCjFUvmuhBT1aKPQUObKlAJWQJ1+Q/RZRe+0', NULL, '912f30bf082c10368bba2ec23a94c36019fc013e'),
(10, 'Zaki', 'Biroum', 'zaki.biroum@telecom-sudparis.eu', '{\"0\": \"ROLE_USER\", \"1\": \"ROLE_ADMIN\"}', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$WW1JUmZraHQ4a3huZ1h5bA$uweXy9doHQKoTDn4Flne2VjZLHqoLPgVx1L9yotS728', NULL, 'efe0b0e16b8e1d4e3266c05083b4f1922b0d0646'),
(11, 'Khalil Mehdi', 'Meziou', 'khalil.meziou@telecom-sudparis.eu', '{\"0\": \"ROLE_USER\", \"1\": \"ROLE_ADMIN\"}', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$UGJzYkhyajRxYmVENGs2bQ$1dD52WNy7+RJBcouaAnVSQgo1Q7qKA4HP4bf+xG3yQA', NULL, '7244b14c8a9a12fd1438a87b0ce612bb032bb130'),
(12, 'Maxime', 'Verchain', 'maxime.verchain@telecom-sudparis.eu', '{\"0\": \"ROLE_USER\", \"1\": \"ROLE_ADMIN\"}', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$RG5tVjk3UVhqT28yWGxRbw$DYNFBDJwuHBU1xc8obK0wMhfPEpktEsl27l1s2BaTOc', NULL, 'e9d0f5d7e974102872ac042051f9848b605fd235'),
(13, 'a', 'b', 'a.b@hello.com', '{\"0\": \"ROLE_USER\", \"2\": \"ROLE_CREATOR\"}', 'creator', '$argon2id$v=19$m=65536,t=4,p=1$bVM4cHZlVWZZb1Q4N3pBdg$f0wbACFFZqLhjTV1jkMFNpaHx8kvELFw2HWAFa5XShY', NULL, '140d9aaa6cf184e164d2b2e64437dba0522a67a1'),
(14, 'khalil', 'meziou', 'khalilmeziou@yahoo.fr', '{\"0\": \"ROLE_USER\", \"2\": \"ROLE_ADMIN\"}', 'creator', '$argon2i$v=19$m=65536,t=4,p=1$YWF0Lnhvd1pRa0pWeHp0Sw$RjGVi6Ps6e/HSMvyhxpZjh2apqyf9RY2bPCcSNVsob8', NULL, '1d4fa90c600fb390b37409e2651e404de6049a01');

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
  ADD CONSTRAINT `FK_1323A575A59B3775` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenance` (`id`),
  ADD CONSTRAINT `FK_1323A575A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
-- Contraintes pour la table `session_user`
--
ALTER TABLE `session_user`
  ADD CONSTRAINT `FK_4BE2D663613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4BE2D663A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
