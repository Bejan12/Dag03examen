<?php

class VoedselpakketModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllGezinnenMetVoedselpakketten()
    {
        $this->db->query("
            SELECT 
                g.Id,
                g.Naam as GezinNaam,
                g.Adres,
                g.Postcode,
                g.Woonplaats,
                g.Telefoon,
                g.Email,
                COUNT(CASE WHEN p.TypePersoon = 'Klant' AND YEAR(CURDATE()) - YEAR(p.Geboortedatum) >= 18 THEN 1 END) as AantalVolwassenen,
                COUNT(CASE WHEN p.TypePersoon = 'Klant' AND YEAR(CURDATE()) - YEAR(p.Geboortedatum) BETWEEN 2 AND 17 THEN 1 END) as AantalKinderen,
                COUNT(CASE WHEN p.TypePersoon = 'Klant' AND YEAR(CURDATE()) - YEAR(p.Geboortedatum) < 2 THEN 1 END) as AantalBabys,
                CONCAT(pv.Voornaam, ' ', IFNULL(CONCAT(pv.Tussenvoegsel, ' '), ''), pv.Achternaam) as Vertegenwoordiger
            FROM gezin g
            LEFT JOIN persoon p ON g.Id = p.GezinId AND p.IsActief = 1
            LEFT JOIN persoon pv ON g.Id = pv.GezinId AND pv.IsVertegenwoordiger = 1 AND pv.IsActief = 1
            WHERE g.IsActief = 1
            GROUP BY g.Id, g.Naam, g.Adres, g.Postcode, g.Woonplaats, g.Telefoon, g.Email, pv.Voornaam, pv.Tussenvoegsel, pv.Achternaam
            ORDER BY g.Naam
        ");

        return $this->db->resultSet();
    }

    public function getAllEetwensen()
    {
        $this->db->query("
            SELECT DISTINCT 
                a.Id,
                a.Naam as EetwensNaam
            FROM allergie a
            WHERE a.IsActief = 1
            ORDER BY a.Naam
        ");

        return $this->db->resultSet();
    }

    public function getGezinnenByEetwens($eetwensId)
    {
        $this->db->query("
            SELECT DISTINCT
                g.Id,
                g.Naam as GezinNaam,
                g.Adres,
                g.Postcode,
                g.Woonplaats,
                g.Telefoon,
                g.Email,
                COUNT(CASE WHEN p.TypePersoon = 'Klant' AND YEAR(CURDATE()) - YEAR(p.Geboortedatum) >= 18 THEN 1 END) as AantalVolwassenen,
                COUNT(CASE WHEN p.TypePersoon = 'Klant' AND YEAR(CURDATE()) - YEAR(p.Geboortedatum) BETWEEN 2 AND 17 THEN 1 END) as AantalKinderen,
                COUNT(CASE WHEN p.TypePersoon = 'Klant' AND YEAR(CURDATE()) - YEAR(p.Geboortedatum) < 2 THEN 1 END) as AantalBabys,
                CONCAT(pv.Voornaam, ' ', IFNULL(CONCAT(pv.Tussenvoegsel, ' '), ''), pv.Achternaam) as Vertegenwoordiger
            FROM gezin g
            LEFT JOIN persoon p ON g.Id = p.GezinId AND p.IsActief = 1
            LEFT JOIN persoon pv ON g.Id = pv.GezinId AND pv.IsVertegenwoordiger = 1 AND pv.IsActief = 1
            INNER JOIN allergieperpersoon app ON p.Id = app.PersoonId AND app.IsActief = 1
            WHERE g.IsActief = 1 AND app.AllergieId = :eetwensId
            GROUP BY g.Id, g.Naam, g.Adres, g.Postcode, g.Woonplaats, g.Telefoon, g.Email, pv.Voornaam, pv.Tussenvoegsel, pv.Achternaam
            ORDER BY g.Naam
        ");

        $this->db->bind(':eetwensId', $eetwensId);
        return $this->db->resultSet();
    }
}