-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 07 oct. 2025 à 16:31
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `voyages`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `commentaire` varchar(1024) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `commentaire`, `id_utilisateur`, `date`) VALUES
(1, 'ZZZZ j\'ai fait que dormir', 1, '2025-10-06'),
(2, 'Bonjour j\'ai adoré Bali', 2, '2025-10-06'),
(3, 'J\'aime trop ce site c trop bien fait', 2, '2025-10-06'),
(4, 'Bonjour, je voudrais visiter l\'Éthiopie dans la région de Harar et je voudrais savoir si les hyennes sont un danger ?', 1, '2025-10-07'),
(5, 'Coucou merci pour tout', 2, '2025-10-07'),
(6, 'Bonjour, non les hiennes ne sont pas vraiment un danger pour l\'homme, d\'ailleurs elles sont nourries tous les jours pour éviter les accidents. Il faut toutefois faire attention si vous vous prommenez tard le soir et ne pas sortir de l\'enceinte de la ville la nuit.', 3, '2025-10-07'),
(7, 'Merci encore pour ce merveilleux voyage !!', 3, '2025-10-07'),
(10, 'Merci !!', 1, '2025-10-07'),
(11, 'Merci également !', 4, '2025-10-07');

-- --------------------------------------------------------

--
-- Structure de la table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `key_name`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'PHP MVC Starter', 'Nom du site web', '2025-10-03 11:02:31', '2025-10-03 11:02:31'),
(2, 'maintenance_mode', '0', 'Mode maintenance (0 = désactivé, 1 = activé)', '2025-10-03 11:02:31', '2025-10-03 11:02:31'),
(3, 'max_login_attempts', '5', 'Nombre maximum de tentatives de connexion', '2025-10-03 11:02:31', '2025-10-03 11:02:31'),
(4, 'session_timeout', '3600', 'Timeout de session en secondes', '2025-10-03 11:02:31', '2025-10-03 11:02:31');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zip` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`isAdmin`, `id`, `login`, `email`, `country`, `zip`, `password`, `active`, `created_at`, `updated_at`) VALUES
(0, 1, 'Katana', 'gaaabriel@hotmail.fr', 'TAIWAN', 69100, '$2y$10$l47DlAlbWDKWp5eSmPBpgONC8c6KMfsI.cnVKAzs9Xht09gnMZ6f2', 1, '2025-10-03 11:29:52', '2025-10-07 13:35:50'),
(0, 2, 'gabriel', 'gab.vf.93@gmail.com', 'GRANDE-BRETAGNE', 69100, '$2y$10$RKqSSyEKoBaqNQgCB.xtG.KL0X4Re7xN3H39KLzRZWpXXJw7Yhuoa', 1, '2025-10-06 13:15:29', '2025-10-06 13:15:29'),
(0, 3, 'L\'homme au chapeau', 'admin@example.com', 'Ethiopie', 69100, '$2y$10$qM84ASWUvzoHjHrWVVacYuhpnRXB2ufS.9syTc987y0zPZp7oMNEi', 1, '2025-10-07 08:56:43', '2025-10-07 08:56:43'),
(0, 4, 'Ange', 'ange@gmail.com', 'France', 69100, '$2y$10$l/d70mnXRvg20xe2WFYSQeGU98dx/kfEsmpb6YSqvs0ztmQhnd8r.', 1, '2025-10-07 13:17:59', '2025-10-07 13:17:59'),
(0, 5, 'GYSP', 'gysp@gmail.com', 'FRANCE', 69100, '$2y$10$P35S9rl6NbZ3MluZ0gaGkukAJNLuj7vJE.cF4UrW9HTWUT1WPG9bC', 1, '2025-10-07 13:48:12', '2025-10-07 13:54:24');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `user_stats`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `user_stats` (
`total_users` bigint(21)
,`new_users_30d` bigint(21)
,`new_users_7d` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure de la vue `user_stats`
--
DROP TABLE IF EXISTS `user_stats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_stats`  AS SELECT count(0) AS `total_users`, count(case when `users`.`created_at` >= current_timestamp() - interval 30 day then 1 end) AS `new_users_30d`, count(case when `users`.`created_at` >= current_timestamp() - interval 7 day then 1 end) AS `new_users_7d` FROM `users` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_name` (`key_name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
