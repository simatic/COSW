-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 31 mai 2021 à 19:31
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.11

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

CREATE TABLE `account_request` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `soutenance_id` int(11) NOT NULL,
  `auteur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210525114254', '2021-05-25 11:43:27', 24253),
('DoctrineMigrations\\Version20210530124412', '2021-05-30 12:44:15', 331);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `soutenance_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `note` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `eval_item`
--

CREATE TABLE `eval_item` (
  `id` int(11) NOT NULL,
  `soutenance_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `note` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eval_item`
--

INSERT INTO `eval_item` (`id`, `soutenance_id`, `user_id`, `item_id`, `note`) VALUES
(1, 6, 11, 12, 2);

-- --------------------------------------------------------

--
-- Structure de la table `fiche_evaluation`
--

CREATE TABLE `fiche_evaluation` (
  `id` int(11) NOT NULL,
  `evaluateur_id` int(11) DEFAULT NULL,
  `soutenance_id` int(11) DEFAULT NULL,
  `note_final` double NOT NULL,
  `ponderation` double NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fiche_evaluation`
--

INSERT INTO `fiche_evaluation` (`id`, `evaluateur_id`, `soutenance_id`, `note_final`, `ponderation`, `nom`) VALUES
(1, 11, 1, 0, 1, 'Fiche 1');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `rubrique_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `modele` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `modele_item` (
  `modele_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
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

CREATE TABLE `modele_rubrique` (
  `modele_id` int(11) NOT NULL,
  `rubrique_id` int(11) NOT NULL
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

CREATE TABLE `rubrique` (
  `id` int(11) NOT NULL,
  `commentaire` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `liste_etudiant` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `liste_jury` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte_mail_etudiant` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte_mail_jury` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `date_debut`, `date_fin`, `nom`, `description`, `liste_etudiant`, `liste_jury`, `texte_mail_etudiant`, `texte_mail_jury`) VALUES
(1, '2016-01-01 00:00:00', '2016-01-01 00:00:00', 'Session 1', 'Description', 'nom,prenom,courriel,groupe\r\nNom1,Prenom1,Courriel1,Groupe1\r\nNom2,Prenom2,Courriel2,Groupe1\r\nNom3,Prenom3,Courriel3,Groupe2\r\nNom4,Prenom4,Courriel4,Groupe2\r\n', '\r\n', '{{Balise 1}} exemple de mail', '');

-- --------------------------------------------------------

--
-- Structure de la table `session_user`
--

CREATE TABLE `session_user` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `soutenance`
--

CREATE TABLE `soutenance` (
  `id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `modele_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_soutenance` datetime NOT NULL,
  `note` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `soutenance`
--

INSERT INTO `soutenance` (`id`, `session_id`, `modele_id`, `titre`, `description`, `image`, `date_soutenance`, `note`) VALUES
(1, 1, 1, 'Soutenance 1', 'Soutenance', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(2, 1, 11, 'Soutenance 2', 'Test', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(3, 1, 15, 'Soutenance 3', 'dd', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(4, NULL, 15, 'Soutenance 4', 'dd', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(5, NULL, 16, 'Soutenance 5', 'bla bla', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0),
(6, NULL, 17, 'Soutenance 6', 'Description', 'http://www.science-du-numerique.fr/wp-content/uploads/2019/02/url2-768x618.jpg', '2016-01-01 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `upload`
--

CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Index pour les tables déchargées
--

--
-- Index pour la table `account_request`
--
ALTER TABLE `account_request`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F2BC9BD7E7927C74` (`email`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_67F068BCA59B3775` (`soutenance_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1323A575A59B3775` (`soutenance_id`),
  ADD KEY `IDX_1323A575A76ED395` (`user_id`),
  ADD KEY `IDX_1323A575126F525E` (`item_id`);

--
-- Index pour la table `eval_item`
--
ALTER TABLE `eval_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4C29623A126F525E` (`item_id`),
  ADD KEY `IDX_4C29623AA59B3775` (`soutenance_id`),
  ADD KEY `IDX_4C29623AA76ED395` (`user_id`);

--
-- Index pour la table `fiche_evaluation`
--
ALTER TABLE `fiche_evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BD75A182231F139` (`evaluateur_id`),
  ADD KEY `IDX_BD75A182A59B3775` (`soutenance_id`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1F1B251E3BD38833` (`rubrique_id`);

--
-- Index pour la table `modele`
--
ALTER TABLE `modele`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modele_item`
--
ALTER TABLE `modele_item`
  ADD PRIMARY KEY (`modele_id`,`item_id`),
  ADD KEY `IDX_D99C5139AC14B70A` (`modele_id`),
  ADD KEY `IDX_D99C5139126F525E` (`item_id`);

--
-- Index pour la table `modele_rubrique`
--
ALTER TABLE `modele_rubrique`
  ADD PRIMARY KEY (`modele_id`,`rubrique_id`),
  ADD KEY `IDX_E77C377EAC14B70A` (`modele_id`),
  ADD KEY `IDX_E77C377E3BD38833` (`rubrique_id`);

--
-- Index pour la table `rubrique`
--
ALTER TABLE `rubrique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `session_user`
--
ALTER TABLE `session_user`
  ADD PRIMARY KEY (`session_id`,`user_id`),
  ADD KEY `IDX_4BE2D663613FECDF` (`session_id`),
  ADD KEY `IDX_4BE2D663A76ED395` (`user_id`);

--
-- Index pour la table `soutenance`
--
ALTER TABLE `soutenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4D59FF6E613FECDF` (`session_id`),
  ADD KEY `IDX_4D59FF6EAC14B70A` (`modele_id`);

--
-- Index pour la table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D5428AEDE7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `account_request`
--
ALTER TABLE `account_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `eval_item`
--
ALTER TABLE `eval_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `fiche_evaluation`
--
ALTER TABLE `fiche_evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `modele`
--
ALTER TABLE `modele`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `rubrique`
--
ALTER TABLE `rubrique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `soutenance`
--
ALTER TABLE `soutenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
-- Contraintes pour la table `eval_item`
--
ALTER TABLE `eval_item`
  ADD CONSTRAINT `FK_4C29623A126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `FK_4C29623AA59B3775` FOREIGN KEY (`soutenance_id`) REFERENCES `soutenance` (`id`),
  ADD CONSTRAINT `FK_4C29623AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `fiche_evaluation`
--
ALTER TABLE `fiche_evaluation`
  ADD CONSTRAINT `FK_BD75A182231F139` FOREIGN KEY (`evaluateur_id`) REFERENCES `users` (`id`),
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
