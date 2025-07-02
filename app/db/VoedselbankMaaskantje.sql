-- Step: 01
     -- ***************************************************************
     -- Doel : Maak een nieuwe database aan met de naam VoedselbankMaaskantje
     -- ***************************************************************
     -- Versie       Datum           Auteur              Omschrijving
     -- ******       *****           ******              ************
     -- 01           01-07-2025      Bejan Afkar         VoedselbankMaaskantje
     -- ***************************************************************

     -- Verwijder database VoedselbankMaaskantje
     DROP DATABASE IF EXISTS `VoedselbankMaaskantje`;

     -- Maak een nieuwe database aan VoedselbankMaaskantje
     CREATE DATABASE `VoedselbankMaaskantje`;

     -- Gebruik database VoedselbankMaaskantje
     USE `VoedselbankMaaskantje`;

     -- Step: 02
     -- ***************************************************************
     -- Doel : Maak alle tabellen aan voor VoedselbankMaaskantje
     -- ***************************************************************

     -- Tabel: Rol
     CREATE TABLE Rol
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,Naam              VARCHAR(50)                 NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Rol_Id       PRIMARY KEY CLUSTERED(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Categorie
     CREATE TABLE Categorie
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,Naam              VARCHAR(50)                 NOT NULL
          ,Omschrijving      VARCHAR(255)                NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Categorie_Id PRIMARY KEY CLUSTERED(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Contact
     CREATE TABLE Contact
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,Straat            VARCHAR(100)                NOT NULL
          ,Huisnummer        VARCHAR(10)                 NOT NULL
          ,Toevoeging        VARCHAR(10)                     NULL
          ,Postcode          VARCHAR(10)                 NOT NULL
          ,Woonplaats        VARCHAR(50)                 NOT NULL
          ,Email             VARCHAR(100)                NOT NULL
          ,Mobiel            VARCHAR(20)                 NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Contact_Id   PRIMARY KEY CLUSTERED(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Eetwens
     CREATE TABLE Eetwens
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,Naam              VARCHAR(50)                 NOT NULL
          ,Omschrijving      VARCHAR(255)                NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Eetwens_Id   PRIMARY KEY CLUSTERED(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Allergie
     CREATE TABLE Allergie
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,Naam              VARCHAR(50)                 NOT NULL
          ,Omschrijving      VARCHAR(255)                NOT NULL
          ,AnafylactischRisico VARCHAR(50)               NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Allergie_Id  PRIMARY KEY CLUSTERED(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Gezin
     CREATE TABLE Gezin
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,Naam              VARCHAR(100)                NOT NULL
          ,Code              VARCHAR(10)                 NOT NULL        UNIQUE
          ,Omschrijving      VARCHAR(255)                NOT NULL
          ,AantalVolwassenen TINYINT         UNSIGNED    NOT NULL
          ,AantalKinderen    TINYINT         UNSIGNED    NOT NULL
          ,AantalBabys       TINYINT         UNSIGNED    NOT NULL
          ,TotaalAantalPersonen TINYINT      UNSIGNED    NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Gezin_Id     PRIMARY KEY CLUSTERED(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Leverancier
     CREATE TABLE Leverancier
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,Naam              VARCHAR(100)                NOT NULL
          ,ContactPersoon    VARCHAR(100)                NOT NULL
          ,LeverancierNummer VARCHAR(20)                 NOT NULL        UNIQUE
          ,LeverancierType   VARCHAR(50)                 NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Leverancier_Id PRIMARY KEY CLUSTERED(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Magazijn
     CREATE TABLE Magazijn
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,Ontvangstdatum    DATE                        NOT NULL
          ,Uitleveringsdatum DATE                            NULL
          ,VerpakkingsEenheid VARCHAR(50)                NOT NULL
          ,Aantal            INT             UNSIGNED    NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Magazijn_Id  PRIMARY KEY CLUSTERED(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Persoon
     CREATE TABLE Persoon
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,GezinId           SMALLINT        UNSIGNED        NULL
          ,Voornaam          VARCHAR(50)                 NOT NULL
          ,Tussenvoegsel     VARCHAR(20)                     NULL
          ,Achternaam        VARCHAR(50)                 NOT NULL
          ,Geboortedatum     DATE                        NOT NULL
          ,TypePersoon       VARCHAR(50)                 NOT NULL
          ,IsVertegenwoordiger BIT                       NOT NULL        DEFAULT 0
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Persoon_Id   PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_Persoon_GezinId FOREIGN KEY (GezinId) REFERENCES Gezin(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Gebruiker
     CREATE TABLE Gebruiker
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,PersoonId         SMALLINT        UNSIGNED    NOT NULL
          ,InlogNaam         VARCHAR(50)                 NOT NULL        UNIQUE
          ,Gebruikersnaam    VARCHAR(100)                NOT NULL
          ,Wachtwoord        VARCHAR(255)                NOT NULL
          ,IsIngelogd        BIT                         NOT NULL        DEFAULT 0
          ,Ingelogd          DATETIME(6)                     NULL
          ,Uitgelogd         DATETIME(6)                     NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Gebruiker_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_Gebruiker_PersoonId FOREIGN KEY (PersoonId) REFERENCES Persoon(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Product
     CREATE TABLE Product
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,CategorieId       SMALLINT        UNSIGNED    NOT NULL
          ,Naam              VARCHAR(100)                NOT NULL
          ,SoortAllergie     VARCHAR(100)                    NULL
          ,Barcode           VARCHAR(50)                 NOT NULL
          ,Houdbaarheidsdatum DATE                       NOT NULL
          ,Omschrijving      VARCHAR(255)                NOT NULL
          ,Status            VARCHAR(50)                 NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Product_Id   PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_Product_CategorieId FOREIGN KEY (CategorieId) REFERENCES Categorie(Id)
     ) ENGINE=InnoDB;

     -- Tabel: Voedselpakket
     CREATE TABLE Voedselpakket
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,GezinId           SMALLINT        UNSIGNED    NOT NULL
          ,PakketNummer      INT             UNSIGNED    NOT NULL
          ,DatumSamenstelling DATE                       NOT NULL
          ,DatumUitgifte     DATE                            NULL
          ,Status            VARCHAR(50)                 NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_Voedselpakket_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_Voedselpakket_GezinId FOREIGN KEY (GezinId) REFERENCES Gezin(Id)
     ) ENGINE=InnoDB;

     -- Tabel: AllergiePerPersoon
     CREATE TABLE AllergiePerPersoon
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,PersoonId         SMALLINT        UNSIGNED    NOT NULL
          ,AllergieId        SMALLINT        UNSIGNED    NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_AllergiePerPersoon_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_AllergiePerPersoon_PersoonId FOREIGN KEY (PersoonId) REFERENCES Persoon(Id)
          ,CONSTRAINT        FK_AllergiePerPersoon_AllergieId FOREIGN KEY (AllergieId) REFERENCES Allergie(Id)
     ) ENGINE=InnoDB;

     -- Tabel: RolPerGebruiker
     CREATE TABLE RolPerGebruiker
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,GebruikerId       SMALLINT        UNSIGNED    NOT NULL
          ,RolId             SMALLINT        UNSIGNED    NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_RolPerGebruiker_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_RolPerGebruiker_GebruikerId FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
          ,CONSTRAINT        FK_RolPerGebruiker_RolId FOREIGN KEY (RolId) REFERENCES Rol(Id)
     ) ENGINE=InnoDB;

     -- Tabel: EetwensPerGezin
     CREATE TABLE EetwensPerGezin
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,GezinId           SMALLINT        UNSIGNED    NOT NULL
          ,EetwensId         SMALLINT        UNSIGNED    NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_EetwensPerGezin_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_EetwensPerGezin_GezinId FOREIGN KEY (GezinId) REFERENCES Gezin(Id)
          ,CONSTRAINT        FK_EetwensPerGezin_EetwensId FOREIGN KEY (EetwensId) REFERENCES Eetwens(Id)
     ) ENGINE=InnoDB;

     -- Tabel: ContactPerLeverancier
     CREATE TABLE ContactPerLeverancier
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,LeverancierId     SMALLINT        UNSIGNED    NOT NULL
          ,ContactId         SMALLINT        UNSIGNED    NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_ContactPerLeverancier_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_ContactPerLeverancier_LeverancierId FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id)
          ,CONSTRAINT        FK_ContactPerLeverancier_ContactId FOREIGN KEY (ContactId) REFERENCES Contact(Id)
     ) ENGINE=InnoDB;

     -- Tabel: ContactPerGezin
     CREATE TABLE ContactPerGezin
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,GezinId           SMALLINT        UNSIGNED    NOT NULL
          ,ContactId         SMALLINT        UNSIGNED    NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_ContactPerGezin_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_ContactPerGezin_GezinId FOREIGN KEY (GezinId) REFERENCES Gezin(Id)
          ,CONSTRAINT        FK_ContactPerGezin_ContactId FOREIGN KEY (ContactId) REFERENCES Contact(Id)
     ) ENGINE=InnoDB;

     -- Tabel: ProductPerVoedselpakket
     CREATE TABLE ProductPerVoedselpakket
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,VoedselpakketId   SMALLINT        UNSIGNED    NOT NULL
          ,ProductId         SMALLINT        UNSIGNED    NOT NULL
          ,AantalProductEenheden INT          UNSIGNED    NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_ProductPerVoedselpakket_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_ProductPerVoedselpakket_VoedselpakketId FOREIGN KEY (VoedselpakketId) REFERENCES Voedselpakket(Id)
          ,CONSTRAINT        FK_ProductPerVoedselpakket_ProductId FOREIGN KEY (ProductId) REFERENCES Product(Id)
     ) ENGINE=InnoDB;

     -- Tabel: ProductPerLeverancier
     CREATE TABLE ProductPerLeverancier
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,LeverancierId     SMALLINT        UNSIGNED    NOT NULL
          ,ProductId         SMALLINT        UNSIGNED    NOT NULL
          ,DatumAangeleverd  DATE                        NOT NULL
          ,DatumEerstVolgendeLevering DATE               NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_ProductPerLeverancier_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_ProductPerLeverancier_LeverancierId FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id)
          ,CONSTRAINT        FK_ProductPerLeverancier_ProductId FOREIGN KEY (ProductId) REFERENCES Product(Id)
     ) ENGINE=InnoDB;

     -- Tabel: ProductPerMagazijn
     CREATE TABLE ProductPerMagazijn
     (
          Id                 SMALLINT        UNSIGNED    NOT NULL        AUTO_INCREMENT
          ,ProductId         SMALLINT        UNSIGNED    NOT NULL
          ,MagazijnId        SMALLINT        UNSIGNED    NOT NULL
          ,Locatie           VARCHAR(50)                 NOT NULL
          ,IsActief          BIT                         NOT NULL        DEFAULT 1
          ,Opmerking         VARCHAR(255)                    NULL        DEFAULT NULL
          ,DatumAangemaakt   DATETIME(6)                 NOT NULL
          ,DatumGewijzigd    DATETIME(6)                 NOT NULL
          ,CONSTRAINT        PK_ProductPerMagazijn_Id PRIMARY KEY CLUSTERED(Id)
          ,CONSTRAINT        FK_ProductPerMagazijn_ProductId FOREIGN KEY (ProductId) REFERENCES Product(Id)
          ,CONSTRAINT        FK_ProductPerMagazijn_MagazijnId FOREIGN KEY (MagazijnId) REFERENCES Magazijn(Id)
     ) ENGINE=InnoDB;

     -- Step: 03
     -- ***************************************************************
     -- Doel : Vul alle tabellen met dummy data
     -- ***************************************************************

     -- Vul tabel Rol
     INSERT INTO Rol (Naam, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     ('Manager', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Medewerker', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Vrijwilliger', 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Categorie
     INSERT INTO Categorie (Naam, Omschrijving, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     ('AGF', 'Aardappelen groente en fruit', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('KV', 'Kaas en vleeswaren', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('ZPE', 'Zuivel plantaardig en eieren', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('BB', 'Bakkerij en Banket', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('FSKT', 'Frisdranken, sappen, koffie en thee', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('PRW', 'Pasta, rijst en wereldkeuken', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('SSKO', 'Soepen, sauzen, kruiden en olie', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('SKCC', 'Snoep, koek, chips en chocolade', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('BVH', 'Baby, verzorging en hygiëne', 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Contact
     INSERT INTO Contact (Straat, Huisnummer, Toevoeging, Postcode, Woonplaats, Email, Mobiel, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     ('Prinses Irenestraat', '12', 'A', '5271TH', 'Maaskantje', 'j.van.zevenhuizen@gmail.com', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Gibraltarstraat', '234', NULL, '5271TJ', 'Maaskantje', 'a.bergkamp@hotmail.com', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Der Kinderenstraat', '456', 'Bis', '5271TH', 'Maaskantje', 's.van.de.heuvel@gmail.com', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Nachtegaalstraat', '233', 'A', '5271TJ', 'Maaskantje', 'e.scherder@gmail.com', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Bertram Russellstraat', '45', NULL, '5271TH', 'Maaskantje', 'f.de.jong@hotmail.com', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Leonardo Da VinciHof', '34', NULL, '5271ZE', 'Maaskantje', 'h.van.der.berg@gmail.com', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Siegfried Knutsenlaan', '234', NULL, '5271ZE', 'Maaskantje', 'r.ter.weijden@ah.nl', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Theo de Bokstraat', '256', NULL, '5271ZH', 'Maaskantje', 'l.pastoor@gmail.com', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Meester van Leerhof', '2', 'A', '5271ZH', 'Maaskantje', 'm.yazidi@gemeenteutrecht.nl', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Van Wemelenplantsoen', '300', NULL, '5271TH', 'Maaskantje', 'b.van.driel@gmail.com', '+31 623456123', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Terlingenhof', '20', NULL, '5271TH', 'Maaskantje', 'j.pastorius@gmail.com', '+31 623456356', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Veldhoen', '31', NULL, '5271ZE', 'Maaskantje', 's.dollaard@gmail.com', '+31 623452314', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('ScheringaDreef', '37', NULL, '5271ZE', 'Vught', 'j.blokker@gemeentevught.nl', '+31 623452314', 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Eetwens
     INSERT INTO Eetwens (Naam, Omschrijving, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     ('GeenVarken', 'Geen Varkensvlees', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Veganistisch', 'Geen zuivelproducten en vlees', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Vegetarisch', 'Geen vlees', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Omnivoor', 'Geen beperkingen', 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Allergie
     INSERT INTO Allergie (Naam, Omschrijving, AnafylactischRisico, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     ('Gluten', 'Allergisch voor gluten', 'zeerlaag', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Pindas', 'Allergisch voor pindas', 'Hoog', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Schaaldieren', 'Allergisch voor schaaldieren', 'RedelijkHoog', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Hazelnoten', 'Allergisch voor hazelnoten', 'laag', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Lactose', 'Allergisch voor lactose', 'Zeerlaag', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Soja', 'Allergisch voor soja', 'Zeerlaag', 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Gezin
     INSERT INTO Gezin (Naam, Code, Omschrijving, AantalVolwassenen, AantalKinderen, AantalBabys, TotaalAantalPersonen, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     ('ZevenhuizenGezin', 'G0001', 'Bijstandsgezin', 2, 2, 0, 4, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('BergkampGezin', 'G0002', 'Bijstandsgezin', 2, 1, 1, 4, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('HeuvelGezin', 'G0003', 'Bijstandsgezin', 2, 0, 0, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('ScherderGezin', 'G0004', 'Bijstandsgezin', 1, 0, 2, 3, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('DeJongGezin', 'G0005', 'Bijstandsgezin', 1, 1, 0, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('VanderBergGezin', 'G0006', 'AlleenGaande', 1, 0, 0, 1, 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Leverancier
     INSERT INTO Leverancier (Naam, ContactPersoon, LeverancierNummer, LeverancierType, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     ('Albert Heijn', 'Ruud ter Weijden', 'L0001', 'Bedrijf', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Albertus Kerk', 'Leo Pastoor', 'L0002', 'Instelling', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Gemeente Utrecht', 'Mohammed Yazidi', 'L0003', 'Overheid', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Boerderij Meerhoven', 'Bertus van Driel', 'L0004', 'Particulier', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Jan van der Heijden', 'Jan van der Heijden', 'L0005', 'Donor', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Vomar', 'Jaco Pastorius', 'L0006', 'Bedrijf', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('DekaMarkt', 'Sil den Dollaard', 'L0007', 'Bedrijf', 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('Gemeente Vught', 'Jan Blokker', 'L0008', 'Overheid', 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Magazijn
     INSERT INTO Magazijn (Ontvangstdatum, Uitleveringsdatum, VerpakkingsEenheid, Aantal, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     ('2024-05-12', NULL, '5 kg', 20, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-05-26', NULL, '2.5 kg', 40, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-02', NULL, '1 kg', 30, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-05-16', NULL, '1.5 kg', 25, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-05-23', NULL, '4 stuks', 75, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-03-12', NULL, '1 kg/tros', 60, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-03-19', NULL, '2 kg/tros', 200, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-06-19', NULL, '200 g', 45, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-07-23', NULL, '100 g', 60, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-07-23', NULL, '1 liter', 120, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-06-02', NULL, '250 g', 80, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-01-04', NULL, '6 stuks', 120, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-07', NULL, '800 g', 220, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-04', NULL, '1 stuk', 130, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-28', NULL, '150 ml', 72, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-19', NULL, '1 l', 12, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-23', NULL, '250 g', 300, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-03-02', NULL, '25 zakjes', 280, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-16', NULL, '500 g', 330, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-25', NULL, '1 kg', 34, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-13', NULL, '50 g', 23, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-23', NULL, '1 l', 46, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-21', NULL, '250 ml', 98, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-30', NULL, '1 potje', 56, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-27', NULL, '1 l', 210, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-01', NULL, '4 stuks', 24, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-07', NULL, '300 g', 87, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-22', NULL, '200 g', 230, 1, NULL, SYSDATE(6), SYSDATE(6)),
     ('2024-04-21', NULL, '80 g', 30, 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Persoon
     INSERT INTO Persoon (GezinId, Voornaam, Tussenvoegsel, Achternaam, Geboortedatum, TypePersoon, IsVertegenwoordiger, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (NULL, 'Hans', 'van', 'Leeuwen', '1958-02-12', 'Manager', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (NULL, 'Jan', 'van der', 'Sluijs', '1993-04-30', 'Medewerker', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (NULL, 'Herman', 'den', 'Duiker', '1989-08-30', 'Vrijwilliger', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Johan', 'van', 'Zevenhuizen', '1990-05-20', 'Klant', 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Sarah', 'den', 'Dolder', '1985-03-23', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Theo', 'van', 'Zevenhuizen', '2015-03-08', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Jantien', 'van', 'Zevenhuizen', '2016-09-20', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 'Arjan', NULL, 'Bergkamp', '1968-07-12', 'Klant', 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 'Janneke', NULL, 'Sanders', '1969-05-11', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 'Stein', NULL, 'Bergkamp', '2009-02-02', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 'Judith', NULL, 'Bergkamp', '2022-02-05', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 'Mazin', 'van', 'Vliet', '1968-08-18', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 'Selma', 'van de', 'Heuvel', '1965-09-04', 'Klant', 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 'Eva', NULL, 'Scherder', '2000-04-07', 'Klant', 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 'Felicia', NULL, 'Scherder', '2021-11-29', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 'Devin', NULL, 'Scherder', '2024-03-01', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 'Frieda', 'de', 'Jong', '1980-09-04', 'Klant', 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 'Simeon', 'de', 'Jong', '2018-05-23', 'Klant', 0, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 'Hanna', 'van der', 'Berg', '1999-09-09', 'Klant', 1, 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Gebruiker
     INSERT INTO Gebruiker (PersoonId, InlogNaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Ingelogd, Uitgelogd, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 'Hans', 'hans@maaskantje.nl', '$2y$10$J/NG36JIuaO7qfkwz0pKyO5WWS8x1CJfIDCuNJvkDwjv9Sal3lQz2', 0, NULL, NULL, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 'Jan', 'jan@maaskantje.nl', '$2y$10$J/NG36JIuaO7qfkwz0pKyO5WWS8x1CJfIDCuNJvkDwjv9Sal3lQz2', 0, NULL, NULL, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 'Herman', 'herman@maaskantje.nl', '$2y$10$J/NG36JIuaO7qfkwz0pKyO5WWS8x1CJfIDCuNJvkDwjv9Sal3lQz2', 0, NULL, NULL, 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Product
     INSERT INTO Product (CategorieId, Naam, SoortAllergie, Barcode, Houdbaarheidsdatum, Omschrijving, Status, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 'Aardappel', NULL, '8719587321239', '2024-07-12', 'Kruimige aardappel', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Aardappel', NULL, '8719587321239', '2024-07-26', 'Kruimige aardappel', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Ui', NULL, '8719437321335', '2024-09-02', 'Gele ui', 'NietOpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Appel', NULL, '8719486321332', '2024-08-16', 'Granny Smith', 'NietLeverbaar', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Appel', NULL, '8719486321332', '2024-09-23', 'Granny Smith', 'NietLeverbaar', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Banaan', 'Banaan', '8719484321336', '2024-07-12', 'Biologische Banaan', 'OverHoudbaarheidsDatum', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 'Banaan', 'Banaan', '8719484321336', '2024-07-19', 'Biologische Banaan', 'OverHoudbaarheidsDatum', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 'Kaas', 'Lactose', '8719487421338', '2024-09-19', 'Jonge Kaas', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 'Rosbief', NULL, '8719487421331', '2024-07-23', 'Rundvlees', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 'Melk', 'Lactose', '8719447321332', '2024-07-23', 'Halfvolle melk', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 'Margarine', NULL, '8719486321336', '2024-08-02', 'Plantaardige boter', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 'Ei', 'Eier', '8719487421334', '2024-08-04', 'Scharrelei', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 'Brood', 'Gluten', '8719487721337', '2024-07-07', 'Volkoren brood', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 'Gevulde Koek', 'Amandel', '8719483321333', '2024-09-04', 'Banketbakkers kwaliteit', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 'Fristi', 'Lactose', '8719487121331', '2024-10-28', 'Frisdrank', 'NietOpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 'Appelsap', NULL, '8719487521335', '2024-10-19', '100% vruchtensap', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 'Koffie', 'Caffeïne', '8719487381338', '2024-10-23', 'Arabica koffie', 'OverHoudbaarheidsDatum', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 'Thee', 'Theïne', '8719487329339', '2024-09-02', 'Ceylon thee', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 'Pasta', 'Gluten', '8719487321334', '2024-12-16', 'Macaroni', 'NietLeverbaar', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 'Rijst', NULL, '8719487331332', '2024-12-25', 'Basmati Rijst', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 'Knorr Nasi Mix', NULL, '871948735135', '2024-12-13', 'Nasi kruiden', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (7, 'Tomatensoep', NULL, '8719487371337', '2024-12-23', 'Romige tomatensoep', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (7, 'Tomatensaus', NULL, '8719487341334', '2024-12-21', 'Pizza saus', 'NietOpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (7, 'Peterselie', NULL, '8719487321636', '2024-07-31', 'Verse kruidenpot', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (8, 'Olie', NULL, '8719487327337', '2024-12-27', 'Olijfolie', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (8, 'Mars', NULL, '8719487324334', '2024-12-11', 'Snoep', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (8, 'Biscuit', NULL, '8719487311331', '2024-08-07', 'San Francisco biscuit', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (8, 'Paprika Chips', NULL, '87194873218398', '2024-12-22', 'Ribbelchips paprika', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (8, 'Chocolade reep', 'Cacoa', '8719487321533', '2024-11-21', 'Tony Chocolonely', 'OpVoorraad', 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul tabel Voedselpakket
     INSERT INTO Voedselpakket (GezinId, PakketNummer, DatumSamenstelling, DatumUitgifte, Status, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 1, '2024-04-06', '2024-04-07', 'Uitgereikt', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 2, '2024-04-13', NULL, 'NietUitgereikt', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 3, '2024-04-20', NULL, 'NietMeerIngeschreven', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 4, '2024-04-06', '2024-04-07', 'Uitgereikt', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 5, '2024-04-13', '2024-04-14', 'Uitgereikt', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 6, '2024-04-20', NULL, 'NietUitgereikt', 1, NULL, SYSDATE(6), SYSDATE(6));

     -- Vul junction tabellen
     INSERT INTO AllergiePerPersoon (PersoonId, AllergieId, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (4, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 3, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (7, 4, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (8, 3, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (9, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (10, 5, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (12, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (13, 4, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (14, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (15, 3, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (16, 5, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (17, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (17, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (18, 4, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (19, 4, 1, NULL, SYSDATE(6), SYSDATE(6));

     INSERT INTO RolPerGebruiker (GebruikerId, RolId, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 3, 1, NULL, SYSDATE(6), SYSDATE(6));

     INSERT INTO EetwensPerGezin (GezinId, EetwensId, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 4, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 4, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 3, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 2, 1, NULL, SYSDATE(6), SYSDATE(6));

     INSERT INTO ContactPerLeverancier (LeverancierId, ContactId, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 7, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 8, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 9, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 10, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 11, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (7, 12, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (8, 13, 1, NULL, SYSDATE(6), SYSDATE(6));

     INSERT INTO ContactPerGezin (GezinId, ContactId, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 3, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 4, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 5, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 6, 1, NULL, SYSDATE(6), SYSDATE(6));

     INSERT INTO ProductPerVoedselpakket (VoedselpakketId, ProductId, AantalProductEenheden, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 7, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 8, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 9, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 12, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 13, 2, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 14, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 3, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 4, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 20, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 19, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 21, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 24, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 25, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 26, 1, 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 26, 1, 1, NULL, SYSDATE(6), SYSDATE(6));

     INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumAangeleverd, DatumEerstVolgendeLevering, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (4, 1, '2024-04-12', '2024-05-12', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 2, '2024-03-02', '2024-04-02', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 3, '2024-07-16', '2024-08-16', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 4, '2024-02-12', '2024-03-12', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 5, '2024-05-19', '2024-06-19', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 6, '2024-06-23', '2024-07-23', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 7, '2024-06-20', '2024-07-20', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 8, '2024-05-02', '2024-06-02', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 9, '2022-12-04', '2024-01-04', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 10, '2024-03-07', '2024-04-07', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 11, '2024-02-04', '2024-03-04', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 12, '2024-02-28', '2024-03-28', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 13, '2024-03-19', '2024-04-19', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 14, '2024-03-23', '2024-04-23', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 15, '2024-02-02', '2024-03-02', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 16, '2024-02-16', '2024-03-16', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 17, '2024-03-25', '2024-04-25', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 18, '2024-03-13', '2024-04-13', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 19, '2024-03-23', '2024-04-23', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 20, '2024-02-21', '2024-03-21', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 21, '2024-03-31', '2024-04-30', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 22, '2024-03-27', '2024-04-27', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 23, '2024-04-11', '2024-04-18', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 24, '2024-04-07', '2024-04-14', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (1, 25, '2024-05-07', '2024-05-14', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 26, '2024-05-05', '2024-05-12', 1, NULL, SYSDATE(6), SYSDATE(6));

     INSERT INTO ProductPerMagazijn (ProductId, MagazijnId, Locatie, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
     VALUES
     (1, 1, 'Berlicum', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (2, 2, 'Rosmalen', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (3, 3, 'Berlicum', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (4, 4, 'Berlicum', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (5, 5, 'Rosmalen', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (6, 6, 'Berlicum', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (7, 7, 'Rosmalen', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (8, 8, 'Sint-MichelsGestel', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (9, 9, 'Sint-MichelsGestel', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (10, 10, 'Middelrode', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (11, 11, 'Middelrode', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (12, 12, 'Middelrode', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (13, 13, 'Schijndel', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (14, 14, 'Schijndel', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (15, 15, 'Gemonde', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (16, 16, 'Gemonde', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (17, 17, 'Gemonde', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (18, 18, 'Gemonde', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (19, 19, 'Den Bosch', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (20, 20, 'Den Bosch', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (21, 21, 'Den Bosch', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (22, 22, 'Heeswijk Dinther', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (23, 23, 'Heeswijk Dinther', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (24, 24, 'Heeswijk Dinther', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (25, 25, 'Vught', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (26, 26, 'Vught', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (27, 27, 'Vught', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (28, 28, 'Vught', 1, NULL, SYSDATE(6), SYSDATE(6)),
     (29, 29, 'Vught', 1, NULL, SYSDATE(6), SYSDATE(6));