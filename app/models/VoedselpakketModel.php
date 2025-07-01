<?php

/**
 * VoedselpakketModel - Model voor het beheren van voedselpakketten
 * 
 * @author Voedselbank Maaskantje
 * @version 1.0
 */
class VoedselpakketModel
{
    private $db;

    /**
     * Constructor - Initialiseert database verbinding
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Haalt alle gezinnen met voedselpakketten op
     * 
     * @return array|false Array met gezinnen of false bij fout
     */
    public function getAllGezinnenMetVoedselpakketten()
    {
        try {
            $this->db->query("
                SELECT 
                    g.Id,
                    g.Naam as GezinNaam,
                    g.Code,
                    g.Omschrijving,
                    g.AantalVolwassenen,
                    g.AantalKinderen,
                    g.AantalBabys,
                    g.TotaalAantalPersonen,
                    CONCAT(c.Straat, ' ', c.Huisnummer, IFNULL(CONCAT(' ', c.Toevoeging), '')) as Adres,
                    c.Postcode,
                    c.Woonplaats,
                    c.Email,
                    c.Mobiel,
                    CONCAT(pv.Voornaam, ' ', IFNULL(CONCAT(pv.Tussenvoegsel, ' '), ''), pv.Achternaam) as Vertegenwoordiger
                FROM gezin g
                LEFT JOIN contactpergezin cpg ON g.Id = cpg.GezinId AND cpg.IsActief = 1
                LEFT JOIN contact c ON cpg.ContactId = c.Id AND c.IsActief = 1
                LEFT JOIN persoon pv ON g.Id = pv.GezinId AND pv.IsVertegenwoordiger = 1 AND pv.IsActief = 1
                WHERE g.IsActief = 1
                ORDER BY g.Naam
            ");

            return $this->db->resultSet();
        } catch (Exception $e) {
            // Log de fout
            $this->logError(__METHOD__, $e->getMessage(), []);
            return false;
        }
    }

    /**
     * Haalt alle allergieën op voor dropdown
     * 
     * @return array|false Array met allergieën of false bij fout
     */
    public function getAllAllergieen()
    {
        try {
            $this->db->query("
                SELECT DISTINCT 
                    a.Id,
                    a.Naam as AllergieNaam,
                    a.Omschrijving,
                    a.AnafylactischRisico
                FROM allergie a
                WHERE a.IsActief = 1
                ORDER BY a.Naam
            ");

            return $this->db->resultSet();
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), []);
            return false;
        }
    }

    /**
     * Haalt alle eetwensen op voor dropdown
     * 
     * @return array|false Array met eetwensen of false bij fout
     */
    public function getAllEetwensen()
    {
        try {
            $this->db->query("
                SELECT DISTINCT 
                    e.Id,
                    e.Naam as EetwensNaam,
                    e.Omschrijving
                FROM eetwens e
                WHERE e.IsActief = 1
                ORDER BY e.Naam
            ");

            return $this->db->resultSet();
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), []);
            return false;
        }
    }

    /**
     * Haalt gezinnen op gefilterd op allergie
     * 
     * @param int $allergieId ID van de allergie
     * @return array|false Array met gezinnen of false bij fout
     */
    public function getGezinnenByAllergie(int $allergieId)
    {
        try {
            // Valideer input
            if ($allergieId <= 0) {
                throw new InvalidArgumentException('Allergie ID moet groter zijn dan 0');
            }

            $this->db->query("
                SELECT DISTINCT
                    g.Id,
                    g.Naam as GezinNaam,
                    g.Code,
                    g.Omschrijving,
                    g.AantalVolwassenen,
                    g.AantalKinderen,
                    g.AantalBabys,
                    g.TotaalAantalPersonen,
                    CONCAT(c.Straat, ' ', c.Huisnummer, IFNULL(CONCAT(' ', c.Toevoeging), '')) as Adres,
                    c.Postcode,
                    c.Woonplaats,
                    c.Email,
                    c.Mobiel,
                    CONCAT(pv.Voornaam, ' ', IFNULL(CONCAT(pv.Tussenvoegsel, ' '), ''), pv.Achternaam) as Vertegenwoordiger
                FROM gezin g
                LEFT JOIN contactpergezin cpg ON g.Id = cpg.GezinId AND cpg.IsActief = 1
                LEFT JOIN contact c ON cpg.ContactId = c.Id AND c.IsActief = 1
                LEFT JOIN persoon p ON g.Id = p.GezinId AND p.IsActief = 1
                LEFT JOIN persoon pv ON g.Id = pv.GezinId AND pv.IsVertegenwoordiger = 1 AND pv.IsActief = 1
                INNER JOIN allergieperpersoon app ON p.Id = app.PersoonId AND app.IsActief = 1
                WHERE g.IsActief = 1 AND app.AllergieId = :allergieId
                GROUP BY g.Id, g.Naam, g.Code, g.Omschrijving, g.AantalVolwassenen, g.AantalKinderen, g.AantalBabys, g.TotaalAantalPersonen, c.Straat, c.Huisnummer, c.Toevoeging, c.Postcode, c.Woonplaats, c.Email, c.Mobiel, pv.Voornaam, pv.Tussenvoegsel, pv.Achternaam
                ORDER BY g.Naam
            ");

            $this->db->bind(':allergieId', $allergieId, PDO::PARAM_INT);
            return $this->db->resultSet();
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['allergieId' => $allergieId]);
            return false;
        }
    }

    /**
     * Haalt gezinnen op gefilterd op eetwens
     * 
     * @param int $eetwensId ID van de eetwens
     * @return array|false Array met gezinnen of false bij fout
     */
    public function getGezinnenByEetwens(int $eetwensId)
    {
        try {
            // Valideer input
            if ($eetwensId <= 0) {
                throw new InvalidArgumentException('Eetwens ID moet groter zijn dan 0');
            }

            $this->db->query("
                SELECT DISTINCT
                    g.Id,
                    g.Naam as GezinNaam,
                    g.Code,
                    g.Omschrijving,
                    g.AantalVolwassenen,
                    g.AantalKinderen,
                    g.AantalBabys,
                    g.TotaalAantalPersonen,
                    CONCAT(c.Straat, ' ', c.Huisnummer, IFNULL(CONCAT(' ', c.Toevoeging), '')) as Adres,
                    c.Postcode,
                    c.Woonplaats,
                    c.Email,
                    c.Mobiel,
                    CONCAT(pv.Voornaam, ' ', IFNULL(CONCAT(pv.Tussenvoegsel, ' '), ''), pv.Achternaam) as Vertegenwoordiger
                FROM gezin g
                LEFT JOIN contactpergezin cpg ON g.Id = cpg.GezinId AND cpg.IsActief = 1
                LEFT JOIN contact c ON cpg.ContactId = c.Id AND c.IsActief = 1
                LEFT JOIN persoon pv ON g.Id = pv.GezinId AND pv.IsVertegenwoordiger = 1 AND pv.IsActief = 1
                INNER JOIN eetwenspergezin epg ON g.Id = epg.GezinId AND epg.IsActief = 1
                WHERE g.IsActief = 1 AND epg.EetwensId = :eetwensId
                ORDER BY g.Naam
            ");

            $this->db->bind(':eetwensId', $eetwensId, PDO::PARAM_INT);
            return $this->db->resultSet();
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['eetwensId' => $eetwensId]);
            return false;
        }
    }

    /**
     * Haalt details van een specifiek gezin op
     * 
     * @param int $gezinId ID van het gezin
     * @return object|false Gezin object of false bij fout
     */
    public function getGezinDetails(int $gezinId)
    {
        try {
            if ($gezinId <= 0) {
                throw new InvalidArgumentException('Gezin ID moet groter zijn dan 0');
            }

            $this->db->query("
                SELECT 
                    g.*,
                    CONCAT(c.Straat, ' ', c.Huisnummer, IFNULL(CONCAT(' ', c.Toevoeging), '')) as Adres,
                    c.Postcode,
                    c.Woonplaats,
                    c.Email,
                    c.Mobiel,
                    CONCAT(pv.Voornaam, ' ', IFNULL(CONCAT(pv.Tussenvoegsel, ' '), ''), pv.Achternaam) as Vertegenwoordiger
                FROM gezin g
                LEFT JOIN contactpergezin cpg ON g.Id = cpg.GezinId AND cpg.IsActief = 1
                LEFT JOIN contact c ON cpg.ContactId = c.Id AND c.IsActief = 1
                LEFT JOIN persoon pv ON g.Id = pv.GezinId AND pv.IsVertegenwoordiger = 1 AND pv.IsActief = 1
                WHERE g.Id = :gezinId AND g.IsActief = 1
            ");

            $this->db->bind(':gezinId', $gezinId, PDO::PARAM_INT);
            return $this->db->single();
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['gezinId' => $gezinId]);
            return false;
        }
    }

    /**
     * Log een error naar het logbestand
     * 
     * @param string $method Methode naam
     * @param string $message Error bericht
     * @param array $context Context data
     */
    private function logError(string $method, string $message, array $context = []): void
    {
        $logMessage = date('Y-m-d H:i:s') . " [ERROR] {$method}: {$message}";
        if (!empty($context)) {
            $logMessage .= " | Context: " . json_encode($context);
        }
        
        // Zorg ervoor dat de logs directory exists
        $logDir = APPROOT . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        error_log($logMessage . PHP_EOL, 3, $logDir . '/errors.log');
    }
}