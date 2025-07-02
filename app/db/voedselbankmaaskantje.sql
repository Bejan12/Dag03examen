-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 01 jul 2025 om 11:40
-- Serverversie: 8.2.0
-- PHP-versie: 8.2.13

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
(1, 'Gluten', 'Allergisch voor gluten', 'zeerlaag', b'1', NULL, '2025-07-01 10:25:15.587718', '2025-07-01 10:25:15.587722'),
(2, 'Pindas', 'Allergisch voor pindas', 'Hoog', b'1', NULL, '2025-07-01 10:25:15.587763', '2025-07-01 10:25:15.587763'),
(3, 'Schaaldieren', 'Allergisch voor schaaldieren', 'RedelijkHoog', b'1', NULL, '2025-07-01 10:25:15.587781', '2025-07-01 10:25:15.587781'),
(4, 'Hazelnoten', 'Allergisch voor hazelnoten', 'laag', b'1', NULL, '2025-07-01 10:25:15.587789', '2025-07-01 10:25:15.587790'),
(5, 'Lactose', 'Allergisch voor lactose', 'Zeerlaag', b'1', NULL, '2025-07-01 10:25:15.587796', '2025-07-01 10:25:15.587797'),
(6, 'Soja', 'Allergisch voor soja', 'Zeerlaag', b'1', NULL, '2025-07-01 10:25:15.587803', '2025-07-01 10:25:15.587804');

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
(1, 4, 1, b'1', NULL, '2025-07-01 10:25:15.634822', '2025-07-01 10:25:15.634825'),
(2, 5, 2, b'1', NULL, '2025-07-01 10:25:15.634913', '2025-07-01 10:25:15.634915'),
(3, 6, 3, b'1', NULL, '2025-07-01 10:25:15.634941', '2025-07-01 10:25:15.634942'),
(4, 7, 4, b'1', NULL, '2025-07-01 10:25:15.634957', '2025-07-01 10:25:15.634958'),
(5, 8, 3, b'1', NULL, '2025-07-01 10:25:15.634973', '2025-07-01 10:25:15.634973'),
(6, 9, 2, b'1', NULL, '2025-07-01 10:25:15.635002', '2025-07-01 10:25:15.635003'),
(7, 10, 5, b'1', NULL, '2025-07-01 10:25:15.635019', '2025-07-01 10:25:15.635020'),
(8, 12, 2, b'1', NULL, '2025-07-01 10:25:15.635039', '2025-07-01 10:25:15.635040'),
(9, 13, 4, b'1', NULL, '2025-07-01 10:25:15.635054', '2025-07-01 10:25:15.635055'),
(10, 14, 1, b'1', NULL, '2025-07-01 10:25:15.635069', '2025-07-01 10:25:15.635069'),
(11, 15, 3, b'1', NULL, '2025-07-01 10:25:15.635083', '2025-07-01 10:25:15.635083'),
(12, 16, 5, b'1', NULL, '2025-07-01 10:25:15.635098', '2025-07-01 10:25:15.635099'),
(13, 17, 1, b'1', NULL, '2025-07-01 10:25:15.635114', '2025-07-01 10:25:15.635115'),
(14, 17, 2, b'1', NULL, '2025-07-01 10:25:15.635128', '2025-07-01 10:25:15.635129'),
(15, 18, 4, b'1', NULL, '2025-07-01 10:25:15.635143', '2025-07-01 10:25:15.635144'),
(16, 19, 4, b'1', NULL, '2025-07-01 10:25:15.635159', '2025-07-01 10:25:15.635159');

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
(1, 'AGF', 'Aardappelen groente en fruit', b'1', NULL, '2025-07-01 10:25:15.571436', '2025-07-01 10:25:15.571440'),
(2, 'KV', 'Kaas en vleeswaren', b'1', NULL, '2025-07-01 10:25:15.571489', '2025-07-01 10:25:15.571490'),
(3, 'ZPE', 'Zuivel plantaardig en eieren', b'1', NULL, '2025-07-01 10:25:15.571507', '2025-07-01 10:25:15.571508'),
(4, 'BB', 'Bakkerij en Banket', b'1', NULL, '2025-07-01 10:25:15.571515', '2025-07-01 10:25:15.571516'),
(5, 'FSKT', 'Frisdranken, sappen, koffie en thee', b'1', NULL, '2025-07-01 10:25:15.571522', '2025-07-01 10:25:15.571523'),
(6, 'PRW', 'Pasta, rijst en wereldkeuken', b'1', NULL, '2025-07-01 10:25:15.571529', '2025-07-01 10:25:15.571529'),
(7, 'SSKO', 'Soepen, sauzen, kruiden en olie', b'1', NULL, '2025-07-01 10:25:15.571537', '2025-07-01 10:25:15.571537'),
(8, 'SKCC', 'Snoep, koek, chips en chocolade', b'1', NULL, '2025-07-01 10:25:15.571543', '2025-07-01 10:25:15.571544'),
(9, 'BVH', 'Baby, verzorging en hygiëne', b'1', NULL, '2025-07-01 10:25:15.571550', '2025-07-01 10:25:15.571551');

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
(1, 'Prinses Irenestraat', '12', 'A', '5271TH', 'Maaskantje', 'j.van.zevenhuizen@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577752', '2025-07-01 10:25:15.577755'),
(2, 'Gibraltarstraat', '233', '', '5271TJ', 'Maaskantje', 'a.bergkamp@hotmail.com', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577804', '2025-07-01 13:36:54.986679'),
(3, 'Der Kinderenstraat', '456', 'Bis', '5271TH', 'Maaskantje', 's.van.de.heuvel@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577823', '2025-07-01 10:25:15.577824'),
(4, 'Nachtegaalstraat', '233', 'A', '5271TJ', 'Maaskantje', 'e.scherder@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577832', '2025-07-01 10:25:15.577833'),
(5, 'Bertram Russellstraat', '45', NULL, '5271TH', 'Maaskantje', 'f.de.jong@hotmail.com', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577841', '2025-07-01 10:25:15.577841'),
(6, 'Leonardo Da VinciHof', '34', NULL, '5271ZE', 'Maaskantje', 'h.van.der.berg@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577848', '2025-07-01 10:25:15.577849'),
(7, 'Siegfried Knutsenlaan', '234', NULL, '5271ZE', 'Maaskantje', 'r.ter.weijden@ah.nl', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577856', '2025-07-01 10:25:15.577857'),
(8, 'Theo de Bokstraat', '256', NULL, '5271ZH', 'Maaskantje', 'l.pastoor@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577864', '2025-07-01 10:25:15.577865'),
(9, 'Meester van Leerhof', '2', 'A', '5271ZH', 'Maaskantje', 'm.yazidi@gemeenteutrecht.nl', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577873', '2025-07-01 10:25:15.577873'),
(10, 'Van Wemelenplantsoen', '300', NULL, '5271TH', 'Maaskantje', 'b.van.driel@gmail.com', '+31 623456123', b'1', NULL, '2025-07-01 10:25:15.577880', '2025-07-01 10:25:15.577880'),
(11, 'Terlingenhof', '20', NULL, '5271TH', 'Maaskantje', 'j.pastorius@gmail.com', '+31 623456356', b'1', NULL, '2025-07-01 10:25:15.577887', '2025-07-01 10:25:15.577888'),
(12, 'Veldhoen', '31', NULL, '5271ZE', 'Maaskantje', 's.dollaard@gmail.com', '+31 623452314', b'1', NULL, '2025-07-01 10:25:15.577894', '2025-07-01 10:25:15.577895'),
(13, 'ScheringaDreef', '37', NULL, '5271ZE', 'Vught', 'j.blokker@gemeentevught.nl', '+31 623452314', b'1', NULL, '2025-07-01 10:25:15.577901', '2025-07-01 10:25:15.577902');

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
(1, 1, 1, b'1', NULL, '2025-07-01 10:25:15.656370', '2025-07-01 10:25:15.656373'),
(2, 2, 2, b'1', NULL, '2025-07-01 10:25:15.656458', '2025-07-01 10:25:15.656460'),
(3, 3, 3, b'1', NULL, '2025-07-01 10:25:15.656485', '2025-07-01 10:25:15.656486'),
(4, 4, 4, b'1', NULL, '2025-07-01 10:25:15.656501', '2025-07-01 10:25:15.656501'),
(5, 5, 5, b'1', NULL, '2025-07-01 10:25:15.656517', '2025-07-01 10:25:15.656517'),
(6, 6, 6, b'1', NULL, '2025-07-01 10:25:15.656532', '2025-07-01 10:25:15.656533');

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
(1, 1, 7, b'1', NULL, '2025-07-01 10:25:15.650961', '2025-07-01 10:25:15.650965'),
(2, 2, 8, b'1', NULL, '2025-07-01 10:25:15.651044', '2025-07-01 10:25:15.651045'),
(3, 3, 9, b'1', NULL, '2025-07-01 10:25:15.651072', '2025-07-01 10:25:15.651072'),
(4, 4, 10, b'1', NULL, '2025-07-01 10:25:15.651092', '2025-07-01 10:25:15.651093'),
(5, 6, 11, b'1', NULL, '2025-07-01 10:25:15.651112', '2025-07-01 10:25:15.651113'),
(6, 7, 12, b'1', NULL, '2025-07-01 10:25:15.651127', '2025-07-01 10:25:15.651128'),
(7, 8, 13, b'1', NULL, '2025-07-01 10:25:15.651147', '2025-07-01 10:25:15.651147');

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
(1, 'GeenVarken', 'Geen Varkensvlees', b'1', NULL, '2025-07-01 10:25:15.582705', '2025-07-01 10:25:15.582708'),
(2, 'Veganistisch', 'Geen zuivelproducten en vlees', b'1', NULL, '2025-07-01 10:25:15.582752', '2025-07-01 10:25:15.582752'),
(3, 'Vegetarisch', 'Geen vlees', b'1', NULL, '2025-07-01 10:25:15.582783', '2025-07-01 10:25:15.582784'),
(4, 'Omnivoor', 'Geen beperkingen', b'1', NULL, '2025-07-01 10:25:15.582792', '2025-07-01 10:25:15.582792');

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
(1, 1, 2, b'1', NULL, '2025-07-01 10:25:15.643804', '2025-07-01 10:25:15.643807'),
(2, 2, 4, b'1', NULL, '2025-07-01 10:25:15.643938', '2025-07-01 10:25:15.643940'),
(3, 3, 4, b'1', NULL, '2025-07-01 10:25:15.643970', '2025-07-01 10:25:15.643971'),
(4, 4, 3, b'1', NULL, '2025-07-01 10:25:15.643990', '2025-07-01 10:25:15.643991'),
(5, 5, 2, b'1', NULL, '2025-07-01 10:25:15.644010', '2025-07-01 10:25:15.644011');

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
(1, 1, 'Hans', 'hans@maaskantje.nl', '$2y$10$8Jri/Rnx/MZodZJYfnXBLuGXG3THbeU3dNRdhCDUWq8NBq/QmFVF.', b'1', '2024-03-13 17:03:06.000000', NULL, b'1', NULL, '2025-07-01 10:25:15.612015', '2025-07-01 10:25:15.612016'),
(2, 2, 'Jan', 'jan@maaskantje.nl', '$2y$10$8Jri/Rnx/MZodZJYfnXBLuGXG3THbeU3dNRdhCDUWq8NBq/QmFVF.', b'0', '2024-03-13 15:13:23.000000', '2024-03-13 15:23:46.000000', b'1', NULL, '2025-07-01 10:25:15.612115', '2025-07-01 10:25:15.612126'),
(3, 3, 'Herman', 'herman@maaskantje.nl', '$2y$10$8Jri/Rnx/MZodZJYfnXBLuGXG3THbeU3dNRdhCDUWq8NBq/QmFVF.', b'1', '2024-06-20 12:05:20.000000', NULL, b'1', NULL, '2025-07-01 10:25:15.612167', '2025-07-01 10:25:15.612167');

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
(1, 'ZevenhuizenGezin', 'G0001', 'Bijstandsgezin', 2, 2, 0, 4, b'1', NULL, '2025-07-01 10:25:15.592495', '2025-07-01 10:25:15.592498'),
(2, 'BergkampGezin', 'G0002', 'Bijstandsgezin', 2, 1, 1, 4, b'1', NULL, '2025-07-01 10:25:15.592556', '2025-07-01 10:25:15.592557'),
(3, 'HeuvelGezin', 'G0003', 'Bijstandsgezin', 2, 0, 0, 2, b'1', NULL, '2025-07-01 10:25:15.592585', '2025-07-01 10:25:15.592586'),
(4, 'ScherderGezin', 'G0004', 'Bijstandsgezin', 1, 0, 2, 3, b'1', NULL, '2025-07-01 10:25:15.592598', '2025-07-01 10:25:15.592598'),
(5, 'DeJongGezin', 'G0005', 'Bijstandsgezin', 1, 1, 0, 2, b'1', NULL, '2025-07-01 10:25:15.592609', '2025-07-01 10:25:15.592609'),
(6, 'VanderBergGezin', 'G0006', 'AlleenGaande', 1, 0, 0, 1, b'1', NULL, '2025-07-01 10:25:15.592620', '2025-07-01 10:25:15.592620');

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
(1, 'Albert Heijn', 'Ruud ter Weijden', 'L0001', 'Bedrijf', b'1', NULL, '2025-07-01 10:25:15.597195', '2025-07-01 10:25:15.597198'),
(2, 'Albertus Kerk', 'Leo Pastoor', 'L0002', 'Instelling', b'1', NULL, '2025-07-01 10:25:15.597242', '2025-07-01 10:25:15.597243'),
(3, 'Gemeente Utrecht', 'Mohammed Yazidi', 'L0003', 'Overheid', b'1', NULL, '2025-07-01 10:25:15.597265', '2025-07-01 10:25:15.597265'),
(4, 'Boerderij Meerhoven', 'Bertus van Driel', 'L0004', 'Particulier', b'1', NULL, '2025-07-01 10:25:15.597276', '2025-07-01 10:25:15.597277'),
(5, 'Jan van der Heijden', 'Jan van der Heijden', 'L0005', 'Donor', b'1', NULL, '2025-07-01 10:25:15.597287', '2025-07-01 10:25:15.597288'),
(6, 'Vomar', 'Jaco Pastorius', 'L0006', 'Bedrijf', b'1', NULL, '2025-07-01 10:25:15.597297', '2025-07-01 10:25:15.597298'),
(7, 'DekaMarkt', 'Sil den Dollaard', 'L0007', 'Bedrijf', b'1', NULL, '2025-07-01 10:25:15.597308', '2025-07-01 10:25:15.597309'),
(8, 'Gemeente Vught', 'Jan Blokker', 'L0008', 'Overheid', b'1', NULL, '2025-07-01 10:25:15.597319', '2025-07-01 10:25:15.597319');

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
(1, '2024-05-12', NULL, '5 kg', 20, b'1', NULL, '2025-07-01 10:25:15.602329', '2025-07-01 10:25:15.602331'),
(2, '2024-05-26', NULL, '2.5 kg', 40, b'1', NULL, '2025-07-01 10:25:15.602434', '2025-07-01 10:25:15.602437'),
(3, '2024-04-02', NULL, '1 kg', 30, b'1', NULL, '2025-07-01 10:25:15.602457', '2025-07-01 10:25:15.602457'),
(4, '2024-05-16', NULL, '1.5 kg', 25, b'1', NULL, '2025-07-01 10:25:15.602465', '2025-07-01 10:25:15.602466'),
(5, '2024-05-23', NULL, '4 stuks', 75, b'1', NULL, '2025-07-01 10:25:15.602473', '2025-07-01 10:25:15.602473'),
(6, '2024-03-12', NULL, '1 kg/tros', 60, b'1', NULL, '2025-07-01 10:25:15.602481', '2025-07-01 10:25:15.602481'),
(7, '2024-03-19', NULL, '2 kg/tros', 200, b'1', NULL, '2025-07-01 10:25:15.602489', '2025-07-01 10:25:15.602489'),
(8, '2024-06-19', NULL, '200 g', 45, b'1', NULL, '2025-07-01 10:25:15.602496', '2025-07-01 10:25:15.602497'),
(9, '2024-07-23', NULL, '100 g', 60, b'1', NULL, '2025-07-01 10:25:15.602504', '2025-07-01 10:25:15.602504'),
(10, '2024-07-23', NULL, '1 liter', 120, b'1', NULL, '2025-07-01 10:25:15.602511', '2025-07-01 10:25:15.602512'),
(11, '2024-06-02', NULL, '250 g', 80, b'1', NULL, '2025-07-01 10:25:15.602518', '2025-07-01 10:25:15.602518'),
(12, '2024-01-04', NULL, '6 stuks', 120, b'1', NULL, '2025-07-01 10:25:15.602525', '2025-07-01 10:25:15.602525'),
(13, '2024-04-07', NULL, '800 g', 220, b'1', NULL, '2025-07-01 10:25:15.602532', '2025-07-01 10:25:15.602532'),
(14, '2024-04-04', NULL, '1 stuk', 130, b'1', NULL, '2025-07-01 10:25:15.602539', '2025-07-01 10:25:15.602539'),
(15, '2024-04-28', NULL, '150 ml', 72, b'1', NULL, '2025-07-01 10:25:15.602546', '2025-07-01 10:25:15.602546'),
(16, '2024-04-19', NULL, '1 l', 12, b'1', NULL, '2025-07-01 10:25:15.602553', '2025-07-01 10:25:15.602553'),
(17, '2024-04-23', NULL, '250 g', 300, b'1', NULL, '2025-07-01 10:25:15.602560', '2025-07-01 10:25:15.602560'),
(18, '2024-03-02', NULL, '25 zakjes', 280, b'1', NULL, '2025-07-01 10:25:15.602568', '2025-07-01 10:25:15.602568'),
(19, '2024-04-16', NULL, '500 g', 330, b'1', NULL, '2025-07-01 10:25:15.602574', '2025-07-01 10:25:15.602575'),
(20, '2024-04-25', NULL, '1 kg', 34, b'1', NULL, '2025-07-01 10:25:15.602581', '2025-07-01 10:25:15.602582'),
(21, '2024-04-13', NULL, '50 g', 23, b'1', NULL, '2025-07-01 10:25:15.602588', '2025-07-01 10:25:15.602589'),
(22, '2024-04-23', NULL, '1 l', 46, b'1', NULL, '2025-07-01 10:25:15.602595', '2025-07-01 10:25:15.602596'),
(23, '2024-04-21', NULL, '250 ml', 98, b'1', NULL, '2025-07-01 10:25:15.602602', '2025-07-01 10:25:15.602603'),
(24, '2024-04-30', NULL, '1 potje', 56, b'1', NULL, '2025-07-01 10:25:15.602609', '2025-07-01 10:25:15.602609'),
(25, '2024-04-27', NULL, '1 l', 210, b'1', NULL, '2025-07-01 10:25:15.602616', '2025-07-01 10:25:15.602617'),
(26, '2024-04-01', NULL, '4 stuks', 24, b'1', NULL, '2025-07-01 10:25:15.602623', '2025-07-01 10:25:15.602623'),
(27, '2024-04-07', NULL, '300 g', 87, b'1', NULL, '2025-07-01 10:25:15.602630', '2025-07-01 10:25:15.602631'),
(28, '2024-04-22', NULL, '200 g', 230, b'1', NULL, '2025-07-01 10:25:15.602637', '2025-07-01 10:25:15.602638'),
(29, '2024-04-21', NULL, '80 g', 30, b'1', NULL, '2025-07-01 10:25:15.602644', '2025-07-01 10:25:15.602645');

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
(1, NULL, 'Hans', 'van', 'Leeuwen', '1958-02-12', 'Manager', b'0', b'1', NULL, '2025-07-01 10:25:15.607076', '2025-07-01 10:25:15.607078'),
(2, NULL, 'Jan', 'van der', 'Sluijs', '1993-04-30', 'Medewerker', b'0', b'1', NULL, '2025-07-01 10:25:15.607133', '2025-07-01 10:25:15.607134'),
(3, NULL, 'Herman', 'den', 'Duiker', '1989-08-30', 'Vrijwilliger', b'0', b'1', NULL, '2025-07-01 10:25:15.607163', '2025-07-01 10:25:15.607164'),
(4, 1, 'Johan', 'van', 'Zevenhuizen', '1990-05-20', 'Klant', b'1', b'1', NULL, '2025-07-01 10:25:15.607178', '2025-07-01 10:25:15.607179'),
(5, 1, 'Sarah', 'den', 'Dolder', '1985-03-23', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607214', '2025-07-01 10:25:15.607215'),
(6, 1, 'Theo', 'van', 'Zevenhuizen', '2015-03-08', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607231', '2025-07-01 10:25:15.607231'),
(7, 1, 'Jantien', 'van', 'Zevenhuizen', '2016-09-20', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607245', '2025-07-01 10:25:15.607246'),
(8, 2, 'dennis', '', 'Bergkamp', '1968-07-12', 'Klant', b'1', b'1', NULL, '2025-07-01 10:25:15.607259', '2025-07-01 13:36:54.930718'),
(9, 2, 'Janneke', NULL, 'Sanders', '1969-05-11', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607273', '2025-07-01 10:25:15.607274'),
(10, 2, 'Stein', NULL, 'Bergkamp', '2009-02-02', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607287', '2025-07-01 10:25:15.607287'),
(11, 2, 'Judith', NULL, 'Bergkamp', '2022-02-05', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607314', '2025-07-01 10:25:15.607314'),
(12, 3, 'Mazin', 'van', 'Vliet', '1968-08-18', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607330', '2025-07-01 10:25:15.607331'),
(13, 3, 'Selma', 'van de', 'Heuvel', '1965-09-04', 'Klant', b'1', b'1', NULL, '2025-07-01 10:25:15.607344', '2025-07-01 10:25:15.607344'),
(14, 4, 'Eva', NULL, 'Scherder', '2000-04-07', 'Klant', b'1', b'1', NULL, '2025-07-01 10:25:15.607358', '2025-07-01 10:25:15.607359'),
(15, 4, 'Felicia', NULL, 'Scherder', '2021-11-29', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607375', '2025-07-01 10:25:15.607376'),
(16, 4, 'Devin', NULL, 'Scherder', '2024-03-01', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607400', '2025-07-01 10:25:15.607400'),
(17, 5, 'Frieda', 'de', 'Jong', '1980-09-04', 'Klant', b'1', b'1', NULL, '2025-07-01 10:25:15.607415', '2025-07-01 10:25:15.607415'),
(18, 5, 'Simeon', 'de', 'Jong', '2018-05-23', 'Klant', b'0', b'1', NULL, '2025-07-01 10:25:15.607429', '2025-07-01 10:25:15.607429'),
(19, 6, 'Hanna', 'van der', 'Berg', '1999-09-09', 'Klant', b'1', b'1', NULL, '2025-07-01 10:25:15.607443', '2025-07-01 10:25:15.607444');

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
(1, 1, 'Aardappel', NULL, '8719587321239', '2024-07-12', 'Kruimige aardappel', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618573', '2025-07-01 10:25:15.618576'),
(2, 1, 'Aardappel', NULL, '8719587321239', '2024-07-26', 'Kruimige aardappel', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618705', '2025-07-01 10:25:15.618707'),
(3, 1, 'Ui', NULL, '8719437321335', '2024-09-02', 'Gele ui', 'NietOpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618742', '2025-07-01 10:25:15.618743'),
(4, 1, 'Appel', NULL, '8719486321332', '2024-08-16', 'Granny Smith', 'NietLeverbaar', b'1', NULL, '2025-07-01 10:25:15.618764', '2025-07-01 10:25:15.618765'),
(5, 1, 'Appel', NULL, '8719486321332', '2024-09-23', 'Granny Smith', 'NietLeverbaar', b'1', NULL, '2025-07-01 10:25:15.618783', '2025-07-01 10:25:15.618783'),
(6, 1, 'Banaan', 'Banaan', '8719484321336', '2024-07-12', 'Biologische Banaan', 'OverHoudbaarheidsDatum', b'1', NULL, '2025-07-01 10:25:15.618803', '2025-07-01 10:25:15.618803'),
(7, 1, 'Banaan', 'Banaan', '8719484321336', '2024-07-19', 'Biologische Banaan', 'OverHoudbaarheidsDatum', b'1', NULL, '2025-07-01 10:25:15.618819', '2025-07-01 10:25:15.618819'),
(8, 2, 'Kaas', 'Lactose', '8719487421338', '2024-09-19', 'Jonge Kaas', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618835', '2025-07-01 10:25:15.618836'),
(9, 2, 'Rosbief', NULL, '8719487421331', '2024-07-23', 'Rundvlees', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618852', '2025-07-01 10:25:15.618853'),
(10, 3, 'Melk', 'Lactose', '8719447321332', '2024-07-23', 'Halfvolle melk', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618868', '2025-07-01 10:25:15.618869'),
(11, 3, 'Margarine', NULL, '8719486321336', '2024-08-02', 'Plantaardige boter', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618884', '2025-07-01 10:25:15.618884'),
(12, 3, 'Ei', 'Eier', '8719487421334', '2024-08-04', 'Scharrelei', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618900', '2025-07-01 10:25:15.618900'),
(13, 4, 'Brood', 'Gluten', '8719487721337', '2024-07-07', 'Volkoren brood', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618915', '2025-07-01 10:25:15.618916'),
(14, 4, 'Gevulde Koek', 'Amandel', '8719483321333', '2024-09-04', 'Banketbakkers kwaliteit', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618931', '2025-07-01 10:25:15.618931'),
(15, 5, 'Fristi', 'Lactose', '8719487121331', '2024-10-28', 'Frisdrank', 'NietOpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618946', '2025-07-01 10:25:15.618947'),
(16, 5, 'Appelsap', NULL, '8719487521335', '2024-10-19', '100% vruchtensap', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618962', '2025-07-01 10:25:15.618963'),
(17, 5, 'Koffie', 'Caffeïne', '8719487381338', '2024-10-23', 'Arabica koffie', 'OverHoudbaarheidsDatum', b'1', NULL, '2025-07-01 10:25:15.618980', '2025-07-01 10:25:15.618980'),
(18, 5, 'Thee', 'Theïne', '8719487329339', '2024-09-02', 'Ceylon thee', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.618995', '2025-07-01 10:25:15.618996'),
(19, 6, 'Pasta', 'Gluten', '8719487321334', '2024-12-16', 'Macaroni', 'NietLeverbaar', b'1', NULL, '2025-07-01 10:25:15.619011', '2025-07-01 10:25:15.619011'),
(20, 6, 'Rijst', NULL, '8719487331332', '2024-12-25', 'Basmati Rijst', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619026', '2025-07-01 10:25:15.619027'),
(21, 6, 'Knorr Nasi Mix', NULL, '871948735135', '2024-12-13', 'Nasi kruiden', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619043', '2025-07-01 10:25:15.619044'),
(22, 7, 'Tomatensoep', NULL, '8719487371337', '2024-12-23', 'Romige tomatensoep', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619059', '2025-07-01 10:25:15.619075'),
(23, 7, 'Tomatensaus', NULL, '8719487341334', '2024-12-21', 'Pizza saus', 'NietOpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619104', '2025-07-01 10:25:15.619104'),
(24, 7, 'Peterselie', NULL, '8719487321636', '2024-07-31', 'Verse kruidenpot', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619120', '2025-07-01 10:25:15.619121'),
(25, 8, 'Olie', NULL, '8719487327337', '2024-12-27', 'Olijfolie', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619141', '2025-07-01 10:25:15.619142'),
(26, 8, 'Mars', NULL, '8719487324334', '2024-12-11', 'Snoep', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619154', '2025-07-01 10:25:15.619155'),
(27, 8, 'Biscuit', NULL, '8719487311331', '2024-08-07', 'San Francisco biscuit', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619167', '2025-07-01 10:25:15.619167'),
(28, 8, 'Paprika Chips', NULL, '87194873218398', '2024-12-22', 'Ribbelchips paprika', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619180', '2025-07-01 10:25:15.619180'),
(29, 8, 'Chocolade reep', 'Cacoa', '8719487321533', '2024-11-21', 'Tony Chocolonely', 'OpVoorraad', b'1', NULL, '2025-07-01 10:25:15.619193', '2025-07-01 10:25:15.619193');

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
(1, 4, 1, '2024-04-12', '2024-05-12', b'1', NULL, '2025-07-01 10:25:15.666512', '2025-07-01 10:25:15.666515'),
(2, 4, 2, '2024-03-02', '2024-04-02', b'1', NULL, '2025-07-01 10:25:15.666657', '2025-07-01 10:25:15.666659'),
(3, 2, 3, '2024-07-16', '2024-08-16', b'1', NULL, '2025-07-01 10:25:15.666695', '2025-07-01 10:25:15.666696'),
(4, 1, 4, '2024-02-12', '2024-03-12', b'1', NULL, '2025-07-01 10:25:15.666715', '2025-07-01 10:25:15.666716'),
(5, 4, 5, '2024-05-19', '2024-06-19', b'1', NULL, '2025-07-01 10:25:15.666733', '2025-07-01 10:25:15.666733'),
(6, 1, 6, '2024-06-23', '2024-07-23', b'1', NULL, '2025-07-01 10:25:15.666750', '2025-07-01 10:25:15.666750'),
(7, 4, 7, '2024-06-20', '2024-07-20', b'1', NULL, '2025-07-01 10:25:15.666767', '2025-07-01 10:25:15.666767'),
(8, 4, 8, '2024-05-02', '2024-06-02', b'1', NULL, '2025-07-01 10:25:15.666784', '2025-07-01 10:25:15.666785'),
(9, 4, 9, '2022-12-04', '2024-01-04', b'1', NULL, '2025-07-01 10:25:15.666804', '2025-07-01 10:25:15.666804'),
(10, 3, 10, '2024-03-07', '2024-04-07', b'1', NULL, '2025-07-01 10:25:15.666821', '2025-07-01 10:25:15.666821'),
(11, 3, 11, '2024-02-04', '2024-03-04', b'1', NULL, '2025-07-01 10:25:15.666860', '2025-07-01 10:25:15.666862'),
(12, 3, 12, '2024-02-28', '2024-03-28', b'1', NULL, '2025-07-01 10:25:15.666885', '2025-07-01 10:25:15.666885'),
(13, 3, 13, '2024-03-19', '2024-04-19', b'1', NULL, '2025-07-01 10:25:15.666903', '2025-07-01 10:25:15.666903'),
(14, 2, 14, '2024-03-23', '2024-04-23', b'1', NULL, '2025-07-01 10:25:15.666928', '2025-07-01 10:25:15.666929'),
(15, 2, 15, '2024-02-02', '2024-03-02', b'1', NULL, '2025-07-01 10:25:15.666945', '2025-07-01 10:25:15.666946'),
(16, 1, 16, '2024-02-16', '2024-03-16', b'1', NULL, '2025-07-01 10:25:15.666962', '2025-07-01 10:25:15.666963'),
(17, 1, 17, '2024-03-25', '2024-04-25', b'1', NULL, '2025-07-01 10:25:15.666980', '2025-07-01 10:25:15.666981'),
(18, 1, 18, '2024-03-13', '2024-04-13', b'1', NULL, '2025-07-01 10:25:15.666998', '2025-07-01 10:25:15.666998'),
(19, 1, 19, '2024-03-23', '2024-04-23', b'1', NULL, '2025-07-01 10:25:15.667023', '2025-07-01 10:25:15.667024'),
(20, 4, 20, '2024-02-21', '2024-03-21', b'1', NULL, '2025-07-01 10:25:15.667041', '2025-07-01 10:25:15.667042'),
(21, 2, 21, '2024-03-31', '2024-04-30', b'1', NULL, '2025-07-01 10:25:15.667059', '2025-07-01 10:25:15.667060'),
(22, 1, 22, '2024-03-27', '2024-04-27', b'1', NULL, '2025-07-01 10:25:15.667230', '2025-07-01 10:25:15.667233'),
(23, 3, 23, '2024-04-11', '2024-04-18', b'1', NULL, '2025-07-01 10:25:15.667273', '2025-07-01 10:25:15.667274'),
(24, 3, 24, '2024-04-07', '2024-04-14', b'1', NULL, '2025-07-01 10:25:15.667303', '2025-07-01 10:25:15.667304'),
(25, 1, 25, '2024-05-07', '2024-05-14', b'1', NULL, '2025-07-01 10:25:15.667329', '2025-07-01 10:25:15.667330'),
(26, 2, 26, '2024-05-05', '2024-05-12', b'1', NULL, '2025-07-01 10:25:15.667353', '2025-07-01 10:25:15.667353');

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
(1, 1, 1, 'Berlicum', b'1', NULL, '2025-07-01 10:25:15.673477', '2025-07-01 10:25:15.673479'),
(2, 2, 2, 'Rosmalen', b'1', NULL, '2025-07-01 10:25:15.673581', '2025-07-01 10:25:15.673583'),
(3, 3, 3, 'Berlicum', b'1', NULL, '2025-07-01 10:25:15.673649', '2025-07-01 10:25:15.673651'),
(4, 4, 4, 'Berlicum', b'1', NULL, '2025-07-01 10:25:15.673673', '2025-07-01 10:25:15.673674'),
(5, 5, 5, 'Rosmalen', b'1', NULL, '2025-07-01 10:25:15.673693', '2025-07-01 10:25:15.673693'),
(6, 6, 6, 'Berlicum', b'1', NULL, '2025-07-01 10:25:15.673711', '2025-07-01 10:25:15.673712'),
(7, 7, 7, 'Rosmalen', b'1', NULL, '2025-07-01 10:25:15.673757', '2025-07-01 10:25:15.673757'),
(8, 8, 8, 'Sint-MichelsGestel', b'1', NULL, '2025-07-01 10:25:15.673776', '2025-07-01 10:25:15.673777'),
(9, 9, 9, 'Sint-MichelsGestel', b'1', NULL, '2025-07-01 10:25:15.673795', '2025-07-01 10:25:15.673796'),
(10, 10, 10, 'Middelrode', b'1', NULL, '2025-07-01 10:25:15.673814', '2025-07-01 10:25:15.673815'),
(11, 11, 11, 'Middelrode', b'1', NULL, '2025-07-01 10:25:15.673829', '2025-07-01 10:25:15.673829'),
(12, 12, 12, 'Middelrode', b'1', NULL, '2025-07-01 10:25:15.673844', '2025-07-01 10:25:15.673844'),
(13, 13, 13, 'Schijndel', b'1', NULL, '2025-07-01 10:25:15.673860', '2025-07-01 10:25:15.673860'),
(14, 14, 14, 'Schijndel', b'1', NULL, '2025-07-01 10:25:15.673879', '2025-07-01 10:25:15.673880'),
(15, 15, 15, 'Gemonde', b'1', NULL, '2025-07-01 10:25:15.673895', '2025-07-01 10:25:15.673895'),
(16, 16, 16, 'Gemonde', b'1', NULL, '2025-07-01 10:25:15.673909', '2025-07-01 10:25:15.673910'),
(17, 17, 17, 'Gemonde', b'1', NULL, '2025-07-01 10:25:15.673924', '2025-07-01 10:25:15.673925'),
(18, 18, 18, 'Gemonde', b'1', NULL, '2025-07-01 10:25:15.673939', '2025-07-01 10:25:15.673940'),
(19, 19, 19, 'Den Bosch', b'1', NULL, '2025-07-01 10:25:15.673954', '2025-07-01 10:25:15.673955'),
(20, 20, 20, 'Den Bosch', b'1', NULL, '2025-07-01 10:25:15.673968', '2025-07-01 10:25:15.673969'),
(21, 21, 21, 'Den Bosch', b'1', NULL, '2025-07-01 10:25:15.673985', '2025-07-01 10:25:15.673986'),
(22, 22, 22, 'Heeswijk Dinther', b'1', NULL, '2025-07-01 10:25:15.674001', '2025-07-01 10:25:15.674001'),
(23, 23, 23, 'Heeswijk Dinther', b'1', NULL, '2025-07-01 10:25:15.674050', '2025-07-01 10:25:15.674051'),
(24, 24, 24, 'Heeswijk Dinther', b'1', NULL, '2025-07-01 10:25:15.674070', '2025-07-01 10:25:15.674070'),
(25, 25, 25, 'Vught', b'1', NULL, '2025-07-01 10:25:15.674085', '2025-07-01 10:25:15.674085'),
(26, 26, 26, 'Vught', b'1', NULL, '2025-07-01 10:25:15.674099', '2025-07-01 10:25:15.674100'),
(27, 27, 27, 'Vught', b'1', NULL, '2025-07-01 10:25:15.674114', '2025-07-01 10:25:15.674115'),
(28, 28, 28, 'Vught', b'1', NULL, '2025-07-01 10:25:15.674129', '2025-07-01 10:25:15.674130'),
(29, 29, 29, 'Vught', b'1', NULL, '2025-07-01 10:25:15.674144', '2025-07-01 10:25:15.674145');

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
(1, 1, 7, 1, b'1', NULL, '2025-07-01 10:25:15.660317', '2025-07-01 10:25:15.660320'),
(2, 1, 8, 2, b'1', NULL, '2025-07-01 10:25:15.660488', '2025-07-01 10:25:15.660490'),
(3, 1, 9, 1, b'1', NULL, '2025-07-01 10:25:15.660517', '2025-07-01 10:25:15.660517'),
(4, 2, 12, 1, b'1', NULL, '2025-07-01 10:25:15.660534', '2025-07-01 10:25:15.660534'),
(5, 2, 13, 2, b'1', NULL, '2025-07-01 10:25:15.660549', '2025-07-01 10:25:15.660549'),
(6, 2, 14, 1, b'1', NULL, '2025-07-01 10:25:15.660564', '2025-07-01 10:25:15.660565'),
(7, 3, 3, 1, b'1', NULL, '2025-07-01 10:25:15.660579', '2025-07-01 10:25:15.660580'),
(8, 3, 4, 1, b'1', NULL, '2025-07-01 10:25:15.660594', '2025-07-01 10:25:15.660594'),
(9, 4, 20, 1, b'1', NULL, '2025-07-01 10:25:15.660609', '2025-07-01 10:25:15.660610'),
(10, 4, 19, 1, b'1', NULL, '2025-07-01 10:25:15.660642', '2025-07-01 10:25:15.660642'),
(11, 4, 21, 1, b'1', NULL, '2025-07-01 10:25:15.660657', '2025-07-01 10:25:15.660658'),
(12, 5, 24, 1, b'1', NULL, '2025-07-01 10:25:15.660672', '2025-07-01 10:25:15.660673'),
(13, 5, 25, 1, b'1', NULL, '2025-07-01 10:25:15.660688', '2025-07-01 10:25:15.660688'),
(14, 5, 26, 1, b'1', NULL, '2025-07-01 10:25:15.660703', '2025-07-01 10:25:15.660703'),
(15, 6, 26, 1, b'1', NULL, '2025-07-01 10:25:15.660718', '2025-07-01 10:25:15.660719');

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
(1, 'Manager', b'1', NULL, '2025-07-01 10:25:15.564171', '2025-07-01 10:25:15.564174'),
(2, 'Medewerker', b'1', NULL, '2025-07-01 10:25:15.564271', '2025-07-01 10:25:15.564273'),
(3, 'Vrijwilliger', b'1', NULL, '2025-07-01 10:25:15.564299', '2025-07-01 10:25:15.564300');

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
(1, 1, 1, b'1', NULL, '2025-07-01 10:25:15.640017', '2025-07-01 10:25:15.640020'),
(2, 2, 2, b'1', NULL, '2025-07-01 10:25:15.640094', '2025-07-01 10:25:15.640095'),
(3, 3, 3, b'1', NULL, '2025-07-01 10:25:15.640125', '2025-07-01 10:25:15.640126');

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
(1, 1, 1, '2024-04-06', '2024-04-07', 'Uitgereikt', b'1', NULL, '2025-07-01 10:25:15.624686', '2025-07-01 10:25:15.624689'),
(2, 1, 2, '2024-04-13', NULL, 'NietUitgereikt', b'1', NULL, '2025-07-01 10:25:15.624816', '2025-07-01 10:25:15.624818'),
(3, 1, 3, '2024-04-20', NULL, 'NietMeerIngeschreven', b'1', NULL, '2025-07-01 10:25:15.624846', '2025-07-01 10:25:15.624846'),
(4, 2, 4, '2024-04-06', '2024-04-07', 'Uitgereikt', b'1', NULL, '2025-07-01 10:25:15.624863', '2025-07-01 10:25:15.624863'),
(5, 2, 5, '2024-04-13', '2024-04-14', 'Uitgereikt', b'1', NULL, '2025-07-01 10:25:15.624901', '2025-07-01 10:25:15.624902'),
(6, 2, 6, '2024-04-20', NULL, 'NietUitgereikt', b'1', NULL, '2025-07-01 10:25:15.624935', '2025-07-01 10:25:15.624936');

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
