-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Apr 2017 um 08:07
-- Server-Version: 10.1.21-MariaDB
-- PHP-Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `library`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `FK_users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `admins`
--

INSERT INTO `admins` (`id`, `FK_users`) VALUES
(1, 11),
(2, 9);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `age_recommendations`
--

CREATE TABLE `age_recommendations` (
  `id` int(11) NOT NULL,
  `age` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Daten für Tabelle `age_recommendations`
--

INSERT INTO `age_recommendations` (`id`, `age`) VALUES
(1, 'for children'),
(2, 'for grown-ups');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `family_name` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Daten für Tabelle `authors`
--

INSERT INTO `authors` (`id`, `first_name`, `family_name`) VALUES
(4, 'Fabian-Sixtus', 'Koerner'),
(5, 'Lisa', 'Duschek'),
(6, 'Lisa-Anna', 'Duschek'),
(7, 'Martin', 'Matthews'),
(8, 'Craig', 'Grannell'),
(9, 'Jon', 'Duckett'),
(10, 'Christoph', 'Hoeller'),
(11, 'Florence', 'Maurice'),
(12, 'Goran', 'Stevic'),
(13, 'Nathalie-Lisa', 'Duschek'),
(14, 'Nicky', 'Pallas'),
(15, 'Nathalie', 'Stiefsohn');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `avatars`
--

CREATE TABLE `avatars` (
  `id` int(11) NOT NULL,
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `avatars`
--

INSERT INTO `avatars` (`id`, `avatar`) VALUES
(1, 'pictures/avatar1.jpg'),
(2, 'pictures/avatar2.jpg'),
(3, 'pictures/avatar3.jpg'),
(4, 'pictures/avatar4.jpg'),
(5, 'pictures/avatar5.jpg'),
(6, 'pictures/avatar6.jpg'),
(7, 'pictures/avatar7.jpg'),
(8, 'pictures/avatar8.jpg'),
(10, 'pictures/avatar9.jpg'),
(11, 'pictures/avatar10.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `FK_authors` int(11) NOT NULL,
  `FK_genres` int(11) NOT NULL,
  `publishing_year` year(4) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `FK_libraries` int(11) NOT NULL DEFAULT '1',
  `image` varchar(100) NOT NULL,
  `FK_age_recommendations` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `books`
--

INSERT INTO `books` (`id`, `title`, `FK_authors`, `FK_genres`, `publishing_year`, `available`, `FK_libraries`, `image`, `FK_age_recommendations`) VALUES
(13, 'HTML Quicksteps', 7, 14, 2009, 0, 1, 'pictures/html_quicksteps-matthew, martin.jpg', 2),
(14, 'The Essential Guide to CSS and HTML Web Design', 8, 14, 2007, 1, 1, 'pictures/coding2.jpg', 2),
(15, 'JavaScript &amp; jQuery', 9, 14, 2014, 0, 1, 'pictures/coding3.jpg', 2),
(16, 'Angular: Das umfassende Handbuch zum JavaScript-Framework. ', 10, 14, 2017, 1, 1, 'pictures/coding4.jpg', 2),
(17, 'PHP 5.6 und MySQL 5.7: Ihr praktischer Einstieg in die Programmierung dynamische Websites ', 11, 14, 2015, 0, 1, 'pictures/coding5.jpg', 2),
(18, 'CSS3: Die neuen Features fÃ¼r fortgeschrittene Webdesigner', 11, 14, 2013, 1, 1, 'pictures/coding6.jpg', 2),
(19, 'Mobile Webseiten: Strategien, Techniken, Dos und Donts fÃ¼r Webentwickler.', 11, 14, 2012, 0, 1, 'pictures/coding7.jpg', 2),
(20, 'Code Perfect', 12, 14, 2017, 1, 1, 'pictures/default.jpg', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `books_tags`
--

CREATE TABLE `books_tags` (
  `id` int(11) NOT NULL,
  `FK_books` int(11) NOT NULL,
  `FK_tags` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `books_tags`
--

INSERT INTO `books_tags` (`id`, `FK_books`, `FK_tags`) VALUES
(1, 13, 4),
(2, 13, 5),
(3, 15, 3),
(4, 15, 1),
(5, 15, 4),
(6, 15, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `borrows`
--

CREATE TABLE `borrows` (
  `id` int(11) NOT NULL,
  `FK_users` int(11) NOT NULL,
  `FK_books` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `borrows`
--

INSERT INTO `borrows` (`id`, `FK_users`, `FK_books`, `date`) VALUES
(22, 9, 19, '2017-04-10 06:22:04'),
(24, 11, 13, '2017-04-10 07:26:59'),
(25, 11, 17, '2017-04-10 07:27:05'),
(28, 9, 15, '2017-04-10 14:59:28');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `genres`
--

INSERT INTO `genres` (`id`, `genre`) VALUES
(1, 'Fiction'),
(2, 'Comedy'),
(3, 'Drama'),
(4, 'Horror'),
(5, 'Non-Fiction'),
(6, 'Realistic Fiction'),
(7, 'Romance Novel'),
(8, 'Satire'),
(9, 'Tragendy'),
(10, 'Tragicomedy'),
(11, 'Fantasy'),
(12, 'Mythology'),
(13, 'Learning'),
(14, 'Coding'),
(15, 'HTML'),
(16, 'CSS'),
(17, 'PHP');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `libraries`
--

CREATE TABLE `libraries` (
  `id` int(11) NOT NULL,
  `open_from` time NOT NULL,
  `open_to` time NOT NULL,
  `telephone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Daten für Tabelle `libraries`
--

INSERT INTO `libraries` (`id`, `open_from`, `open_to`, `telephone`) VALUES
(1, '09:30:00', '18:00:00', 15879);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'Website'),
(2, 'Web Development'),
(3, 'Database'),
(4, 'Programming'),
(5, 'Computer');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `family_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `FK_avatars` int(11) NOT NULL,
  `member_since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `first_name`, `family_name`, `email`, `password`, `username`, `FK_avatars`, `member_since`) VALUES
(9, 'Nathalie', 'Stiefsohn', 'nathalie.stiefsohn@hotmail.com', '16954afbacd788f977ef6e8da44d5d7df5eb9098b71bdbbb40596b0c2e3191f6', 'funnynati', 3, '2017-04-10 12:12:59'),
(11, 'Clemens', 'Bauer', 'clemens_78@gmail.com', 'd320b98f7aaba156a6b3ba75930155db5bbb65233d7cb554299dc22b4a9b737e', 'clemens_78', 4, '2017-04-10 09:36:51'),
(12, 'Jennifer', 'Streusel', 'jennifer.streusel@gmail.com', '6457d96cc58e261cf28c60681b8bcf1f93819eef10936363e2a61f8b93ef1b32', 'Jenny_From_The_Block', 2, '2017-04-10 09:19:19'),
(13, 'Igor', 'Putin', 'igor.putin@gmail.com', '4cd4353c195605e2daf3e3c3f373baef3c975c2726b3adeac7636f8381b40d4b', 'IgorPutin', 8, '2017-04-10 10:02:55');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`FK_users`),
  ADD KEY `FK_users` (`FK_users`);

--
-- Indizes für die Tabelle `age_recommendations`
--
ALTER TABLE `age_recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`FK_authors`,`FK_genres`),
  ADD KEY `FK_author` (`FK_authors`),
  ADD KEY `FK_genre` (`FK_genres`),
  ADD KEY `FK_libraries` (`FK_libraries`),
  ADD KEY `FK_age_recommendations` (`FK_age_recommendations`);

--
-- Indizes für die Tabelle `books_tags`
--
ALTER TABLE `books_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`FK_books`,`FK_tags`),
  ADD KEY `FK_books` (`FK_books`),
  ADD KEY `FK_tags` (`FK_tags`);

--
-- Indizes für die Tabelle `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`FK_users`,`FK_books`),
  ADD KEY `FK_users` (`FK_users`),
  ADD KEY `FK_books` (`FK_books`);

--
-- Indizes für die Tabelle `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `libraries`
--
ALTER TABLE `libraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `FK_avatars` (`FK_avatars`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `age_recommendations`
--
ALTER TABLE `age_recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT für Tabelle `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT für Tabelle `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `books_tags`
--
ALTER TABLE `books_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT für Tabelle `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT für Tabelle `libraries`
--
ALTER TABLE `libraries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`FK_users`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`FK_authors`) REFERENCES `authors` (`id`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`FK_genres`) REFERENCES `genres` (`id`),
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`FK_libraries`) REFERENCES `libraries` (`id`),
  ADD CONSTRAINT `books_ibfk_4` FOREIGN KEY (`FK_age_recommendations`) REFERENCES `age_recommendations` (`id`);

--
-- Constraints der Tabelle `books_tags`
--
ALTER TABLE `books_tags`
  ADD CONSTRAINT `books_tags_ibfk_1` FOREIGN KEY (`FK_books`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `books_tags_ibfk_2` FOREIGN KEY (`FK_tags`) REFERENCES `tags` (`id`);

--
-- Constraints der Tabelle `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `borrows_ibfk_1` FOREIGN KEY (`FK_users`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrows_ibfk_2` FOREIGN KEY (`FK_books`) REFERENCES `books` (`id`);

--
-- Constraints der Tabelle `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`FK_avatars`) REFERENCES `avatars` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
