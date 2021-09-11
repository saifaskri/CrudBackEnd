-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 11 sep. 2021 à 13:24
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `halava`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_desc` varchar(255) NOT NULL,
  `cat_status` tinyint(4) NOT NULL DEFAULT 0,
  `cat_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`cat_id`, `added_by`, `cat_name`, `cat_desc`, `cat_status`, `cat_date`) VALUES
(1, 43, 'ds', 'ds', 0, '2021-09-11 09:07:18'),
(2, 43, 'Sport', 'All things that are familaire with Sport', 1, '2021-09-11 09:36:46'),
(3, 48, 'films', 'good film', 1, '2021-09-11 10:16:37');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `this_user_works_under` int(11) DEFAULT NULL,
  `item_titel` varchar(255) DEFAULT NULL,
  `item_desc` varchar(255) DEFAULT NULL,
  `item_price` int(11) NOT NULL DEFAULT 0,
  `item_currency` varchar(10) NOT NULL DEFAULT 'TND',
  `item_photo` varchar(255) NOT NULL,
  `item_upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `item_status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`item_id`, `user_id`, `cat_id`, `this_user_works_under`, `item_titel`, `item_desc`, `item_price`, `item_currency`, `item_photo`, `item_upload_date`, `item_status`) VALUES
(112, 43, 2, NULL, 'protein', 'good amount of protien', 59, 'TND', '../Users_Info/Id_User_Nr43/images/dnH d ofbMTeiousi633194345413.png', '2021-09-11 09:51:07', 1),
(113, 48, 3, NULL, 'tiekn', 'good ', 3, 'TND', '../Users_Info/Id_User_Nr48/images/pmp5637303470.jpeg', '2021-09-11 10:17:42', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `working_under` int(11) NOT NULL DEFAULT 0,
  `registered Date` datetime NOT NULL DEFAULT current_timestamp(),
  `groupID` tinyint(4) NOT NULL DEFAULT 0,
  `zugangberichtigung` tinyint(1) NOT NULL DEFAULT 1,
  `email_code` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `username`, `working_under`, `registered Date`, `groupID`, `zugangberichtigung`, `email_code`) VALUES
(43, 'saif.askri@outlook.de', '5241af08ed1900e4821aab0162b9938d45edd8d5', 'saif askri', 0, '2021-08-29 12:28:13', 1, 1, NULL),
(46, 'fatmaxt0000@gmail.com', '5241af08ed1900e4821aab0162b9938d45edd8d5', 'Fatma Askri', 43, '2021-08-29 18:39:38', 0, 1, NULL),
(47, 'sabrixt0000@gmail.com', '5241af08ed1900e4821aab0162b9938d45edd8d5', 'Sabri Askri', 43, '2021-08-29 18:42:16', 0, 1, NULL),
(48, 'hssan.h@gmail.ciom', '5241af08ed1900e4821aab0162b9938d45edd8d5', 'hassan askri', 0, '2021-09-01 17:42:48', 1, 1, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`),
  ADD KEY `added_by` (`added_by`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_item_id` (`user_id`),
  ADD KEY `item_cat` (`cat_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `item_cat` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`),
  ADD CONSTRAINT `user_item_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
