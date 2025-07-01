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

    public function getContactByGezinId($gezinId)
    {
        $this->db->query('SELECT 
            c.Id as ContactId,
            c.Straat,
            c.Huisnummer,
            c.Toevoeging,
            c.Postcode,
            c.Woonplaats,
            c.Email,
            c.Mobiel
        FROM Contact c
        LEFT JOIN ContactPerGezin cpg ON c.Id = cpg.ContactId AND cpg.IsActief = 1
        WHERE cpg.GezinId = :gezinId AND c.IsActief = 1');

        $this->db->bind(':gezinId', $gezinId);

        return $this->db->single();
    }

    public function updateKlantContact($data)
    {
        // Begin transaction
        $this->db->beginTransaction();

        try {
            // Check if contact exists for this gezin
            $existingContact = $this->getContactByGezinId($data['id']);

            if ($existingContact) {
                // Update existing contact
                $this->db->query('UPDATE Contact SET 
                    Straat = :straat,
                    Huisnummer = :huisnummer,
                    Toevoeging = :toevoeging,
                    Postcode = :postcode,
                    Woonplaats = :woonplaats,
                    Email = :email,
                    Mobiel = :mobiel,
                    DatumGewijzigd = SYSDATE(6)
                WHERE Id = :contactId');

                $this->db->bind(':straat', $data['straat']);
                $this->db->bind(':huisnummer', $data['huisnummer']);
                $this->db->bind(':toevoeging', $data['toevoeging']);
                $this->db->bind(':postcode', $data['postcode']);
                $this->db->bind(':woonplaats', $data['woonplaats']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':mobiel', $data['mobiel']);
                $this->db->bind(':contactId', $existingContact->ContactId);

                $this->db->execute();
            } else {
                // Create new contact
                $this->db->query('INSERT INTO Contact (
                    Straat, Huisnummer, Toevoeging, Postcode, Woonplaats, 
                    Email, Mobiel, IsActief, DatumAangemaakt, DatumGewijzigd
                ) VALUES (
                    :straat, :huisnummer, :toevoeging, :postcode, :woonplaats,
                    :email, :mobiel, 1, SYSDATE(6), SYSDATE(6)
                )');

                $this->db->bind(':straat', $data['straat']);
                $this->db->bind(':huisnummer', $data['huisnummer']);
                $this->db->bind(':toevoeging', $data['toevoeging']);
                $this->db->bind(':postcode', $data['postcode']);
                $this->db->bind(':woonplaats', $data['woonplaats']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':mobiel', $data['mobiel']);

                $this->db->execute();

                // Get the new contact ID
                $contactId = $this->db->lastInsertId();

                // Create ContactPerGezin relation
                $this->db->query('INSERT INTO ContactPerGezin (
                    GezinId, ContactId, IsActief, DatumAangemaakt, DatumGewijzigd
                ) VALUES (
                    :gezinId, :contactId, 1, SYSDATE(6), SYSDATE(6)
                )');

                $this->db->bind(':gezinId', $data['id']);
                $this->db->bind(':contactId', $contactId);

                $this->db->execute();
            }

            // Commit transaction
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Rollback transaction
            $this->db->rollback();
            return false;
        }
    }

    public function updateKlant($data)
    {
        // Begin transaction
        $this->db->beginTransaction();

        try {
            // Update persoonlijke gegevens van de vertegenwoordiger
            $this->db->query('UPDATE Persoon SET 
                Voornaam = :voornaam,
                Tussenvoegsel = :tussenvoegsel,
                Achternaam = :achternaam,
                Geboortedatum = :geboortedatum,
                DatumGewijzigd = SYSDATE(6)
            WHERE GezinId = :gezinId AND IsVertegenwoordiger = 1');

            $this->db->bind(':voornaam', $data['voornaam']);
            $this->db->bind(':tussenvoegsel', $data['tussenvoegsel']);
            $this->db->bind(':achternaam', $data['achternaam']);
            $this->db->bind(':geboortedatum', $data['geboortedatum']);
            $this->db->bind(':gezinId', $data['id']);

            $this->db->execute();

            // Update contactgegevens
            $existingContact = $this->getContactByGezinId($data['id']);

            if ($existingContact) {
                // Update existing contact
                $this->db->query('UPDATE Contact SET 
                    Straat = :straat,
                    Huisnummer = :huisnummer,
                    Toevoeging = :toevoeging,
                    Postcode = :postcode,
                    Woonplaats = :woonplaats,
                    Email = :email,
                    Mobiel = :mobiel,
                    DatumGewijzigd = SYSDATE(6)
                WHERE Id = :contactId');

                $this->db->bind(':straat', $data['straat']);
                $this->db->bind(':huisnummer', $data['huisnummer']);
                $this->db->bind(':toevoeging', $data['toevoeging']);
                $this->db->bind(':postcode', $data['postcode']);
                $this->db->bind(':woonplaats', $data['woonplaats']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':mobiel', $data['mobiel']);
                $this->db->bind(':contactId', $existingContact->ContactId);

                $this->db->execute();
            } else {
                // Create new contact
                $this->db->query('INSERT INTO Contact (
                    Straat, Huisnummer, Toevoeging, Postcode, Woonplaats, 
                    Email, Mobiel, IsActief, DatumAangemaakt, DatumGewijzigd
                ) VALUES (
                    :straat, :huisnummer, :toevoeging, :postcode, :woonplaats,
                    :email, :mobiel, 1, SYSDATE(6), SYSDATE(6)
                )');

                $this->db->bind(':straat', $data['straat']);
                $this->db->bind(':huisnummer', $data['huisnummer']);
                $this->db->bind(':toevoeging', $data['toevoeging']);
                $this->db->bind(':postcode', $data['postcode']);
                $this->db->bind(':woonplaats', $data['woonplaats']);
                $this->db->bind(':email', $data['email']);
                $this->db->bind(':mobiel', $data['mobiel']);

                $this->db->execute();

                // Get the new contact ID
                $contactId = $this->db->lastInsertId();

                // Create ContactPerGezin relation
                $this->db->query('INSERT INTO ContactPerGezin (
                    GezinId, ContactId, IsActief, DatumAangemaakt, DatumGewijzigd
                ) VALUES (
                    :gezinId, :contactId, 1, SYSDATE(6), SYSDATE(6)
                )');

                $this->db->bind(':gezinId', $data['id']);
                $this->db->bind(':contactId', $contactId);

                $this->db->execute();
            }

            // Commit transaction
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Rollback transaction
            $this->db->rollback();
            return false;
        }
    }

    public function getAllGezinIds()
    {
        $this->db->query('SELECT Id FROM Gezin WHERE IsActief = 1 ORDER BY Id');
        return $this->db->resultSet();
    }
}
