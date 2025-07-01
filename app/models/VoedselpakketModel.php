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
     * Haalt alle voedselpakketten van een gezin op
     * 
     * @param int $gezinId ID van het gezin
     * @return array|false Array met voedselpakketten of false bij fout
     */
    public function getVoedselpakkettenByGezin(int $gezinId)
    {
        try {
            if ($gezinId <= 0) {
                throw new InvalidArgumentException('Gezin ID moet groter zijn dan 0');
            }

            $this->db->query("
                SELECT 
                    vp.Id,
                    vp.PakketNummer,
                    vp.DatumSamenstelling,
                    vp.DatumUitgifte,
                    vp.Status,
                    COUNT(ppv.ProductId) as AantalProducten
                FROM voedselpakket vp
                LEFT JOIN productpervoedselpakket ppv ON vp.Id = ppv.VoedselpakketId AND ppv.IsActief = 1
                WHERE vp.GezinId = :gezinId AND vp.IsActief = 1
                GROUP BY vp.Id, vp.PakketNummer, vp.DatumSamenstelling, vp.DatumUitgifte, vp.Status
                ORDER BY vp.PakketNummer DESC
            ");

            $this->db->bind(':gezinId', $gezinId, PDO::PARAM_INT);
            return $this->db->resultSet();
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['gezinId' => $gezinId]);
            return false;
        }
    }

    /**
     * Haalt een specifiek voedselpakket op
     * 
     * @param int $voedselpakketId ID van het voedselpakket
     * @return object|false Voedselpakket object of false bij fout
     */
    public function getVoedselpakketById(int $voedselpakketId)
    {
        try {
            if ($voedselpakketId <= 0) {
                throw new InvalidArgumentException('Voedselpakket ID moet groter zijn dan 0');
            }

            $this->db->query("
                SELECT 
                    vp.*,
                    g.Naam as GezinNaam,
                    g.Code as GezinCode
                FROM voedselpakket vp
                INNER JOIN gezin g ON vp.GezinId = g.Id AND g.IsActief = 1
                WHERE vp.Id = :voedselpakketId AND vp.IsActief = 1
            ");

            $this->db->bind(':voedselpakketId', $voedselpakketId, PDO::PARAM_INT);
            return $this->db->single();
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['voedselpakketId' => $voedselpakketId]);
            return false;
        }
    }

    /**
     * Controleert of een gezin nog ingeschreven is
     * 
     * @param int $gezinId ID van het gezin
     * @return bool True als ingeschreven, false anders
     */
    public function isGezinIngeschreven(int $gezinId): bool
    {
        try {
            if ($gezinId <= 0) {
                throw new InvalidArgumentException('Gezin ID moet groter zijn dan 0');
            }

            $this->db->query("
                SELECT COUNT(*) as count
                FROM gezin g
                WHERE g.Id = :gezinId AND g.IsActief = 1
            ");

            $this->db->bind(':gezinId', $gezinId, PDO::PARAM_INT);
            $result = $this->db->single();

            return $result && $result->count > 0;
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['gezinId' => $gezinId]);
            return false;
        }
    }

    /**
     * Wijzigt de status van een voedselpakket
     * 
     * @param int $voedselpakketId ID van het voedselpakket
     * @param string $nieuweStatus Nieuwe status
     * @return bool Success status
     */
    public function wijzigVoedselpakketStatus(int $voedselpakketId, string $nieuweStatus): bool
    {
        try {
            // Valideer input
            if ($voedselpakketId <= 0) {
                throw new InvalidArgumentException('Voedselpakket ID moet groter zijn dan 0');
            }

            $geldige_statussen = ['NietUitgereikt', 'Uitgereikt', 'NietMeerIngeschreven'];
            if (!in_array($nieuweStatus, $geldige_statussen)) {
                throw new InvalidArgumentException('Ongeldige status');
            }

            // Haal voedselpakket op om gezin ID te krijgen
            $voedselpakket = $this->getVoedselpakketById($voedselpakketId);
            if (!$voedselpakket) {
                throw new Exception('Voedselpakket niet gevonden');
            }

            // Controleer of gezin nog ingeschreven is
            if (!$this->isGezinIngeschreven($voedselpakket->GezinId)) {
                throw new Exception('Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt');
            }

            // Start transactie
            $this->db->beginTransaction();

            // Update query
            $datumUitgifte = ($nieuweStatus === 'Uitgereikt') ? 'CURDATE()' : 'NULL';
            
            $this->db->query("
                UPDATE voedselpakket 
                SET Status = :status,
                    DatumUitgifte = {$datumUitgifte},
                    DatumGewijzigd = NOW(6)
                WHERE Id = :voedselpakketId AND IsActief = 1
            ");

            $this->db->bind(':status', $nieuweStatus);
            $this->db->bind(':voedselpakketId', $voedselpakketId, PDO::PARAM_INT);
            
            $result = $this->db->execute();

            if ($result) {
                $this->db->commit();
                $this->logInfo(__METHOD__, "Voedselpakket status gewijzigd naar {$nieuweStatus}", [
                    'voedselpakketId' => $voedselpakketId,
                    'nieuweStatus' => $nieuweStatus
                ]);
                return true;
            } else {
                $this->db->rollback();
                return false;
            }

        } catch (Exception $e) {
            $this->db->rollback();
            $this->logError(__METHOD__, $e->getMessage(), [
                'voedselpakketId' => $voedselpakketId,
                'nieuweStatus' => $nieuweStatus
            ]);
            throw $e; // Re-throw voor error handling in controller
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

    /**
     * Log een info bericht naar het logbestand
     * 
     * @param string $method Methode naam
     * @param string $message Info bericht
     * @param array $context Context data
     */
    private function logInfo(string $method, string $message, array $context = []): void
    {
        $logMessage = date('Y-m-d H:i:s') . " [INFO] {$method}: {$message}";
        if (!empty($context)) {
            $logMessage .= " | Context: " . json_encode($context);
        }
        
        // Zorg ervoor dat de logs directory exists
        $logDir = APPROOT . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        error_log($logMessage . PHP_EOL, 3, $logDir . '/info.log');
    }
}