-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 01 jul 2025 om 07:57
-- Serverversie: 8.2.0
-- PHP-versie: 8.3.11

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
CREATE DATABASE IF NOT EXISTS `voedselbankmaaskantje` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `voedselbankmaaskantje`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `allergie`
--

DROP TABLE IF EXISTS `allergie`;
CREATE TABLE IF NOT EXISTS `allergie` (
  `Id` int NOT NULL,
  `Naam` varchar(50) NOT NULL,
  `Omschrijving` varchar(255) DEFAULT NULL,
  `AnafylactischRisico` varchar(50) DEFAULT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `allergie`
--

INSERT INTO `allergie` (`Id`, `Naam`, `Omschrijving`, `AnafylactischRisico`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Gluten', 'Allergisch voor gluten', 'zeerlaag', b'1', NULL, '2025-07-01 09:56:41.718578', NULL),
(2, 'Pindas', 'Allergisch voor pindas', 'Hoog', b'1', NULL, '2025-07-01 09:56:41.718578', NULL),
(3, 'Schaaldieren', 'Allergisch voor schaaldieren', 'RedelijkHoog', b'1', NULL, '2025-07-01 09:56:41.718578', NULL),
(4, 'Hazelnoten', 'Allergisch voor hazelnoten', 'laag', b'1', NULL, '2025-07-01 09:56:41.718578', NULL),
(5, 'Lactose', 'Allergisch voor lactose', 'Zeerlaag', b'1', NULL, '2025-07-01 09:56:41.718578', NULL),
(6, 'Soja', 'Allergisch voor soja', 'Zeerlaag', b'1', NULL, '2025-07-01 09:56:41.718578', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `allergieperpersoon`
--

DROP TABLE IF EXISTS `allergieperpersoon`;
CREATE TABLE IF NOT EXISTS `allergieperpersoon` (
  `Id` int NOT NULL,
  `PersoonId` int NOT NULL,
  `AllergieId` int NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`),
  KEY `PersoonId` (`PersoonId`),
  KEY `AllergieId` (`AllergieId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `allergieperpersoon`
--

INSERT INTO `allergieperpersoon` (`Id`, `PersoonId`, `AllergieId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 4, 1, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(2, 5, 2, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(3, 6, 3, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(4, 7, 4, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(5, 8, 3, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(6, 9, 2, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(7, 10, 5, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(8, 12, 2, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(9, 13, 4, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(10, 14, 1, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(11, 15, 3, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(12, 16, 5, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(13, 17, 1, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(14, 17, 2, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(15, 18, 4, b'1', NULL, '2025-07-01 09:56:41.801810', NULL),
(16, 19, 4, b'1', NULL, '2025-07-01 09:56:41.801810', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `Id` int NOT NULL,
  `Naam` varchar(50) NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`Id`, `Naam`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Brood', b'1', NULL, '2025-07-01 09:56:41.879820', NULL),
(2, 'Groente', b'1', NULL, '2025-07-01 09:56:41.879820', NULL),
(3, 'Fruit', b'1', NULL, '2025-07-01 09:56:41.879820', NULL),
(4, 'Zuivel', b'1', NULL, '2025-07-01 09:56:41.879820', NULL),
(5, 'Vlees', b'1', NULL, '2025-07-01 09:56:41.879820', NULL),
(6, 'Overige', b'1', NULL, '2025-07-01 09:56:41.879820', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

DROP TABLE IF EXISTS `gebruiker`;
CREATE TABLE IF NOT EXISTS `gebruiker` (
  `Id` int NOT NULL,
  `PersoonId` int NOT NULL,
  `InlogNaam` varchar(100) DEFAULT NULL,
  `Gebruikersnaam` varchar(100) DEFAULT NULL,
  `Wachtwoord` varchar(255) DEFAULT NULL,
  `IsIngelogd` bit(1) DEFAULT b'0',
  `Ingelogd` datetime(6) DEFAULT NULL,
  `Uitgelogd` datetime(6) DEFAULT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`),
  KEY `PersoonId` (`PersoonId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`Id`, `PersoonId`, `InlogNaam`, `Gebruikersnaam`, `Wachtwoord`, `IsIngelogd`, `Ingelogd`, `Uitgelogd`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 'Hans', 'hans@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL6zKiF0i', b'1', '2024-03-13 17:03:06.000000', NULL, b'1', NULL, '2025-07-01 09:56:41.841625', NULL),
(2, 2, 'Jan', 'jan@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL3zKiF6i', b'0', '2024-03-13 15:13:23.000000', '2024-03-13 15:23:46.000000', b'1', NULL, '2025-07-01 09:56:41.841625', NULL),
(3, 3, 'Herman', 'herman@maaskantje.nl', '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVuwCp/DL9zKiF2i', b'1', '2024-06-20 12:05:20.000000', NULL, b'1', NULL, '2025-07-01 09:56:41.841625', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gezin`
--

DROP TABLE IF EXISTS `gezin`;
CREATE TABLE IF NOT EXISTS `gezin` (
  `Id` int NOT NULL,
  `Naam` varchar(100) NOT NULL,
  `Adres` varchar(255) DEFAULT NULL,
  `Postcode` varchar(20) DEFAULT NULL,
  `Woonplaats` varchar(100) DEFAULT NULL,
  `Telefoon` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gezin`
--

INSERT INTO `gezin` (`Id`, `Naam`, `Adres`, `Postcode`, `Woonplaats`, `Telefoon`, `Email`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Gezin van Zevenhuizen', 'Dorpsstraat 1', '5431 AB', 'Maaskantje', '0411-111111', 'zevenhuizen@maaskantje.nl', b'1', NULL, '2025-07-01 09:56:41.959485', NULL),
(2, 'Gezin Bergkamp', 'Dorpsstraat 2', '5431 AB', 'Maaskantje', '0411-222222', 'bergkamp@maaskantje.nl', b'1', NULL, '2025-07-01 09:56:41.959485', NULL),
(3, 'Gezin van Vliet', 'Dorpsstraat 3', '5431 AB', 'Maaskantje', '0411-333333', 'vliet@maaskantje.nl', b'1', NULL, '2025-07-01 09:56:41.959485', NULL),
(4, 'Gezin Scherder', 'Dorpsstraat 4', '5431 AB', 'Maaskantje', '0411-444444', 'scherder@maaskantje.nl', b'1', NULL, '2025-07-01 09:56:41.959485', NULL),
(5, 'Gezin de Jong', 'Dorpsstraat 5', '5431 AB', 'Maaskantje', '0411-555555', 'dejong@maaskantje.nl', b'1', NULL, '2025-07-01 09:56:41.959485', NULL),
(6, 'Gezin van der Berg', 'Dorpsstraat 6', '5431 AB', 'Maaskantje', '0411-666666', 'vanderberg@maaskantje.nl', b'1', NULL, '2025-07-01 09:56:41.959485', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leverancier`
--

DROP TABLE IF EXISTS `leverancier`;
CREATE TABLE IF NOT EXISTS `leverancier` (
  `Id` int NOT NULL,
  `Naam` varchar(100) NOT NULL,
  `ContactPersoon` varchar(100) DEFAULT NULL,
  `Telefoon` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `leverancier`
--

INSERT INTO `leverancier` (`Id`, `Naam`, `ContactPersoon`, `Telefoon`, `Email`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Bakkerij De Molen', 'Piet de Bakker', '0411-123456', 'bakker@molen.nl', b'1', NULL, '2025-07-01 09:56:41.918683', NULL),
(2, 'Groentehandel Van Dijk', 'Jan van Dijk', '0411-654321', 'groente@vandijk.nl', b'1', NULL, '2025-07-01 09:56:41.918683', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `persoon`
--

DROP TABLE IF EXISTS `persoon`;
CREATE TABLE IF NOT EXISTS `persoon` (
  `Id` int NOT NULL,
  `GezinId` int DEFAULT NULL,
  `Voornaam` varchar(50) NOT NULL,
  `Tussenvoegsel` varchar(20) DEFAULT NULL,
  `Achternaam` varchar(50) NOT NULL,
  `Geboortedatum` date NOT NULL,
  `TypePersoon` varchar(50) NOT NULL,
  `IsVertegenwoordiger` bit(1) DEFAULT b'0',
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`),
  KEY `FK_Persoon_Gezin` (`GezinId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `persoon`
--

INSERT INTO `persoon` (`Id`, `GezinId`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Geboortedatum`, `TypePersoon`, `IsVertegenwoordiger`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, NULL, 'Hans', 'van', 'Leeuwen', '1958-02-12', 'Manager', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(2, NULL, 'Jan', 'van der', 'Sluijs', '1993-04-30', 'Medewerker', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(3, NULL, 'Herman', 'den', 'Duiker', '1989-08-30', 'Vrijwilliger', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(4, 1, 'Johan', 'van', 'Zevenhuizen', '1990-05-20', 'Klant', b'1', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(5, 1, 'Sarah', 'den', 'Dolder', '1985-03-23', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(6, 1, 'Theo', 'van', 'Zevenhuizen', '2015-03-08', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(7, 1, 'Jantien', 'van', 'Zevenhuizen', '2016-09-20', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(8, 2, 'Arjan', NULL, 'Bergkamp', '1968-07-12', 'Klant', b'1', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(9, 2, 'Janneke', NULL, 'Sanders', '1969-05-11', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(10, 2, 'Stein', NULL, 'Bergkamp', '2009-02-02', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(11, 2, 'Judith', NULL, 'Bergkamp', '2022-02-05', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(12, 3, 'Mazin', 'van', 'Vliet', '1968-08-18', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(13, 3, 'Selma', 'van de', 'Heuvel', '1965-09-04', 'Klant', b'1', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(14, 4, 'Eva', NULL, 'Scherder', '2000-04-07', 'Klant', b'1', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(15, 4, 'Felicia', NULL, 'Scherder', '2021-11-29', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(16, 4, 'Devin', NULL, 'Scherder', '2024-03-01', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(17, 5, 'Frieda', 'de', 'Jong', '1980-09-04', 'Klant', b'1', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(18, 5, 'Simeon', 'de', 'Jong', '2018-05-23', 'Klant', b'0', b'1', NULL, '2025-07-01 09:56:41.774710', NULL),
(19, 6, 'Hanna', 'van der', 'Berg', '1999-09-09', 'Klant', b'1', b'1', NULL, '2025-07-01 09:56:41.774710', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Id` int NOT NULL,
  `CategorieId` int NOT NULL,
  `Naam` varchar(100) NOT NULL,
  `Inhoud` varchar(100) DEFAULT NULL,
  `Eenheid` varchar(20) DEFAULT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`),
  KEY `CategorieId` (`CategorieId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`Id`, `CategorieId`, `Naam`, `Inhoud`, `Eenheid`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 'Witbrood', '600', 'gram', b'1', NULL, '2025-07-01 09:56:41.900230', NULL),
(2, 1, 'Tarwebrood', '600', 'gram', b'1', NULL, '2025-07-01 09:56:41.900230', NULL),
(3, 2, 'Komkommer', '500', 'gram', b'1', NULL, '2025-07-01 09:56:41.900230', NULL),
(4, 3, 'Appels', '1', 'stuk', b'1', NULL, '2025-07-01 09:56:41.900230', NULL),
(5, 4, 'Melk', '1', 'liter', b'1', NULL, '2025-07-01 09:56:41.900230', NULL),
(6, 4, 'Yoghurt', '200', 'gram', b'1', NULL, '2025-07-01 09:56:41.900230', NULL),
(7, 5, 'Rundvlees', '300', 'gram', b'1', NULL, '2025-07-01 09:56:41.900230', NULL),
(8, 6, 'Pindakaas', '500', 'gram', b'1', NULL, '2025-07-01 09:56:41.900230', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `Id` int NOT NULL,
  `Naam` varchar(50) NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `rol`
--

INSERT INTO `rol` (`Id`, `Naam`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Manager', b'1', NULL, '2025-07-01 09:56:41.820527', NULL),
(2, 'Medewerker', b'1', NULL, '2025-07-01 09:56:41.820527', NULL),
(3, 'Vrijwilliger', b'1', NULL, '2025-07-01 09:56:41.820527', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `rolpergebruiker`
--

DROP TABLE IF EXISTS `rolpergebruiker`;
CREATE TABLE IF NOT EXISTS `rolpergebruiker` (
  `Id` int NOT NULL,
  `GebruikerId` int NOT NULL,
  `RolId` int NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`),
  KEY `GebruikerId` (`GebruikerId`),
  KEY `RolId` (`RolId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `rolpergebruiker`
--

INSERT INTO `rolpergebruiker` (`Id`, `GebruikerId`, `RolId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, b'1', NULL, '2025-07-01 09:56:41.861310', NULL),
(2, 2, 2, b'1', NULL, '2025-07-01 09:56:41.861310', NULL),
(3, 3, 3, b'1', NULL, '2025-07-01 09:56:41.861310', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `voorraad`
--

DROP TABLE IF EXISTS `voorraad`;
CREATE TABLE IF NOT EXISTS `voorraad` (
  `Id` int NOT NULL,
  `ProductId` int NOT NULL,
  `LeverancierId` int NOT NULL,
  `Aantal` int NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd` datetime(6) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`Id`),
  KEY `ProductId` (`ProductId`),
  KEY `LeverancierId` (`LeverancierId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `voorraad`
--

INSERT INTO `voorraad` (`Id`, `ProductId`, `LeverancierId`, `Aantal`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, 50, b'1', NULL, '2025-07-01 09:56:41.937549', NULL),
(2, 3, 2, 100, b'1', NULL, '2025-07-01 09:56:41.937549', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
