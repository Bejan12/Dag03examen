<?php

class Klant
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllKlanten()
    {
        $this->db->query('SELECT 
            g.Id as GezinId,
            g.Naam as GezinNaam,
            g.Code as GezinCode,
            g.AantalVolwassenen,
            g.AantalKinderen,
            g.AantalBabys,
            g.TotaalAantalPersonen,
            p.Id as PersoonId,
            p.Voornaam,
            p.Tussenvoegsel,
            p.Achternaam,
            p.IsVertegenwoordiger,
            c.Straat,
            c.Huisnummer,
            c.Toevoeging,
            c.Postcode,
            c.Woonplaats,
            c.Email,
            c.Mobiel
        FROM Gezin g
        LEFT JOIN Persoon p ON g.Id = p.GezinId AND p.IsVertegenwoordiger = 1
        LEFT JOIN ContactPerGezin cpg ON g.Id = cpg.GezinId AND cpg.IsActief = 1
        LEFT JOIN Contact c ON cpg.ContactId = c.Id AND c.IsActief = 1
        WHERE g.IsActief = 1
        ORDER BY g.Naam ASC');

        return $this->db->resultSet();
    }

    public function getKlantById($id)
    {
        $this->db->query('SELECT 
            g.Id as GezinId,
            g.Naam as GezinNaam,
            g.Code as GezinCode,
            g.Omschrijving as GezinOmschrijving,
            g.AantalVolwassenen,
            g.AantalKinderen,
            g.AantalBabys,
            g.TotaalAantalPersonen,
            p.Id as PersoonId,
            p.Voornaam,
            p.Tussenvoegsel,
            p.Achternaam,
            p.Geboortedatum,
            p.TypePersoon,
            p.IsVertegenwoordiger,
            c.Straat,
            c.Huisnummer,
            c.Toevoeging,
            c.Postcode,
            c.Woonplaats,
            c.Email,
            c.Mobiel
        FROM Gezin g
        LEFT JOIN Persoon p ON g.Id = p.GezinId
        LEFT JOIN ContactPerGezin cpg ON g.Id = cpg.GezinId AND cpg.IsActief = 1
        LEFT JOIN Contact c ON cpg.ContactId = c.Id AND c.IsActief = 1
        WHERE g.Id = :id AND g.IsActief = 1
        ORDER BY p.IsVertegenwoordiger DESC, p.Geboortedatum DESC');

        $this->db->bind(':id', $id);

        return $this->db->resultSet();
    }

    public function getGezinnenMetEetwensen()
    {
        $this->db->query('SELECT 
            g.Id as GezinId,
            g.Naam as GezinNaam,
            GROUP_CONCAT(e.Naam SEPARATOR ", ") as Eetwensen
        FROM Gezin g
        LEFT JOIN EetwensPerGezin epg ON g.Id = epg.GezinId AND epg.IsActief = 1
        LEFT JOIN Eetwens e ON epg.EetwensId = e.Id AND e.IsActief = 1
        WHERE g.IsActief = 1
        GROUP BY g.Id, g.Naam
        ORDER BY g.Naam ASC');

        return $this->db->resultSet();
    }

    public function getPersonenMetAllergies($gezinId)
    {
        $this->db->query('SELECT 
            p.Voornaam,
            p.Tussenvoegsel,
            p.Achternaam,
            GROUP_CONCAT(a.Naam SEPARATOR ", ") as Allergies
        FROM Persoon p
        LEFT JOIN AllergiePerPersoon app ON p.Id = app.PersoonId AND app.IsActief = 1
        LEFT JOIN Allergie a ON app.AllergieId = a.Id AND a.IsActief = 1
        WHERE p.GezinId = :gezinId AND p.IsActief = 1
        GROUP BY p.Id, p.Voornaam, p.Tussenvoegsel, p.Achternaam
        ORDER BY p.IsVertegenwoordiger DESC, p.Geboortedatum DESC');

        $this->db->bind(':gezinId', $gezinId);

        return $this->db->resultSet();
    }
}
