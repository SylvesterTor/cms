-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Vært: mysql75.unoeuro.com
-- Genereringstid: 18. 04 2023 kl. 12:03:45
-- Serverversion: 5.7.41-44-log
-- PHP-version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tvs2_dk_db_cms`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `admin`
--

CREATE TABLE `admin` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `admin`
--

INSERT INTO `admin` (`user_ID`, `username`, `password`, `mail`) VALUES
(1, 'Sylvester', '1234', 'sylvester.lave@gmail.com'),
(2, 'Sylvester1', '12345', 'sylvester@gmail.com');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `adminpairing`
--

CREATE TABLE `adminpairing` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `site_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `adminpairing`
--

INSERT INTO `adminpairing` (`ID`, `user_ID`, `site_ID`) VALUES
(12, 1, 19);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `blocks`
--

CREATE TABLE `blocks` (
  `block_ID` int(11) NOT NULL,
  `content` varchar(5000) DEFAULT NULL,
  `module_ID` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `background` varchar(60) NOT NULL DEFAULT 'rgba(255, 255, 255,0)',
  `shadow` tinyint(1) NOT NULL DEFAULT '0',
  `radius` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `blocks`
--

INSERT INTO `blocks` (`block_ID`, `content`, `module_ID`, `position`, `background`, `shadow`, `radius`) VALUES
(72, '<h2 style=\"text-align:center;\">CS CMS SYSTEMS A/S</h2>', 44, 1, 'rgba(245, 245, 245,1)', 1, 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `module`
--

CREATE TABLE `module` (
  `module_ID` int(11) NOT NULL,
  `module_module` varchar(200) DEFAULT NULL,
  `zone_ID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `moduleType` int(11) NOT NULL DEFAULT '1',
  `position` int(11) NOT NULL DEFAULT '0',
  `background` varchar(60) DEFAULT 'rgba(255, 255, 255,0)',
  `shadow` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `module`
--

INSERT INTO `module` (`module_ID`, `module_module`, `zone_ID`, `created_at`, `moduleType`, `position`, `background`, `shadow`) VALUES
(44, 'no idea', 71, '2023-04-18 11:52:53', 1, 0, 'rgba(255, 255, 255,0)', 0);

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
(71, 'header', 30, 0),
(72, 'main', 30, 1),
(73, 'footer', 30, 2);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `navbar`
--

CREATE TABLE `navbar` (
  `id` int(11) NOT NULL,
  `site_ID` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `search` int(11) DEFAULT NULL,
  `alignment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `navbar`
--

INSERT INTO `navbar` (`id`, `site_ID`, `title`, `search`, `alignment`) VALUES
(13, 19, 'CS CMS SYSTEMS A/S', 1, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `navbaritems`
--

CREATE TABLE `navbaritems` (
  `id` int(11) NOT NULL,
  `navbar_ID` int(11) DEFAULT NULL,
  `page_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `navbaritems`
--

INSERT INTO `navbaritems` (`id`, `navbar_ID`, `page_ID`) VALUES
(37, 13, 30);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pages`
--

CREATE TABLE `pages` (
  `page_ID` int(11) NOT NULL,
  `pageName` varchar(255) NOT NULL,
  `site_ID` int(11) NOT NULL,
  `webaddress` varchar(255) DEFAULT NULL,
  `secure` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `pages`
--

INSERT INTO `pages` (`page_ID`, `pageName`, `site_ID`, `webaddress`, `secure`) VALUES
(30, 'page1', 19, 'index.php?page_ID=30', 1);

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
(19, 'page1', '2023-04-18 13:51:56');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_ID`);

--
-- Indeks for tabel `adminpairing`
--
ALTER TABLE `adminpairing`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_adminPairing_admin_ID` (`user_ID`),
  ADD KEY `fk_adminPairing_site_ID` (`site_ID`);

--
-- Indeks for tabel `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`block_ID`),
  ADD KEY `fk_blocks_module_ID` (`module_ID`);

--
-- Indeks for tabel `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_ID`),
  ADD KEY `module_ibfk_1` (`zone_ID`);

--
-- Indeks for tabel `module_zone`
--
ALTER TABLE `module_zone`
  ADD PRIMARY KEY (`zone_ID`),
  ADD KEY `fk_zones_page_ID` (`page_ID`);

--
-- Indeks for tabel `navbar`
--
ALTER TABLE `navbar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `site_ID` (`site_ID`);

--
-- Indeks for tabel `navbaritems`
--
ALTER TABLE `navbaritems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `navbar_ID` (`navbar_ID`),
  ADD KEY `fk_navbaritems_page_ID` (`page_ID`);

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
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tilføj AUTO_INCREMENT i tabel `adminpairing`
--
ALTER TABLE `adminpairing`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tilføj AUTO_INCREMENT i tabel `blocks`
--
ALTER TABLE `blocks`
  MODIFY `block_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Tilføj AUTO_INCREMENT i tabel `module`
--
ALTER TABLE `module`
  MODIFY `module_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Tilføj AUTO_INCREMENT i tabel `module_zone`
--
ALTER TABLE `module_zone`
  MODIFY `zone_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Tilføj AUTO_INCREMENT i tabel `navbar`
--
ALTER TABLE `navbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tilføj AUTO_INCREMENT i tabel `navbaritems`
--
ALTER TABLE `navbaritems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Tilføj AUTO_INCREMENT i tabel `pages`
--
ALTER TABLE `pages`
  MODIFY `page_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tilføj AUTO_INCREMENT i tabel `site`
--
ALTER TABLE `site`
  MODIFY `site_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `adminpairing`
--
ALTER TABLE `adminpairing`
  ADD CONSTRAINT `fk_adminPairing_admin_ID` FOREIGN KEY (`user_ID`) REFERENCES `admin` (`user_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_adminPairing_site_ID` FOREIGN KEY (`site_ID`) REFERENCES `site` (`site_ID`) ON DELETE CASCADE;

--
-- Begrænsninger for tabel `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `fk_blocks_module_ID` FOREIGN KEY (`module_ID`) REFERENCES `module` (`module_ID`) ON DELETE CASCADE;

--
-- Begrænsninger for tabel `module`
--
ALTER TABLE `module`
  ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`zone_ID`) REFERENCES `module_zone` (`zone_ID`) ON DELETE CASCADE;

--
-- Begrænsninger for tabel `module_zone`
--
ALTER TABLE `module_zone`
  ADD CONSTRAINT `fk_zones_page_ID` FOREIGN KEY (`page_ID`) REFERENCES `pages` (`page_ID`) ON DELETE CASCADE;

--
-- Begrænsninger for tabel `navbar`
--
ALTER TABLE `navbar`
  ADD CONSTRAINT `navbar_ibfk_1` FOREIGN KEY (`site_ID`) REFERENCES `site` (`site_ID`) ON DELETE CASCADE;

--
-- Begrænsninger for tabel `navbaritems`
--
ALTER TABLE `navbaritems`
  ADD CONSTRAINT `fk_navbaritems_page_ID` FOREIGN KEY (`page_ID`) REFERENCES `pages` (`page_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `navbaritems_ibfk_1` FOREIGN KEY (`navbar_ID`) REFERENCES `navbar` (`id`) ON DELETE CASCADE;

--
-- Begrænsninger for tabel `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`site_ID`) REFERENCES `site` (`site_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
