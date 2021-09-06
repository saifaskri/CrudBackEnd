-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Sep 2021 um 12:42
-- Server-Version: 10.4.17-MariaDB
-- PHP-Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `halava`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
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
-- Daten für Tabelle `items`
--

INSERT INTO `items` (`item_id`, `user_id`, `this_user_works_under`, `item_titel`, `item_desc`, `item_price`, `item_currency`, `item_photo`, `item_upload_date`, `item_status`) VALUES
(105, 46, 43, 'protein', 'have good mount of protein', 200, 'TND', '../Users_Info/Id_User_Nr46/images/wddalnoo53401789241.jpeg', '2021-08-30 16:20:22', 0),
(106, 43, NULL, 'bfbfd', 'bffb', 343, 'TND', '../Users_Info/Id_User_Nr43/images/2547_168832194765272250_213n099_1639602612749121962045256963.jpeg', '2021-08-31 21:02:14', 0),
(108, 48, NULL, 'makyaj', 'cjbcsjhcs', 20, 'TND', '../Users_Info/Id_User_Nr48/images/soc259687169742.jpeg', '2021-09-01 17:51:25', 0),
(110, 43, NULL, 'Mass', 'saif\r\n', 500, 'EURO', '../Users_Info/Id_User_Nr43/images/wnooddla452555523891.jpeg', '2021-09-02 19:38:26', 1),
(111, 43, NULL, 'Protein', 'fianh 30 g fl 1400g ', 200, 'TND', '../Users_Info/Id_User_Nr43/images/oldwonad832662366512.jpeg', '2021-09-02 22:27:11', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
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
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `username`, `working_under`, `registered Date`, `groupID`, `zugangberichtigung`, `email_code`) VALUES
(43, 'saif.askri@outlook.de', '5241af08ed1900e4821aab0162b9938d45edd8d5', 'saif askri', 0, '2021-08-29 12:28:13', 1, 1, NULL),
(46, 'fatmaxt0000@gmail.com', '5241af08ed1900e4821aab0162b9938d45edd8d5', 'Fatma Askri', 43, '2021-08-29 18:39:38', 0, 1, NULL),
(47, 'sabrixt0000@gmail.com', '5241af08ed1900e4821aab0162b9938d45edd8d5', 'Sabri Askri', 43, '2021-08-29 18:42:16', 0, 1, NULL),
(48, 'hssan.h@gmail.ciom', '5241af08ed1900e4821aab0162b9938d45edd8d5', 'hassan askri', 0, '2021-09-01 17:42:48', 1, 1, NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_item_id` (`user_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `user_item_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
