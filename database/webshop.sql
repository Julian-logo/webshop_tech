-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 03. Jan 2023 um 11:48
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `webshop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `phone_id` bigint(20) NOT NULL,
  `image_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `images`
--

INSERT INTO `images` (`id`, `phone_id`, `image_url`) VALUES
(67, 493013, 'IMG-63ab0737595820.94826261.jpg'),
(68, 8483024302354058, 'IMG-63ab07690acc90.80716517.png'),
(69, 5318898936158960, 'IMG-63ab2240cb4256.18459208.jpg'),
(70, 81891870417452443, 'IMG-63ab2282d93b77.39738034.jpg'),
(71, 435542906, 'IMG-63ab22bea81ea9.62385686.jpg'),
(72, 598136844880161838, 'IMG-63ab2308c67ab9.47007038.jpg'),
(73, 83419417003, 'IMG-63ab23784e9826.34740034.jpg'),
(74, 9223372036854775807, 'IMG-63ab23c7054cf6.23128912.jpg'),
(106, 412328718934535, 'IMG-63ac288bb0e0e9.45966159.jpg'),
(107, 412328718934535, 'IMG-63ac288f50db52.09394018.jpg'),
(111, 146620, 'IMG-63ac32c5475ad2.19291947.jpg'),
(114, 493013, 'IMG-63ac3f2655a2c1.17507344.jpg'),
(115, 493013, 'IMG-63ac3f2c2096b4.55802278.png'),
(116, 8483024302354058, 'IMG-63ac415c562279.27326399.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `phone`
--

CREATE TABLE `phone` (
  `id` bigint(20) NOT NULL,
  `phone_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `screenSize` varchar(11) NOT NULL,
  `ramSize` int(11) NOT NULL,
  `storageSize` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `phone`
--

INSERT INTO `phone` (`id`, `phone_id`, `user_id`, `brand`, `model`, `screenSize`, `ramSize`, `storageSize`, `color`, `price`) VALUES
(76, 493013, 68953280, '1', '1', '1', 1, 1, '1', 1),
(77, 8483024302354058, 625119966478018, 'Iphone', 'Apple', '12', 32, 32, 'black', 250),
(78, 5318898936158960, 193930, 'Iphone', 'Apple', '5.7', 4, 4, 'black', 800),
(79, 81891870417452443, 128488, 'Pixel', 'Google', '8', 8, 16, 'white', 600),
(80, 435542906, 4862836305, 'S20', 'Samsung', '9', 8, 12, 'green', 650),
(81, 598136844880161838, 6242, 'Poco', 'Xiami', '13', 12, 32, 'blue', 420),
(82, 83419417003, 758420728589346, 'Iphone 12', 'Apple', '8.4', 32, 32, 'black', 1200),
(83, 9223372036854775807, 8048349364025860, 'iphonne', 'Apple', '12', 12, 32, 'black', 350),
(84, 1071751368, 2050560431622863113, 'Iphone 5', 'Apple', '10', 8, 8, 'black', 450);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(200) NOT NULL,
  `verification_code` text NOT NULL,
  `email_verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `password`, `date`, `email`, `verification_code`, `email_verified_at`) VALUES
(23, 59281153130319, 'julian', 'julian', '2022-12-14 15:25:13', 'julian1997hardekopf@gmail.com', '215778', '2022-12-14 17:25:13'),
(25, 878206955471808769, 'julian', 'jul', '2022-12-14 16:09:29', 'julian1997hardekopf@gmail.com', '198820', NULL),
(26, 218236, 'julian', 'jul', '2022-12-14 16:10:32', 'julian1997hardekopf@gmail.com', '349213', NULL),
(27, 7954523064846593206, 'julian', 'ju', '2022-12-14 16:10:54', 'jj', '251291', NULL),
(28, 7622013192163335861, 'julian', 'ju', '2022-12-14 16:11:12', 'julian1997hardekopf@gmail.com', '299201', NULL),
(29, 2050560431622863113, 'julian1', 'ju', '2022-12-27 16:57:27', 'julian1997hardekopf@gmail.com', '245126', '2022-12-27 17:57:27'),
(30, 267747, 'julian2', 'julian2', '2022-12-14 16:33:17', 'julian1997hardekopf@gmail.com', '246868', '2022-12-14 18:33:17'),
(31, 625119966478018, 'julian3', 'julian3', '2022-12-14 16:26:39', 'julian1997hardekopf@gmail.com', '230532', '2022-12-14 18:26:39'),
(32, 68953280, 'julian4', 'julian4', '2022-12-14 16:32:19', 'julian1997hardekopf@gmail.com', '335422', '2022-12-14 18:32:19'),
(33, 6242, 'test1', 'test1', '2022-12-14 16:33:54', 'julian1997hardekopf@gmail.com', '256554', '2022-12-14 18:33:54'),
(34, 4862836305, 'test2', 'test2', '2022-12-14 16:34:55', 'julian1997hardekopf@gmail.com', '481518', '2022-12-14 18:34:55'),
(35, 8048349364025860, 'julian5', 'julian5', '2022-12-27 16:55:42', 'julian1997hardekopf@gmail.com', '270544', '2022-12-27 17:55:42'),
(36, 758420728589346, 'julian7', 'julian7', '2022-12-27 16:54:19', 'julian1997hardekopf@gmail.com', '186925', '2022-12-27 17:54:19'),
(37, 193930, 'julian6', 'julian6', '2022-12-23 10:25:49', 'julian1997hardekopf@gmail.com', '182132', '2022-12-23 11:25:49'),
(38, 128488, 'julian8', 'julian8', '2022-12-23 10:27:31', 'julian1997hardekopf@gmail.com', '189828', '2022-12-23 11:27:31'),
(39, 5546264928, 'regrg', 'erggerg', '2022-12-23 10:55:50', 'regger', '348497', NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phone_id` (`phone_id`);

--
-- Indizes für die Tabelle `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone_id` (`phone_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date` (`date`),
  ADD KEY `user_name` (`user_name`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT für Tabelle `phone`
--
ALTER TABLE `phone`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
