-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 28. 03 2023 kl. 09:41:09
-- Serverversion: 10.4.24-MariaDB
-- PHP-version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `admin`
--

CREATE TABLE `admin` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `site_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `admin`
--

INSERT INTO `admin` (`user_ID`, `username`, `password`, `mail`, `site_ID`) VALUES
(1, 'Sylvester', '1234', 'sylvester.lave@gmail.com', 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `header` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `altText` varchar(255) DEFAULT NULL,
  `module_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `imagestext`
--

CREATE TABLE `imagestext` (
  `id` int(11) NOT NULL,
  `imageplacement` varchar(255) DEFAULT NULL,
  `altText` varchar(255) DEFAULT NULL,
  `header` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `module_ID` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `imagestext`
--

INSERT INTO `imagestext` (`id`, `imageplacement`, `altText`, `header`, `text`, `module_ID`, `type`) VALUES
(1, 'images/heartland-68.php', 'Heartland', 'Heartland-2022', 'heartland hej med dig', 2, 3);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `list`
--

CREATE TABLE `list` (
  `listId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `list`
--

INSERT INTO `list` (`listId`) VALUES
(1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `listitems`
--

CREATE TABLE `listitems` (
  `id` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `altText` varchar(255) DEFAULT NULL,
  `listID` int(11) DEFAULT NULL,
  `itemType` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `listitems`
--

INSERT INTO `listitems` (`id`, `text`, `altText`, `listID`, `itemType`) VALUES
(1, 'Home', 'index.php', 1, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `module`
--

CREATE TABLE `module` (
  `module_ID` int(11) NOT NULL,
  `module_module` varchar(200) DEFAULT NULL,
  `zone_ID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `module`
--

INSERT INTO `module` (`module_ID`, `module_module`, `zone_ID`, `created_at`) VALUES
(1, 'navbar', 1, '2023-03-06 08:32:36'),
(2, 'header', 2, '2023-03-21 08:46:41'),
(3, 'main', 3, '2023-03-21 08:46:41');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `module_zone`
--

CREATE TABLE `module_zone` (
  `zone_ID` int(11) NOT NULL,
  `zoneName` varchar(255) DEFAULT NULL,
  `page_ID` int(11) NOT NULL,
  `placement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `module_zone`
--

INSERT INTO `module_zone` (`zone_ID`, `zoneName`, `page_ID`, `placement`) VALUES
(1, 'navbar', 1, 1),
(2, 'header', 1, 2),
(3, 'main', 1, 3),
(4, 'footer', 1, 4);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `navbar`
--

CREATE TABLE `navbar` (
  `id` int(11) NOT NULL,
  `title` varchar(5000) DEFAULT NULL,
  `search` int(11) DEFAULT NULL,
  `alignment` int(11) DEFAULT NULL,
  `site_ID` int(11) NOT NULL,
  `listId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `navbar`
--

INSERT INTO `navbar` (`id`, `title`, `search`, `alignment`, `site_ID`, `listId`) VALUES
(1, 'Christian', 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pages`
--

CREATE TABLE `pages` (
  `page_ID` int(11) NOT NULL,
  `pageName` varchar(255) NOT NULL,
  `site_ID` int(11) NOT NULL,
  `webaddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `pages`
--

INSERT INTO `pages` (`page_ID`, `pageName`, `site_ID`, `webaddress`) VALUES
(1, 'home', 1, 'index.php'),
(2, 'Om os', 1, 'omos.php');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `site`
--

CREATE TABLE `site` (
  `site_ID` int(11) NOT NULL,
  `webaddress` varchar(255) DEFAULT NULL,
  `data_published` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `site`
--

INSERT INTO `site` (`site_ID`, `webaddress`, `data_published`) VALUES
(1, 'testsite', '2023-03-06 08:46:04');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `textarea`
--

CREATE TABLE `textarea` (
  `id` int(11) NOT NULL,
  `header` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `module_ID` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `textarea`
--

INSERT INTO `textarea` (`id`, `header`, `text`, `module_ID`, `type`) VALUES
(2, 'TEst header', 'HUfehufeuhaswfhuishuifeFHUEHU eUHFUfe', 2, 2);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `site_ID` (`site_ID`);

--
-- Indeks for tabel `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_ID` (`module_ID`);

--
-- Indeks for tabel `imagestext`
--
ALTER TABLE `imagestext`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_ID` (`module_ID`);

--
-- Indeks for tabel `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`listId`);

--
-- Indeks for tabel `listitems`
--
ALTER TABLE `listitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `listID` (`listID`);

--
-- Indeks for tabel `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_ID`),
  ADD KEY `zone_ID` (`zone_ID`);

--
-- Indeks for tabel `module_zone`
--
ALTER TABLE `module_zone`
  ADD PRIMARY KEY (`zone_ID`),
  ADD KEY `page_ID` (`page_ID`);

--
-- Indeks for tabel `navbar`
--
ALTER TABLE `navbar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_site_navbar` (`site_ID`),
  ADD KEY `listId` (`listId`);

--
-- Indeks for tabel `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_ID`),
  ADD KEY `site_ID` (`site_ID`);

--
-- Indeks for tabel `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`site_ID`);

--
-- Indeks for tabel `textarea`
--
ALTER TABLE `textarea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_ID` (`module_ID`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tilføj AUTO_INCREMENT i tabel `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `imagestext`
--
ALTER TABLE `imagestext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tilføj AUTO_INCREMENT i tabel `list`
--
ALTER TABLE `list`
  MODIFY `listId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tilføj AUTO_INCREMENT i tabel `listitems`
--
ALTER TABLE `listitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tilføj AUTO_INCREMENT i tabel `module`
--
ALTER TABLE `module`
  MODIFY `module_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tilføj AUTO_INCREMENT i tabel `module_zone`
--
ALTER TABLE `module_zone`
  MODIFY `zone_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tilføj AUTO_INCREMENT i tabel `navbar`
--
ALTER TABLE `navbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tilføj AUTO_INCREMENT i tabel `pages`
--
ALTER TABLE `pages`
  MODIFY `page_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tilføj AUTO_INCREMENT i tabel `site`
--
ALTER TABLE `site`
  MODIFY `site_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tilføj AUTO_INCREMENT i tabel `textarea`
--
ALTER TABLE `textarea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`site_ID`) REFERENCES `site` (`site_ID`);

--
-- Begrænsninger for tabel `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`module_ID`) REFERENCES `module` (`module_ID`);

--
-- Begrænsninger for tabel `imagestext`
--
ALTER TABLE `imagestext`
  ADD CONSTRAINT `imagestext_ibfk_1` FOREIGN KEY (`module_ID`) REFERENCES `module` (`module_ID`);

--
-- Begrænsninger for tabel `listitems`
--
ALTER TABLE `listitems`
  ADD CONSTRAINT `listitems_ibfk_1` FOREIGN KEY (`listID`) REFERENCES `list` (`listId`);

--
-- Begrænsninger for tabel `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`zone_ID`) REFERENCES `module_zone` (`zone_ID`);

--
-- Begrænsninger for tabel `module_zone`
--
ALTER TABLE `module_zone`
  ADD CONSTRAINT `module_zone_ibfk_1` FOREIGN KEY (`page_ID`) REFERENCES `pages` (`page_ID`);

--
-- Begrænsninger for tabel `navbar`
--
ALTER TABLE `navbar`
  ADD CONSTRAINT `FK_site_navbar` FOREIGN KEY (`site_ID`) REFERENCES `site` (`site_ID`),
  ADD CONSTRAINT `navbar_ibfk_1` FOREIGN KEY (`listId`) REFERENCES `list` (`listId`);

--
-- Begrænsninger for tabel `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`site_ID`) REFERENCES `site` (`site_ID`);

--
-- Begrænsninger for tabel `textarea`
--
ALTER TABLE `textarea`
  ADD CONSTRAINT `textarea_ibfk_1` FOREIGN KEY (`module_ID`) REFERENCES `module` (`module_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
