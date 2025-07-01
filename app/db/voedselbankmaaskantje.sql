-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 01 jul 2025 om 08:53
-- Serverversie: 9.1.0
-- PHP-versie: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voedselbankmaaskantje`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `allergie`
--

DROP TABLE IF EXISTS `allergie`;
CREATE TABLE IF NOT EXISTS `allergie` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam` varchar(50) NOT NULL,
  `Omschrijving` varchar(255) NOT NULL,
  `AnafylactischRisico` varchar(50) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `allergie`
--

INSERT INTO `allergie` (`Id`, `Naam`, `Omschrijving`, `AnafylactischRisico`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Gluten', 'Allergisch voor gluten', 'zeerlaag', b'1', NULL, '2025-07-01 09:52:21.792572', '2025-07-01 09:52:21.792573'),
(2, 'Pindas', 'Allergisch voor pindas', 'Hoog', b'1', NULL, '2025-07-01 09:52:21.792612', '2025-07-01 09:52:21.792613'),
(3, 'Schaaldieren', 'Allergisch voor schaaldieren', 'RedelijkHoog', b'1', NULL, '2025-07-01 09:52:21.792619', '2025-07-01 09:52:21.792619'),
(4, 'Hazelnoten', 'Allergisch voor hazelnoten', 'laag', b'1', NULL, '2025-07-01 09:52:21.792623', '2025-07-01 09:52:21.792623'),
(5, 'Lactose', 'Allergisch voor lactose', 'Zeerlaag', b'1', NULL, '2025-07-01 09:52:21.792625', '2025-07-01 09:52:21.792625'),
(6, 'Soja', 'Allergisch voor soja', 'Zeerlaag', b'1', NULL, '2025-07-01 09:52:21.792627', '2025-07-01 09:52:21.792627');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `allergieperpersoon`
--

DROP TABLE IF EXISTS `allergieperpersoon`;
CREATE TABLE IF NOT EXISTS `allergieperpersoon` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `PersoonId` smallint UNSIGNED NOT NULL,
  `AllergieId` smallint UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_AllergiePerPersoon_PersoonId` (`PersoonId`),
  KEY `FK_AllergiePerPersoon_AllergieId` (`AllergieId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `allergieperpersoon`
--

INSERT INTO `allergieperpersoon` (`Id`, `PersoonId`, `AllergieId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 4, 1, b'1', NULL, '2025-07-01 09:52:22.146532', '2025-07-01 09:52:22.146533'),
(2, 5, 2, b'1', NULL, '2025-07-01 09:52:22.146584', '2025-07-01 09:52:22.146584'),
(3, 6, 3, b'1', NULL, '2025-07-01 09:52:22.146593', '2025-07-01 09:52:22.146593'),
(4, 7, 4, b'1', NULL, '2025-07-01 09:52:22.146598', '2025-07-01 09:52:22.146598'),
(5, 8, 3, b'1', NULL, '2025-07-01 09:52:22.146603', '2025-07-01 09:52:22.146603'),
(6, 9, 2, b'1', NULL, '2025-07-01 09:52:22.146608', '2025-07-01 09:52:22.146608'),
(7, 10, 5, b'1', NULL, '2025-07-01 09:52:22.146613', '2025-07-01 09:52:22.146614'),
(8, 12, 2, b'1', NULL, '2025-07-01 09:52:22.146620', '2025-07-01 09:52:22.146620'),
(9, 13, 4, b'1', NULL, '2025-07-01 09:52:22.146625', '2025-07-01 09:52:22.146625'),
(10, 14, 1, b'1', NULL, '2025-07-01 09:52:22.146630', '2025-07-01 09:52:22.146630'),
(11, 15, 3, b'1', NULL, '2025-07-01 09:52:22.146635', '2025-07-01 09:52:22.146635'),
(12, 16, 5, b'1', NULL, '2025-07-01 09:52:22.146640', '2025-07-01 09:52:22.146640'),
(13, 17, 1, b'1', NULL, '2025-07-01 09:52:22.146646', '2025-07-01 09:52:22.146646'),
(14, 17, 2, b'1', NULL, '2025-07-01 09:52:22.146650', '2025-07-01 09:52:22.146651'),
(15, 18, 4, b'1', NULL, '2025-07-01 09:52:22.146655', '2025-07-01 09:52:22.146655'),
(16, 19, 4, b'1', NULL, '2025-07-01 09:52:22.146660', '2025-07-01 09:52:22.146660');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam` varchar(50) NOT NULL,
  `Omschrijving` varchar(255) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`Id`, `Naam`, `Omschrijving`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'AGF', 'Aardappelen groente en fruit', b'1', NULL, '2025-07-01 09:52:21.763275', '2025-07-01 09:52:21.763278'),
(2, 'KV', 'Kaas en vleeswaren', b'1', NULL, '2025-07-01 09:52:21.763383', '2025-07-01 09:52:21.763383'),
(3, 'ZPE', 'Zuivel plantaardig en eieren', b'1', NULL, '2025-07-01 09:52:21.763392', '2025-07-01 09:52:21.763392'),
(4, 'BB', 'Bakkerij en Banket', b'1', NULL, '2025-07-01 09:52:21.763406', '2025-07-01 09:52:21.763406'),
(5, 'FSKT', 'Frisdranken, sappen, koffie en thee', b'1', NULL, '2025-07-01 09:52:21.763409', '2025-07-01 09:52:21.763409'),
(6, 'PRW', 'Pasta, rijst en wereldkeuken', b'1', NULL, '2025-07-01 09:52:21.763412', '2025-07-01 09:52:21.763412'),
(7, 'SSKO', 'Soepen, sauzen, kruiden en olie', b'1', NULL, '2025-07-01 09:52:21.763414', '2025-07-01 09:52:21.763414'),
(8, 'SKCC', 'Snoep, koek, chips en chocolade', b'1', NULL, '2025-07-01 09:52:21.763416', '2025-07-01 09:52:21.763416'),
(9, 'BVH', 'Baby, verzorging en hygiëne', b'1', NULL, '2025-07-01 09:52:21.763419', '2025-07-01 09:52:21.763419');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Straat` varchar(100) NOT NULL,
  `Huisnummer` varchar(10) NOT NULL,
  `Toevoeging` varchar(10) DEFAULT NULL,
  `Postcode` varchar(10) NOT NULL,
  `Woonplaats` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Mobiel` varchar(20) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contact`
--

INSERT INTO `contact` (`Id`, `Straat`, `Huisnummer`, `Toevoeging`, `Postcode`, `Woonplaats`, `Email`, `Mobiel`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Prinses Irenestraat', '12', 'A', '5271TH', 'Maaskantje', 'j.van.zevenhuizen@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777132', '2025-07-01 09:52:21.777134'),
(2, 'Gibraltarstraat', '234', NULL, '5271TJ', 'Maaskantje', 'a.bergkamp@hotmail.com', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777173', '2025-07-01 09:52:21.777173'),
(3, 'Der Kinderenstraat', '456', 'Bis', '5271TH', 'Maaskantje', 's.van.de.heuvel@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777180', '2025-07-01 09:52:21.777180'),
(4, 'Nachtegaalstraat', '233', 'A', '5271TJ', 'Maaskantje', 'e.scherder@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777183', '2025-07-01 09:52:21.777183'),
(5, 'Bertram Russellstraat', '45', NULL, '5271TH', 'Maaskantje', 'f.de.jong@hotmail.com', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777186', '2025-07-01 09:52:21.777186'),
(6, 'Leonardo Da VinciHof', '34', NULL, '5271ZE', 'Maaskantje', 'h.van.der.berg@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777190', '2025-07-01 09:52:21.777190'),
(7, 'Siegfried Knutsenlaan', '234', NULL, '5271ZE', 'Maaskantje', 'r.ter.weijden@ah.nl', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777192', '2025-07-01 09:52:21.777192'),
(8, 'Theo de Bokstraat', '256', NULL, '5271ZH', 'Maaskantje', 'l.pastoor@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777195', '2025-07-01 09:52:21.777195'),
(9, 'Meester van Leerhof', '2', 'A', '5271ZH', 'Maaskantje', 'm.yazidi@gemeenteutrecht.nl', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777198', '2025-07-01 09:52:21.777198'),
(10, 'Van Wemelenplantsoen', '300', NULL, '5271TH', 'Maaskantje', 'b.van.driel@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 09:52:21.777200', '2025-07-01 09:52:21.777201'),
(11, 'Terlingenhof', '20', NULL, '5271TH', 'Maaskantje', 'j.pastorius@gmail.com', '+31 623456356', b'1', NULL, '2025-07-01 09:52:21.777203', '2025-07-01 09:52:21.777203'),
(12, 'Veldhoen', '31', NULL, '5271ZE', 'Maaskantje', 's.dollaard@gmail.com', '+31 623452314', b'1', NULL, '2025-07-01 09:52:21.777205', '2025-07-01 09:52:21.777205'),
(13, 'ScheringaDreef', '37', NULL, '5271ZE', 'Vught', 'j.blokker@gemeentevught.nl', '+31 623452314', b'1', NULL, '2025-07-01 09:52:21.777208', '2025-07-01 09:52:21.777208');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contactpergezin`
--

DROP TABLE IF EXISTS `contactpergezin`;
CREATE TABLE IF NOT EXISTS `contactpergezin` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `GezinId` smallint UNSIGNED NOT NULL,
  `ContactId` smallint UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ContactPerGezin_GezinId` (`GezinId`),
  KEY `FK_ContactPerGezin_ContactId` (`ContactId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contactpergezin`
--

INSERT INTO `contactpergezin` (`Id`, `GezinId`, `ContactId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, b'1', NULL, '2025-07-01 09:52:22.184270', '2025-07-01 09:52:22.184272'),
(2, 2, 2, b'1', NULL, '2025-07-01 09:52:22.184339', '2025-07-01 09:52:22.184340'),
(3, 3, 3, b'1', NULL, '2025-07-01 09:52:22.184349', '2025-07-01 09:52:22.184349'),
(4, 4, 4, b'1', NULL, '2025-07-01 09:52:22.184355', '2025-07-01 09:52:22.184355'),
(5, 5, 5, b'1', NULL, '2025-07-01 09:52:22.184360', '2025-07-01 09:52:22.184360'),
(6, 6, 6, b'1', NULL, '2025-07-01 09:52:22.184365', '2025-07-01 09:52:22.184365');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contactperleverancier`
--

DROP TABLE IF EXISTS `contactperleverancier`;
CREATE TABLE IF NOT EXISTS `contactperleverancier` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `LeverancierId` smallint UNSIGNED NOT NULL,
  `ContactId` smallint UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ContactPerLeverancier_LeverancierId` (`LeverancierId`),
  KEY `FK_ContactPerLeverancier_ContactId` (`ContactId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contactperleverancier`
--

INSERT INTO `contactperleverancier` (`Id`, `LeverancierId`, `ContactId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 7, b'1', NULL, '2025-07-01 09:52:22.175118', '2025-07-01 09:52:22.175120'),
(2, 2, 8, b'1', NULL, '2025-07-01 09:52:22.175189', '2025-07-01 09:52:22.175189'),
(3, 3, 9, b'1', NULL, '2025-07-01 09:52:22.175199', '2025-07-01 09:52:22.175199'),
(4, 4, 10, b'1', NULL, '2025-07-01 09:52:22.175204', '2025-07-01 09:52:22.175204'),
(5, 6, 11, b'1', NULL, '2025-07-01 09:52:22.175209', '2025-07-01 09:52:22.175209'),
(6, 7, 12, b'1', NULL, '2025-07-01 09:52:22.175215', '2025-07-01 09:52:22.175215'),
(7, 8, 13, b'1', NULL, '2025-07-01 09:52:22.175219', '2025-07-01 09:52:22.175220');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `eetwens`
--

DROP TABLE IF EXISTS `eetwens`;
CREATE TABLE IF NOT EXISTS `eetwens` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam` varchar(50) NOT NULL,
  `Omschrijving` varchar(255) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `eetwens`
--

INSERT INTO `eetwens` (`Id`, `Naam`, `Omschrijving`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'GeenVarken', 'Geen Varkensvlees', b'1', NULL, '2025-07-01 09:52:21.784664', '2025-07-01 09:52:21.784665'),
(2, 'Veganistisch', 'Geen zuivelproducten en vlees', b'1', NULL, '2025-07-01 09:52:21.784699', '2025-07-01 09:52:21.784700'),
(3, 'Vegetarisch', 'Geen vlees', b'1', NULL, '2025-07-01 09:52:21.784705', '2025-07-01 09:52:21.784705'),
(4, 'Omnivoor', 'Geen beperkingen', b'1', NULL, '2025-07-01 09:52:21.784708', '2025-07-01 09:52:21.784708');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `eetwenspergezin`
--

DROP TABLE IF EXISTS `eetwenspergezin`;
CREATE TABLE IF NOT EXISTS `eetwenspergezin` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `GezinId` smallint UNSIGNED NOT NULL,
  `EetwensId` smallint UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_EetwensPerGezin_GezinId` (`GezinId`),
  KEY `FK_EetwensPerGezin_EetwensId` (`EetwensId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `eetwenspergezin`
--

INSERT INTO `eetwenspergezin` (`Id`, `GezinId`, `EetwensId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 2, b'1', NULL, '2025-07-01 09:52:22.165446', '2025-07-01 09:52:22.165447'),
(2, 2, 4, b'1', NULL, '2025-07-01 09:52:22.165508', '2025-07-01 09:52:22.165508'),
(3, 3, 4, b'1', NULL, '2025-07-01 09:52:22.165517', '2025-07-01 09:52:22.165517'),
(4, 4, 3, b'1', NULL, '2025-07-01 09:52:22.165522', '2025-07-01 09:52:22.165522'),
(5, 5, 2, b'1', NULL, '2025-07-01 09:52:22.165527', '2025-07-01 09:52:22.165527');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

DROP TABLE IF EXISTS `gebruiker`;
CREATE TABLE IF NOT EXISTS `gebruiker` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `PersoonId` smallint UNSIGNED NOT NULL,
  `InlogNaam` varchar(50) NOT NULL,
  `Gebruikersnaam` varchar(100) NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `IsIngelogd` bit(1) NOT NULL DEFAULT b'0',
  `Ingelogd` datetime(6) DEFAULT NULL,
  `Uitgelogd` datetime(6) DEFAULT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `InlogNaam` (`InlogNaam`),
  KEY `FK_Gebruiker_PersoonId` (`PersoonId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`Id`, `PersoonId`, `InlogNaam`, `Gebruikersnaam`, `Wachtwoord`, `IsIngelogd`, `Ingelogd`, `Uitgelogd`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 'Hans', 'hans@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL6zKiF0i', b'1', '2024-03-13 17:03:06.000000', NULL, b'1', NULL, '2025-07-01 09:52:21.855183', '2025-07-01 09:52:21.855184'),
(2, 2, 'Jan', 'jan@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL3zKiF6i', b'0', '2024-03-13 15:13:23.000000', '2024-03-13 15:23:46.000000', b'1', NULL, '2025-07-01 09:52:21.855225', '2025-07-01 09:52:21.855225'),
(3, 3, 'Herman', 'herman@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVuwCp/DL9zKiF2i', b'1', '2024-06-20 12:05:20.000000', NULL, b'1', NULL, '2025-07-01 09:52:21.855236', '2025-07-01 09:52:21.855236');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gezin`
--

DROP TABLE IF EXISTS `gezin`;
CREATE TABLE IF NOT EXISTS `gezin` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Code` varchar(10) NOT NULL,
  `Omschrijving` varchar(255) NOT NULL,
  `AantalVolwassenen` tinyint UNSIGNED NOT NULL,
  `AantalKinderen` tinyint UNSIGNED NOT NULL,
  `AantalBabys` tinyint UNSIGNED NOT NULL,
  `TotaalAantalPersonen` tinyint UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Code` (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gezin`
--

INSERT INTO `gezin` (`Id`, `Naam`, `Code`, `Omschrijving`, `AantalVolwassenen`, `AantalKinderen`, `AantalBabys`, `TotaalAantalPersonen`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'ZevenhuizenGezin', 'G0001', 'Bijstandsgezin', 2, 2, 0, 4, b'1', NULL, '2025-07-01 09:52:21.802278', '2025-07-01 09:52:21.802280'),
(2, 'BergkampGezin', 'G0002', 'Bijstandsgezin', 2, 1, 1, 4, b'1', NULL, '2025-07-01 09:52:21.802325', '2025-07-01 09:52:21.802325'),
(3, 'HeuvelGezin', 'G0003', 'Bijstandsgezin', 2, 0, 0, 2, b'1', NULL, '2025-07-01 09:52:21.802346', '2025-07-01 09:52:21.802346'),
(4, 'ScherderGezin', 'G0004', 'Bijstandsgezin', 1, 0, 2, 3, b'1', NULL, '2025-07-01 09:52:21.802350', '2025-07-01 09:52:21.802350'),
(5, 'DeJongGezin', 'G0005', 'Bijstandsgezin', 1, 1, 0, 2, b'1', NULL, '2025-07-01 09:52:21.802354', '2025-07-01 09:52:21.802354'),
(6, 'VanderBergGezin', 'G0006', 'AlleenGaande', 1, 0, 0, 1, b'1', NULL, '2025-07-01 09:52:21.802358', '2025-07-01 09:52:21.802358');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leverancier`
--

DROP TABLE IF EXISTS `leverancier`;
CREATE TABLE IF NOT EXISTS `leverancier` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `ContactPersoon` varchar(100) NOT NULL,
  `LeverancierNummer` varchar(20) NOT NULL,
  `LeverancierType` varchar(50) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `LeverancierNummer` (`LeverancierNummer`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `leverancier`
--

INSERT INTO `leverancier` (`Id`, `Naam`, `ContactPersoon`, `LeverancierNummer`, `LeverancierType`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Albert Heijn', 'Ruud ter Weijden', 'L0001', 'Bedrijf', b'1', NULL, '2025-07-01 09:52:21.811238', '2025-07-01 09:52:21.811239'),
(2, 'Albertus Kerk', 'Leo Pastoor', 'L0002', 'Instelling', b'1', NULL, '2025-07-01 09:52:21.811278', '2025-07-01 09:52:21.811278'),
(3, 'Gemeente Utrecht', 'Mohammed Yazidi', 'L0003', 'Overheid', b'1', NULL, '2025-07-01 09:52:21.811298', '2025-07-01 09:52:21.811298'),
(4, 'Boerderij Meerhoven', 'Bertus van Driel', 'L0004', 'Particulier', b'1', NULL, '2025-07-01 09:52:21.811302', '2025-07-01 09:52:21.811302'),
(5, 'Jan van der Heijden', 'Jan van der Heijden', 'L0005', 'Donor', b'1', NULL, '2025-07-01 09:52:21.811312', '2025-07-01 09:52:21.811312'),
(6, 'Vomar', 'Jaco Pastorius', 'L0006', 'Bedrijf', b'1', NULL, '2025-07-01 09:52:21.811321', '2025-07-01 09:52:21.811321'),
(7, 'DekaMarkt', 'Sil den Dollaard', 'L0007', 'Bedrijf', b'1', NULL, '2025-07-01 09:52:21.811324', '2025-07-01 09:52:21.811324'),
(8, 'Gemeente Vught', 'Jan Blokker', 'L0008', 'Overheid', b'1', NULL, '2025-07-01 09:52:21.811327', '2025-07-01 09:52:21.811327');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `magazijn`
--

DROP TABLE IF EXISTS `magazijn`;
CREATE TABLE IF NOT EXISTS `magazijn` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Ontvangstdatum` date NOT NULL,
  `Uitleveringsdatum` date DEFAULT NULL,
  `VerpakkingsEenheid` varchar(50) NOT NULL,
  `Aantal` int UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `magazijn`
--

INSERT INTO `magazijn` (`Id`, `Ontvangstdatum`, `Uitleveringsdatum`, `VerpakkingsEenheid`, `Aantal`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, '2024-05-12', NULL, '5 kg', 20, b'1', NULL, '2025-07-01 09:52:21.830992', '2025-07-01 09:52:21.830994'),
(2, '2024-05-26', NULL, '2.5 kg', 40, b'1', NULL, '2025-07-01 09:52:21.831037', '2025-07-01 09:52:21.831037'),
(3, '2024-04-02', NULL, '1 kg', 30, b'1', NULL, '2025-07-01 09:52:21.831043', '2025-07-01 09:52:21.831044'),
(4, '2024-05-16', NULL, '1.5 kg', 25, b'1', NULL, '2025-07-01 09:52:21.831046', '2025-07-01 09:52:21.831046'),
(5, '2024-05-23', NULL, '4 stuks', 75, b'1', NULL, '2025-07-01 09:52:21.831048', '2025-07-01 09:52:21.831049'),
(6, '2024-03-12', NULL, '1 kg/tros', 60, b'1', NULL, '2025-07-01 09:52:21.831051', '2025-07-01 09:52:21.831051'),
(7, '2024-03-19', NULL, '2 kg/tros', 200, b'1', NULL, '2025-07-01 09:52:21.831053', '2025-07-01 09:52:21.831053'),
(8, '2024-06-19', NULL, '200 g', 45, b'1', NULL, '2025-07-01 09:52:21.831055', '2025-07-01 09:52:21.831055'),
(9, '2024-07-23', NULL, '100 g', 60, b'1', NULL, '2025-07-01 09:52:21.831058', '2025-07-01 09:52:21.831058'),
(10, '2024-07-23', NULL, '1 liter', 120, b'1', NULL, '2025-07-01 09:52:21.831060', '2025-07-01 09:52:21.831060'),
(11, '2024-06-02', NULL, '250 g', 80, b'1', NULL, '2025-07-01 09:52:21.831062', '2025-07-01 09:52:21.831062'),
(12, '2024-01-04', NULL, '6 stuks', 120, b'1', NULL, '2025-07-01 09:52:21.831064', '2025-07-01 09:52:21.831064'),
(13, '2024-04-07', NULL, '800 g', 220, b'1', NULL, '2025-07-01 09:52:21.831066', '2025-07-01 09:52:21.831066'),
(14, '2024-04-04', NULL, '1 stuk', 130, b'1', NULL, '2025-07-01 09:52:21.831068', '2025-07-01 09:52:21.831068'),
(15, '2024-04-28', NULL, '150 ml', 72, b'1', NULL, '2025-07-01 09:52:21.831070', '2025-07-01 09:52:21.831070'),
(16, '2024-04-19', NULL, '1 l', 12, b'1', NULL, '2025-07-01 09:52:21.831072', '2025-07-01 09:52:21.831072'),
(17, '2024-04-23', NULL, '250 g', 300, b'1', NULL, '2025-07-01 09:52:21.831076', '2025-07-01 09:52:21.831076'),
(18, '2024-03-02', NULL, '25 zakjes', 280, b'1', NULL, '2025-07-01 09:52:21.831079', '2025-07-01 09:52:21.831079'),
(19, '2024-04-16', NULL, '500 g', 330, b'1', NULL, '2025-07-01 09:52:21.831081', '2025-07-01 09:52:21.831081'),
(20, '2024-04-25', NULL, '1 kg', 34, b'1', NULL, '2025-07-01 09:52:21.831083', '2025-07-01 09:52:21.831083'),
(21, '2024-04-13', NULL, '50 g', 23, b'1', NULL, '2025-07-01 09:52:21.831085', '2025-07-01 09:52:21.831085'),
(22, '2024-04-23', NULL, '1 l', 46, b'1', NULL, '2025-07-01 09:52:21.831087', '2025-07-01 09:52:21.831087'),
(23, '2024-04-21', NULL, '250 ml', 98, b'1', NULL, '2025-07-01 09:52:21.831089', '2025-07-01 09:52:21.831089'),
(24, '2024-04-30', NULL, '1 potje', 56, b'1', NULL, '2025-07-01 09:52:21.831091', '2025-07-01 09:52:21.831091'),
(25, '2024-04-27', NULL, '1 l', 210, b'1', NULL, '2025-07-01 09:52:21.831093', '2025-07-01 09:52:21.831094'),
(26, '2024-04-01', NULL, '4 stuks', 24, b'1', NULL, '2025-07-01 09:52:21.831095', '2025-07-01 09:52:21.831096'),
(27, '2024-04-07', NULL, '300 g', 87, b'1', NULL, '2025-07-01 09:52:21.831098', '2025-07-01 09:52:21.831098'),
(28, '2024-04-22', NULL, '200 g', 230, b'1', NULL, '2025-07-01 09:52:21.831100', '2025-07-01 09:52:21.831100'),
(29, '2024-04-21', NULL, '80 g', 30, b'1', NULL, '2025-07-01 09:52:21.831102', '2025-07-01 09:52:21.831102');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `persoon`
--

DROP TABLE IF EXISTS `persoon`;
CREATE TABLE IF NOT EXISTS `persoon` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `GezinId` smallint UNSIGNED DEFAULT NULL,
  `Voornaam` varchar(50) NOT NULL,
  `Tussenvoegsel` varchar(20) DEFAULT NULL,
  `Achternaam` varchar(50) NOT NULL,
  `Geboortedatum` date NOT NULL,
  `TypePersoon` varchar(50) NOT NULL,
  `IsVertegenwoordiger` bit(1) NOT NULL DEFAULT b'0',
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Persoon_GezinId` (`GezinId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `persoon`
--

INSERT INTO `persoon` (`Id`, `GezinId`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Geboortedatum`, `TypePersoon`, `IsVertegenwoordiger`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, NULL, 'Hans', 'van', 'Leeuwen', '1958-02-12', 'Manager', b'0', b'1', NULL, '2025-07-01 09:52:21.846660', '2025-07-01 09:52:21.846661'),
(2, NULL, 'Jan', 'van der', 'Sluijs', '1993-04-30', 'Medewerker', b'0', b'1', NULL, '2025-07-01 09:52:21.846714', '2025-07-01 09:52:21.846714'),
(3, NULL, 'Herman', 'den', 'Duiker', '1989-08-30', 'Vrijwilliger', b'0', b'1', NULL, '2025-07-01 09:52:21.846722', '2025-07-01 09:52:21.846722'),
(4, 1, 'Johan', 'van', 'Zevenhuizen', '1990-05-20', 'Klant', b'1', b'1', NULL, '2025-07-01 09:52:21.846728', '2025-07-01 09:52:21.846728'),
(5, 1, 'Sarah', 'den', 'Dolder', '1985-03-23', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846736', '2025-07-01 09:52:21.846736'),
(6, 1, 'Theo', 'van', 'Zevenhuizen', '2015-03-08', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846740', '2025-07-01 09:52:21.846740'),
(7, 1, 'Jantien', 'van', 'Zevenhuizen', '2016-09-20', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846744', '2025-07-01 09:52:21.846744'),
(8, 2, 'Arjan', NULL, 'Bergkamp', '1968-07-12', 'Klant', b'1', b'1', NULL, '2025-07-01 09:52:21.846748', '2025-07-01 09:52:21.846748'),
(9, 2, 'Janneke', NULL, 'Sanders', '1969-05-11', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846752', '2025-07-01 09:52:21.846752'),
(10, 2, 'Stein', NULL, 'Bergkamp', '2009-02-02', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846756', '2025-07-01 09:52:21.846756'),
(11, 2, 'Judith', NULL, 'Bergkamp', '2022-02-05', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846760', '2025-07-01 09:52:21.846760'),
(12, 3, 'Mazin', 'van', 'Vliet', '1968-08-18', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846764', '2025-07-01 09:52:21.846764'),
(13, 3, 'Selma', 'van de', 'Heuvel', '1965-09-04', 'Klant', b'1', b'1', NULL, '2025-07-01 09:52:21.846768', '2025-07-01 09:52:21.846768'),
(14, 4, 'Eva', NULL, 'Scherder', '2000-04-07', 'Klant', b'1', b'1', NULL, '2025-07-01 09:52:21.846771', '2025-07-01 09:52:21.846771'),
(15, 4, 'Felicia', NULL, 'Scherder', '2021-11-29', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846775', '2025-07-01 09:52:21.846776'),
(16, 4, 'Devin', NULL, 'Scherder', '2024-03-01', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846779', '2025-07-01 09:52:21.846779'),
(17, 5, 'Frieda', 'de', 'Jong', '1980-09-04', 'Klant', b'1', b'1', NULL, '2025-07-01 09:52:21.846783', '2025-07-01 09:52:21.846783'),
(18, 5, 'Simeon', 'de', 'Jong', '2018-05-23', 'Klant', b'0', b'1', NULL, '2025-07-01 09:52:21.846787', '2025-07-01 09:52:21.846787'),
(19, 6, 'Hanna', 'van der', 'Berg', '1999-09-09', 'Klant', b'1', b'1', NULL, '2025-07-01 09:52:21.846791', '2025-07-01 09:52:21.846791');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `CategorieId` smallint UNSIGNED NOT NULL,
  `Naam` varchar(100) NOT NULL,
  `SoortAllergie` varchar(100) DEFAULT NULL,
  `Barcode` varchar(50) NOT NULL,
  `Houdbaarheidsdatum` date NOT NULL,
  `Omschrijving` varchar(255) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Product_CategorieId` (`CategorieId`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`Id`, `CategorieId`, `Naam`, `SoortAllergie`, `Barcode`, `Houdbaarheidsdatum`, `Omschrijving`, `Status`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 'Aardappel', NULL, '8719587321239', '2024-07-12', 'Kruimige aardappel', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119465', '2025-07-01 09:52:22.119467'),
(2, 1, 'Aardappel', NULL, '8719587321239', '2024-07-26', 'Kruimige aardappel', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119563', '2025-07-01 09:52:22.119563'),
(3, 1, 'Ui', NULL, '8719437321335', '2024-09-02', 'Gele ui', 'NietOpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119581', '2025-07-01 09:52:22.119582'),
(4, 1, 'Appel', NULL, '8719486321332', '2024-08-16', 'Granny Smith', 'NietLeverbaar', b'1', NULL, '2025-07-01 09:52:22.119592', '2025-07-01 09:52:22.119592'),
(5, 1, 'Appel', NULL, '8719486321332', '2024-09-23', 'Granny Smith', 'NietLeverbaar', b'1', NULL, '2025-07-01 09:52:22.119601', '2025-07-01 09:52:22.119601'),
(6, 1, 'Banaan', 'Banaan', '8719484321336', '2024-07-12', 'Biologische Banaan', 'OverHoudbaarheidsDatum', b'1', NULL, '2025-07-01 09:52:22.119610', '2025-07-01 09:52:22.119610'),
(7, 1, 'Banaan', 'Banaan', '8719484321336', '2024-07-19', 'Biologische Banaan', 'OverHoudbaarheidsDatum', b'1', NULL, '2025-07-01 09:52:22.119619', '2025-07-01 09:52:22.119619'),
(8, 2, 'Kaas', 'Lactose', '8719487421338', '2024-09-19', 'Jonge Kaas', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119632', '2025-07-01 09:52:22.119632'),
(9, 2, 'Rosbief', NULL, '8719487421331', '2024-07-23', 'Rundvlees', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119641', '2025-07-01 09:52:22.119641'),
(10, 3, 'Melk', 'Lactose', '8719447321332', '2024-07-23', 'Halfvolle melk', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119650', '2025-07-01 09:52:22.119650'),
(11, 3, 'Margarine', NULL, '8719486321336', '2024-08-02', 'Plantaardige boter', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119661', '2025-07-01 09:52:22.119661'),
(12, 3, 'Ei', 'Eier', '8719487421334', '2024-08-04', 'Scharrelei', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119674', '2025-07-01 09:52:22.119674'),
(13, 4, 'Brood', 'Gluten', '8719487721337', '2024-07-07', 'Volkoren brood', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119683', '2025-07-01 09:52:22.119683'),
(14, 4, 'Gevulde Koek', 'Amandel', '8719483321333', '2024-09-04', 'Banketbakkers kwaliteit', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119692', '2025-07-01 09:52:22.119692'),
(15, 5, 'Fristi', 'Lactose', '8719487121331', '2024-10-28', 'Frisdrank', 'NietOpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119700', '2025-07-01 09:52:22.119701'),
(16, 5, 'Appelsap', NULL, '8719487521335', '2024-10-19', '100% vruchtensap', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119709', '2025-07-01 09:52:22.119709'),
(17, 5, 'Koffie', 'Caffeïne', '8719487381338', '2024-10-23', 'Arabica koffie', 'OverHoudbaarheidsDatum', b'1', NULL, '2025-07-01 09:52:22.119718', '2025-07-01 09:52:22.119718'),
(18, 5, 'Thee', 'Theïne', '8719487329339', '2024-09-02', 'Ceylon thee', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119726', '2025-07-01 09:52:22.119726'),
(19, 6, 'Pasta', 'Gluten', '8719487321334', '2024-12-16', 'Macaroni', 'NietLeverbaar', b'1', NULL, '2025-07-01 09:52:22.119734', '2025-07-01 09:52:22.119734'),
(20, 6, 'Rijst', NULL, '8719487331332', '2024-12-25', 'Basmati Rijst', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119742', '2025-07-01 09:52:22.119743'),
(21, 6, 'Knorr Nasi Mix', NULL, '871948735135', '2024-12-13', 'Nasi kruiden', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119751', '2025-07-01 09:52:22.119751'),
(22, 7, 'Tomatensoep', NULL, '8719487371337', '2024-12-23', 'Romige tomatensoep', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119759', '2025-07-01 09:52:22.119759'),
(23, 7, 'Tomatensaus', NULL, '8719487341334', '2024-12-21', 'Pizza saus', 'NietOpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119767', '2025-07-01 09:52:22.119768'),
(24, 7, 'Peterselie', NULL, '8719487321636', '2024-07-31', 'Verse kruidenpot', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119776', '2025-07-01 09:52:22.119776'),
(25, 8, 'Olie', NULL, '8719487327337', '2024-12-27', 'Olijfolie', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119784', '2025-07-01 09:52:22.119784'),
(26, 8, 'Mars', NULL, '8719487324334', '2024-12-11', 'Snoep', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119793', '2025-07-01 09:52:22.119793'),
(27, 8, 'Biscuit', NULL, '8719487311331', '2024-08-07', 'San Francisco biscuit', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119801', '2025-07-01 09:52:22.119801'),
(28, 8, 'Paprika Chips', NULL, '87194873218398', '2024-12-22', 'Ribbelchips paprika', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119810', '2025-07-01 09:52:22.119810'),
(29, 8, 'Chocolade reep', 'Cacoa', '8719487321533', '2024-11-21', 'Tony Chocolonely', 'OpVoorraad', b'1', NULL, '2025-07-01 09:52:22.119821', '2025-07-01 09:52:22.119821');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productperleverancier`
--

DROP TABLE IF EXISTS `productperleverancier`;
CREATE TABLE IF NOT EXISTS `productperleverancier` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `LeverancierId` smallint UNSIGNED NOT NULL,
  `ProductId` smallint UNSIGNED NOT NULL,
  `DatumAangeleverd` date NOT NULL,
  `DatumEerstVolgendeLevering` date NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ProductPerLeverancier_LeverancierId` (`LeverancierId`),
  KEY `FK_ProductPerLeverancier_ProductId` (`ProductId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `productperleverancier`
--

INSERT INTO `productperleverancier` (`Id`, `LeverancierId`, `ProductId`, `DatumAangeleverd`, `DatumEerstVolgendeLevering`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 4, 1, '2024-04-12', '2024-05-12', b'1', NULL, '2025-07-01 09:52:22.214259', '2025-07-01 09:52:22.214261'),
(2, 4, 2, '2024-03-02', '2024-04-02', b'1', NULL, '2025-07-01 09:52:22.214340', '2025-07-01 09:52:22.214340'),
(3, 2, 3, '2024-07-16', '2024-08-16', b'1', NULL, '2025-07-01 09:52:22.214352', '2025-07-01 09:52:22.214352'),
(4, 1, 4, '2024-02-12', '2024-03-12', b'1', NULL, '2025-07-01 09:52:22.214359', '2025-07-01 09:52:22.214359'),
(5, 4, 5, '2024-05-19', '2024-06-19', b'1', NULL, '2025-07-01 09:52:22.214365', '2025-07-01 09:52:22.214366'),
(6, 1, 6, '2024-06-23', '2024-07-23', b'1', NULL, '2025-07-01 09:52:22.214372', '2025-07-01 09:52:22.214372'),
(7, 4, 7, '2024-06-20', '2024-07-20', b'1', NULL, '2025-07-01 09:52:22.214378', '2025-07-01 09:52:22.214378'),
(8, 4, 8, '2024-05-02', '2024-06-02', b'1', NULL, '2025-07-01 09:52:22.214384', '2025-07-01 09:52:22.214384'),
(9, 4, 9, '2022-12-04', '2024-01-04', b'1', NULL, '2025-07-01 09:52:22.214391', '2025-07-01 09:52:22.214391'),
(10, 3, 10, '2024-03-07', '2024-04-07', b'1', NULL, '2025-07-01 09:52:22.214397', '2025-07-01 09:52:22.214397'),
(11, 3, 11, '2024-02-04', '2024-03-04', b'1', NULL, '2025-07-01 09:52:22.214403', '2025-07-01 09:52:22.214403'),
(12, 3, 12, '2024-02-28', '2024-03-28', b'1', NULL, '2025-07-01 09:52:22.214413', '2025-07-01 09:52:22.214413'),
(13, 3, 13, '2024-03-19', '2024-04-19', b'1', NULL, '2025-07-01 09:52:22.214418', '2025-07-01 09:52:22.214419'),
(14, 2, 14, '2024-03-23', '2024-04-23', b'1', NULL, '2025-07-01 09:52:22.214424', '2025-07-01 09:52:22.214424'),
(15, 2, 15, '2024-02-02', '2024-03-02', b'1', NULL, '2025-07-01 09:52:22.214430', '2025-07-01 09:52:22.214430'),
(16, 1, 16, '2024-02-16', '2024-03-16', b'1', NULL, '2025-07-01 09:52:22.214435', '2025-07-01 09:52:22.214435'),
(17, 1, 17, '2024-03-25', '2024-04-25', b'1', NULL, '2025-07-01 09:52:22.214441', '2025-07-01 09:52:22.214441'),
(18, 1, 18, '2024-03-13', '2024-04-13', b'1', NULL, '2025-07-01 09:52:22.214447', '2025-07-01 09:52:22.214447'),
(19, 1, 19, '2024-03-23', '2024-04-23', b'1', NULL, '2025-07-01 09:52:22.214452', '2025-07-01 09:52:22.214452'),
(20, 4, 20, '2024-02-21', '2024-03-21', b'1', NULL, '2025-07-01 09:52:22.214457', '2025-07-01 09:52:22.214458'),
(21, 2, 21, '2024-03-31', '2024-04-30', b'1', NULL, '2025-07-01 09:52:22.214463', '2025-07-01 09:52:22.214463'),
(22, 1, 22, '2024-03-27', '2024-04-27', b'1', NULL, '2025-07-01 09:52:22.214471', '2025-07-01 09:52:22.214471'),
(23, 3, 23, '2024-04-11', '2024-04-18', b'1', NULL, '2025-07-01 09:52:22.214479', '2025-07-01 09:52:22.214479'),
(24, 3, 24, '2024-04-07', '2024-04-14', b'1', NULL, '2025-07-01 09:52:22.214486', '2025-07-01 09:52:22.214486'),
(25, 1, 25, '2024-05-07', '2024-05-14', b'1', NULL, '2025-07-01 09:52:22.214492', '2025-07-01 09:52:22.214492'),
(26, 2, 26, '2024-05-05', '2024-05-12', b'1', NULL, '2025-07-01 09:52:22.214498', '2025-07-01 09:52:22.214498');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productpermagazijn`
--

DROP TABLE IF EXISTS `productpermagazijn`;
CREATE TABLE IF NOT EXISTS `productpermagazijn` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ProductId` smallint UNSIGNED NOT NULL,
  `MagazijnId` smallint UNSIGNED NOT NULL,
  `Locatie` varchar(50) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ProductPerMagazijn_ProductId` (`ProductId`),
  KEY `FK_ProductPerMagazijn_MagazijnId` (`MagazijnId`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `productpermagazijn`
--

INSERT INTO `productpermagazijn` (`Id`, `ProductId`, `MagazijnId`, `Locatie`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, 'Berlicum', b'1', NULL, '2025-07-01 09:52:22.231376', '2025-07-01 09:52:22.231379'),
(2, 2, 2, 'Rosmalen', b'1', NULL, '2025-07-01 09:52:22.231458', '2025-07-01 09:52:22.231459'),
(3, 3, 3, 'Berlicum', b'1', NULL, '2025-07-01 09:52:22.231470', '2025-07-01 09:52:22.231471'),
(4, 4, 4, 'Berlicum', b'1', NULL, '2025-07-01 09:52:22.231477', '2025-07-01 09:52:22.231477'),
(5, 5, 5, 'Rosmalen', b'1', NULL, '2025-07-01 09:52:22.231483', '2025-07-01 09:52:22.231483'),
(6, 6, 6, 'Berlicum', b'1', NULL, '2025-07-01 09:52:22.231489', '2025-07-01 09:52:22.231489'),
(7, 7, 7, 'Rosmalen', b'1', NULL, '2025-07-01 09:52:22.231495', '2025-07-01 09:52:22.231495'),
(8, 8, 8, 'Sint-MichelsGestel', b'1', NULL, '2025-07-01 09:52:22.231501', '2025-07-01 09:52:22.231501'),
(9, 9, 9, 'Sint-MichelsGestel', b'1', NULL, '2025-07-01 09:52:22.231506', '2025-07-01 09:52:22.231507'),
(10, 10, 10, 'Middelrode', b'1', NULL, '2025-07-01 09:52:22.231512', '2025-07-01 09:52:22.231512'),
(11, 11, 11, 'Middelrode', b'1', NULL, '2025-07-01 09:52:22.231518', '2025-07-01 09:52:22.231518'),
(12, 12, 12, 'Middelrode', b'1', NULL, '2025-07-01 09:52:22.231525', '2025-07-01 09:52:22.231525'),
(13, 13, 13, 'Schijndel', b'1', NULL, '2025-07-01 09:52:22.231530', '2025-07-01 09:52:22.231531'),
(14, 14, 14, 'Schijndel', b'1', NULL, '2025-07-01 09:52:22.231536', '2025-07-01 09:52:22.231536'),
(15, 15, 15, 'Gemonde', b'1', NULL, '2025-07-01 09:52:22.231541', '2025-07-01 09:52:22.231541'),
(16, 16, 16, 'Gemonde', b'1', NULL, '2025-07-01 09:52:22.231547', '2025-07-01 09:52:22.231547'),
(17, 17, 17, 'Gemonde', b'1', NULL, '2025-07-01 09:52:22.231552', '2025-07-01 09:52:22.231552'),
(18, 18, 18, 'Gemonde', b'1', NULL, '2025-07-01 09:52:22.231558', '2025-07-01 09:52:22.231558'),
(19, 19, 19, 'Den Bosch', b'1', NULL, '2025-07-01 09:52:22.231563', '2025-07-01 09:52:22.231563'),
(20, 20, 20, 'Den Bosch', b'1', NULL, '2025-07-01 09:52:22.231568', '2025-07-01 09:52:22.231568'),
(21, 21, 21, 'Den Bosch', b'1', NULL, '2025-07-01 09:52:22.231573', '2025-07-01 09:52:22.231573'),
(22, 22, 22, 'Heeswijk Dinther', b'1', NULL, '2025-07-01 09:52:22.231579', '2025-07-01 09:52:22.231579'),
(23, 23, 23, 'Heeswijk Dinther', b'1', NULL, '2025-07-01 09:52:22.231584', '2025-07-01 09:52:22.231584'),
(24, 24, 24, 'Heeswijk Dinther', b'1', NULL, '2025-07-01 09:52:22.231590', '2025-07-01 09:52:22.231590'),
(25, 25, 25, 'Vught', b'1', NULL, '2025-07-01 09:52:22.231595', '2025-07-01 09:52:22.231595'),
(26, 26, 26, 'Vught', b'1', NULL, '2025-07-01 09:52:22.231602', '2025-07-01 09:52:22.231602'),
(27, 27, 27, 'Vught', b'1', NULL, '2025-07-01 09:52:22.231607', '2025-07-01 09:52:22.231607'),
(28, 28, 28, 'Vught', b'1', NULL, '2025-07-01 09:52:22.231612', '2025-07-01 09:52:22.231612'),
(29, 29, 29, 'Vught', b'1', NULL, '2025-07-01 09:52:22.231617', '2025-07-01 09:52:22.231617');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productpervoedselpakket`
--

DROP TABLE IF EXISTS `productpervoedselpakket`;
CREATE TABLE IF NOT EXISTS `productpervoedselpakket` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `VoedselpakketId` smallint UNSIGNED NOT NULL,
  `ProductId` smallint UNSIGNED NOT NULL,
  `AantalProductEenheden` int UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_ProductPerVoedselpakket_VoedselpakketId` (`VoedselpakketId`),
  KEY `FK_ProductPerVoedselpakket_ProductId` (`ProductId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `productpervoedselpakket`
--

INSERT INTO `productpervoedselpakket` (`Id`, `VoedselpakketId`, `ProductId`, `AantalProductEenheden`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 7, 1, b'1', NULL, '2025-07-01 09:52:22.198267', '2025-07-01 09:52:22.198269'),
(2, 1, 8, 2, b'1', NULL, '2025-07-01 09:52:22.198339', '2025-07-01 09:52:22.198339'),
(3, 1, 9, 1, b'1', NULL, '2025-07-01 09:52:22.198354', '2025-07-01 09:52:22.198354'),
(4, 2, 12, 1, b'1', NULL, '2025-07-01 09:52:22.198360', '2025-07-01 09:52:22.198360'),
(5, 2, 13, 2, b'1', NULL, '2025-07-01 09:52:22.198366', '2025-07-01 09:52:22.198366'),
(6, 2, 14, 1, b'1', NULL, '2025-07-01 09:52:22.198371', '2025-07-01 09:52:22.198371'),
(7, 3, 3, 1, b'1', NULL, '2025-07-01 09:52:22.198376', '2025-07-01 09:52:22.198376'),
(8, 3, 4, 1, b'1', NULL, '2025-07-01 09:52:22.198381', '2025-07-01 09:52:22.198381'),
(9, 4, 20, 1, b'1', NULL, '2025-07-01 09:52:22.198386', '2025-07-01 09:52:22.198386'),
(10, 4, 19, 1, b'1', NULL, '2025-07-01 09:52:22.198391', '2025-07-01 09:52:22.198391'),
(11, 4, 21, 1, b'1', NULL, '2025-07-01 09:52:22.198396', '2025-07-01 09:52:22.198396'),
(12, 5, 24, 1, b'1', NULL, '2025-07-01 09:52:22.198400', '2025-07-01 09:52:22.198400'),
(13, 5, 25, 1, b'1', NULL, '2025-07-01 09:52:22.198405', '2025-07-01 09:52:22.198405'),
(14, 5, 26, 1, b'1', NULL, '2025-07-01 09:52:22.198412', '2025-07-01 09:52:22.198412'),
(15, 6, 26, 1, b'1', NULL, '2025-07-01 09:52:22.198417', '2025-07-01 09:52:22.198417');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam` varchar(50) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `rol`
--

INSERT INTO `rol` (`Id`, `Naam`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Manager', b'1', NULL, '2025-07-01 09:52:21.726809', '2025-07-01 09:52:21.726811'),
(2, 'Medewerker', b'1', NULL, '2025-07-01 09:52:21.726868', '2025-07-01 09:52:21.726868'),
(3, 'Vrijwilliger', b'1', NULL, '2025-07-01 09:52:21.726876', '2025-07-01 09:52:21.726876');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rolpergebruiker`
--

DROP TABLE IF EXISTS `rolpergebruiker`;
CREATE TABLE IF NOT EXISTS `rolpergebruiker` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `GebruikerId` smallint UNSIGNED NOT NULL,
  `RolId` smallint UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_RolPerGebruiker_GebruikerId` (`GebruikerId`),
  KEY `FK_RolPerGebruiker_RolId` (`RolId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `rolpergebruiker`
--

INSERT INTO `rolpergebruiker` (`Id`, `GebruikerId`, `RolId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, b'1', NULL, '2025-07-01 09:52:22.155413', '2025-07-01 09:52:22.155416'),
(2, 2, 2, b'1', NULL, '2025-07-01 09:52:22.155481', '2025-07-01 09:52:22.155481'),
(3, 3, 3, b'1', NULL, '2025-07-01 09:52:22.155490', '2025-07-01 09:52:22.155490');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voedselpakket`
--

DROP TABLE IF EXISTS `voedselpakket`;
CREATE TABLE IF NOT EXISTS `voedselpakket` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `GezinId` smallint UNSIGNED NOT NULL,
  `PakketNummer` int UNSIGNED NOT NULL,
  `DatumSamenstelling` date NOT NULL,
  `DatumUitgifte` date DEFAULT NULL,
  `Status` varchar(50) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Voedselpakket_GezinId` (`GezinId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `voedselpakket`
--

INSERT INTO `voedselpakket` (`Id`, `GezinId`, `PakketNummer`, `DatumSamenstelling`, `DatumUitgifte`, `Status`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, '2024-04-06', '2024-04-07', 'Uitgereikt', b'1', NULL, '2025-07-01 09:52:22.133974', '2025-07-01 09:52:22.133976'),
(2, 1, 2, '2024-04-13', NULL, 'NietUitgereikt', b'1', NULL, '2025-07-01 09:52:22.134045', '2025-07-01 09:52:22.134045'),
(3, 1, 3, '2024-04-20', NULL, 'NietMeerIngeschreven', b'1', NULL, '2025-07-01 09:52:22.134054', '2025-07-01 09:52:22.134054'),
(4, 2, 4, '2024-04-06', '2024-04-07', 'Uitgereikt', b'1', NULL, '2025-07-01 09:52:22.134058', '2025-07-01 09:52:22.134059'),
(5, 2, 5, '2024-04-13', '2024-04-14', 'Uitgereikt', b'1', NULL, '2025-07-01 09:52:22.134063', '2025-07-01 09:52:22.134063'),
(6, 2, 6, '2024-04-20', NULL, 'NietUitgereikt', b'1', NULL, '2025-07-01 09:52:22.134068', '2025-07-01 09:52:22.134068');

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `allergieperpersoon`
--
ALTER TABLE `allergieperpersoon`
  ADD CONSTRAINT `FK_AllergiePerPersoon_AllergieId` FOREIGN KEY (`AllergieId`) REFERENCES `allergie` (`Id`),
  ADD CONSTRAINT `FK_AllergiePerPersoon_PersoonId` FOREIGN KEY (`PersoonId`) REFERENCES `persoon` (`Id`);

--
-- Beperkingen voor tabel `contactpergezin`
--
ALTER TABLE `contactpergezin`
  ADD CONSTRAINT `FK_ContactPerGezin_ContactId` FOREIGN KEY (`ContactId`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `FK_ContactPerGezin_GezinId` FOREIGN KEY (`GezinId`) REFERENCES `gezin` (`Id`);

--
-- Beperkingen voor tabel `contactperleverancier`
--
ALTER TABLE `contactperleverancier`
  ADD CONSTRAINT `FK_ContactPerLeverancier_ContactId` FOREIGN KEY (`ContactId`) REFERENCES `contact` (`Id`),
  ADD CONSTRAINT `FK_ContactPerLeverancier_LeverancierId` FOREIGN KEY (`LeverancierId`) REFERENCES `leverancier` (`Id`);

--
-- Beperkingen voor tabel `eetwenspergezin`
--
ALTER TABLE `eetwenspergezin`
  ADD CONSTRAINT `FK_EetwensPerGezin_EetwensId` FOREIGN KEY (`EetwensId`) REFERENCES `eetwens` (`Id`),
  ADD CONSTRAINT `FK_EetwensPerGezin_GezinId` FOREIGN KEY (`GezinId`) REFERENCES `gezin` (`Id`);

--
-- Beperkingen voor tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD CONSTRAINT `FK_Gebruiker_PersoonId` FOREIGN KEY (`PersoonId`) REFERENCES `persoon` (`Id`);

--
-- Beperkingen voor tabel `persoon`
--
ALTER TABLE `persoon`
  ADD CONSTRAINT `FK_Persoon_GezinId` FOREIGN KEY (`GezinId`) REFERENCES `gezin` (`Id`);

--
-- Beperkingen voor tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_Product_CategorieId` FOREIGN KEY (`CategorieId`) REFERENCES `categorie` (`Id`);

--
-- Beperkingen voor tabel `productperleverancier`
--
ALTER TABLE `productperleverancier`
  ADD CONSTRAINT `FK_ProductPerLeverancier_LeverancierId` FOREIGN KEY (`LeverancierId`) REFERENCES `leverancier` (`Id`),
  ADD CONSTRAINT `FK_ProductPerLeverancier_ProductId` FOREIGN KEY (`ProductId`) REFERENCES `product` (`Id`);

--
-- Beperkingen voor tabel `productpermagazijn`
--
ALTER TABLE `productpermagazijn`
  ADD CONSTRAINT `FK_ProductPerMagazijn_MagazijnId` FOREIGN KEY (`MagazijnId`) REFERENCES `magazijn` (`Id`),
  ADD CONSTRAINT `FK_ProductPerMagazijn_ProductId` FOREIGN KEY (`ProductId`) REFERENCES `product` (`Id`);

--
-- Beperkingen voor tabel `productpervoedselpakket`
--
ALTER TABLE `productpervoedselpakket`
  ADD CONSTRAINT `FK_ProductPerVoedselpakket_ProductId` FOREIGN KEY (`ProductId`) REFERENCES `product` (`Id`),
  ADD CONSTRAINT `FK_ProductPerVoedselpakket_VoedselpakketId` FOREIGN KEY (`VoedselpakketId`) REFERENCES `voedselpakket` (`Id`);

--
-- Beperkingen voor tabel `rolpergebruiker`
--
ALTER TABLE `rolpergebruiker`
  ADD CONSTRAINT `FK_RolPerGebruiker_GebruikerId` FOREIGN KEY (`GebruikerId`) REFERENCES `gebruiker` (`Id`),
  ADD CONSTRAINT `FK_RolPerGebruiker_RolId` FOREIGN KEY (`RolId`) REFERENCES `rol` (`Id`);

--
-- Beperkingen voor tabel `voedselpakket`
--
ALTER TABLE `voedselpakket`
  ADD CONSTRAINT `FK_Voedselpakket_GezinId` FOREIGN KEY (`GezinId`) REFERENCES `gezin` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
