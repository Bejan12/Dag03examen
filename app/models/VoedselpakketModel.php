<?php

/**
 * VoedselpakketModel - Model voor het beheren van voedselpakketten
 * 
 * Deze model class beheert alle database operaties voor voedselpakketten:
 * - Ophalen van gezinnen met voedselpakketten
 * - Filteren van gezinnen op eetwens  
 * - Ophalen van voedselpakket details
 * - Wijzigen van voedselpakket status
 * - Validatie van wijzigingen (scenario 2)
 * 
 * @author Voedselbank Maaskantje
 * @version 1.0
 */
class VoedselpakketModel
{
    /**
     * @var Database $db Database connectie object
     */
    private $db;

    /**
     * Constructor - Initialiseert database verbinding
     * Wordt aangeroepen bij het maken van een model object
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Haalt alle gezinnen met voedselpakketten op
     * 
     * Deze methode haalt alle actieve gezinnen op inclusief:
     * - Gezin basis informatie (naam, omschrijving, samenstelling)
     * - Contact informatie (adres, email, telefoon)
     * - Vertegenwoordiger informatie
     * 
     * @return array|false Array met gezinnen of false bij fout
     */
    public function getAllGezinnenMetVoedselpakketten()
    {
        try {
            // SQL query om alle gezinnen met hun gegevens op te halen
            $this->db->query("
                SELECT 
                    g.Id,                                    -- Gezin ID voor links
                    g.Naam as GezinNaam,                     -- Gezinsnaam voor weergave
                    g.Code,                                  -- Gezin code
                    g.Omschrijving,                          -- Gezin omschrijving
                    g.AantalVolwassenen,                     -- Aantal volwassenen in gezin
                    g.AantalKinderen,                        -- Aantal kinderen in gezin
                    g.AantalBabys,                           -- Aantal baby's in gezin
                    g.TotaalAantalPersonen,                  -- Totaal aantal personen
                    -- Bouw volledig adres op uit contact gegevens
                    CONCAT(c.Straat, ' ', c.Huisnummer, IFNULL(CONCAT(' ', c.Toevoeging), '')) as Adres,
                    c.Postcode,                              -- Postcode
                    c.Woonplaats,                            -- Woonplaats
                    c.Email,                                 -- Email adres
                    c.Mobiel,                                -- Mobiel nummer
                    -- Bouw volledige naam van vertegenwoordiger
                    CONCAT(pv.Voornaam, ' ', IFNULL(CONCAT(pv.Tussenvoegsel, ' '), ''), pv.Achternaam) as Vertegenwoordiger
                FROM gezin g
                -- LEFT JOIN voor contact gegevens (kan leeg zijn)
                LEFT JOIN contactpergezin cpg ON g.Id = cpg.GezinId AND cpg.IsActief = 1
                LEFT JOIN contact c ON cpg.ContactId = c.Id AND c.IsActief = 1
                -- LEFT JOIN voor vertegenwoordiger (kan leeg zijn)
                LEFT JOIN persoon pv ON g.Id = pv.GezinId AND pv.IsVertegenwoordiger = 1 AND pv.IsActief = 1
                WHERE g.IsActief = 1                         -- Alleen actieve gezinnen
                ORDER BY g.Naam                             -- Sorteer op gezinsnaam
            ");

            // Voer query uit en return resultaat
            return $this->db->resultSet();
            
        } catch (Exception $e) {
            // Log error en return false
            $this->logError(__METHOD__, $e->getMessage(), []);
            return false;
        }
    }

    /**
     * Haalt alle eetwensen op voor dropdown filter
     * 
     * Deze methode haalt alle actieve eetwensen op die gebruikt worden
     * in de filter dropdown op de hoofdpagina
     * 
     * @return array|false Array met eetwensen of false bij fout
     */
    public function getAllEetwensen()
    {
        try {
            // SQL query voor alle actieve eetwensen
            $this->db->query("
                SELECT DISTINCT 
                    e.Id,                                    -- Eetwens ID voor filter
                    e.Naam as EetwensNaam,                   -- Naam voor dropdown
                    e.Omschrijving                           -- Omschrijving
                FROM eetwens e
                WHERE e.IsActief = 1                         -- Alleen actieve eetwensen
                ORDER BY e.Naam                             -- Sorteer alfabetisch
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
     * Deze methode filtert gezinnen op basis van een specifieke eetwens.
     * Wordt gebruikt wanneer gebruiker een eetwens selecteert in dropdown.
     * 
     * @param int $eetwensId ID van de eetwens om op te filteren
     * @return array|false Array met gefilterde gezinnen of false bij fout
     */
    public function getGezinnenByEetwens(int $eetwensId)
    {
        try {
            // Valideer input parameter
            if ($eetwensId <= 0) {
                throw new InvalidArgumentException('Eetwens ID moet groter zijn dan 0');
            }

            // SQL query vergelijkbaar met getAllGezinnen maar met eetwens filter
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
                -- INNER JOIN voor eetwens filtering (moet bestaan)
                INNER JOIN eetwenspergezin epg ON g.Id = epg.GezinId AND epg.IsActief = 1
                WHERE g.IsActief = 1 AND epg.EetwensId = :eetwensId  -- Filter op eetwens
                ORDER BY g.Naam
            ");

            // Bind parameter om SQL injection te voorkomen
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
     * Deze methode haalt alle informatie op van een gezin voor weergave
     * op de details pagina
     * 
     * @param int $gezinId ID van het gezin
     * @return object|false Gezin object of false bij fout
     */
    public function getGezinDetails(int $gezinId)
    {
        try {
            // Valideer input parameter
            if ($gezinId <= 0) {
                throw new InvalidArgumentException('Gezin ID moet groter zijn dan 0');
            }

            // SQL query voor specifiek gezin
            $this->db->query("
                SELECT 
                    g.Id,
                    g.Naam,                                  -- Gezinsnaam
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
                WHERE g.Id = :gezinId AND g.IsActief = 1    -- Specifiek gezin
            ");

            $this->db->bind(':gezinId', $gezinId, PDO::PARAM_INT);
            return $this->db->single();  // Gebruik single() voor één record
            
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['gezinId' => $gezinId]);
            return false;
        }
    }

    /**
     * Haalt alle voedselpakketten op voor een specifiek gezin
     * 
     * Deze methode haalt alle voedselpakketten op die behoren bij een gezin
     * inclusief het aantal producten per pakket
     * 
     * @param int $gezinId ID van het gezin
     * @return array|false Array met voedselpakketten of false bij fout
     */
    public function getVoedselpakkettenByGezin(int $gezinId)
    {
        try {
            // Valideer input parameter
            if ($gezinId <= 0) {
                throw new InvalidArgumentException('Gezin ID moet groter zijn dan 0');
            }

            // SQL query voor voedselpakketten van een gezin
            $this->db->query("
                SELECT 
                    vp.Id,                                   -- Voedselpakket ID
                    vp.PakketNummer,                         -- Pakketnummer voor weergave
                    vp.DatumSamenstelling,                   -- Wanneer pakket samengesteld
                    vp.DatumUitgifte,                        -- Wanneer pakket uitgegeven
                    vp.Status,                               -- Status van pakket
                    vp.GezinId,                              -- Gezin ID voor links
                    -- Tel aantal producten in dit pakket
                    COUNT(ppv.ProductId) as AantalProducten
                FROM voedselpakket vp
                -- LEFT JOIN voor producten (pakket kan leeg zijn)
                LEFT JOIN productpervoedselpakket ppv ON vp.Id = ppv.VoedselpakketId AND ppv.IsActief = 1
                WHERE vp.GezinId = :gezinId AND vp.IsActief = 1  -- Filter op gezin
                GROUP BY vp.Id, vp.PakketNummer, vp.DatumSamenstelling, vp.DatumUitgifte, vp.Status, vp.GezinId
                ORDER BY vp.PakketNummer DESC               -- Nieuwste pakket eerst
            ");

            $this->db->bind(':gezinId', $gezinId, PDO::PARAM_INT);
            return $this->db->resultSet();
            
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['gezinId' => $gezinId]);
            return false;
        }
    }

    /**
     * Haalt een specifiek voedselpakket op basis van ID
     * 
     * Deze methode wordt gebruikt om een voedselpakket op te halen
     * voor wijzigingen of detailweergave
     * 
     * @param int $voedselpakketId ID van het voedselpakket
     * @return object|false Voedselpakket object of false bij fout
     */
    public function getVoedselpakketById(int $voedselpakketId)
    {
        try {
            // Valideer input parameter
            if ($voedselpakketId <= 0) {
                throw new InvalidArgumentException('Voedselpakket ID moet groter zijn dan 0');
            }

            // SQL query voor specifiek voedselpakket inclusief gezin info
            $this->db->query("
                SELECT 
                    vp.*,                                    -- Alle voedselpakket velden
                    g.Naam as GezinNaam,                     -- Gezinsnaam voor weergave
                    g.Code as GezinCode                      -- Gezin code
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
     * Deze methode controleert of een gezin nog actief is
     * in het systeem (IsActief = 1)
     * 
     * @param int $gezinId ID van het gezin
     * @return bool True als ingeschreven, false anders
     */
    public function isGezinIngeschreven(int $gezinId): bool
    {
        try {
            // Valideer input parameter
            if ($gezinId <= 0) {
                throw new InvalidArgumentException('Gezin ID moet groter zijn dan 0');
            }

            // SQL query om gezin status te controleren
            $this->db->query("
                SELECT IsActief 
                FROM gezin 
                WHERE Id = :gezinId
            ");

            $this->db->bind(':gezinId', $gezinId, PDO::PARAM_INT);
            $result = $this->db->single();

            // Return true als gezin bestaat en actief is
            return $result && (bool)$result->IsActief;
            
        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['gezinId' => $gezinId]);
            return false;
        }
    }

    /**
     * Controleert of een voedselpakket gewijzigd mag worden (specifiek voor scenario 2)
     * 
     * Deze methode implementeert de business logic voor scenario 2:
     * - Pakketnummer 3 van ZevenhuizenGezin mag niet gewijzigd worden
     * - Pakketten van niet-ingeschreven gezinnen mogen niet gewijzigd worden
     * 
     * @param int $voedselpakketId ID van het voedselpakket
     * @return bool True als wijziging toegestaan, false anders
     */
    public function magVoedselpakketGewijzigdWorden(int $voedselpakketId): bool
    {
        try {
            // Valideer input parameter
            if ($voedselpakketId <= 0) {
                throw new InvalidArgumentException('Voedselpakket ID moet groter zijn dan 0');
            }

            // Haal voedselpakket info op met gezin gegevens
            $this->db->query("
                SELECT vp.PakketNummer, g.Naam as GezinNaam, g.IsActief
                FROM voedselpakket vp
                INNER JOIN gezin g ON vp.GezinId = g.Id
                WHERE vp.Id = :voedselpakketId AND vp.IsActief = 1
            ");

            $this->db->bind(':voedselpakketId', $voedselpakketId, PDO::PARAM_INT);
            $result = $this->db->single();

            // Als geen resultaat, wijziging niet toegestaan
            if (!$result) {
                return false;
            }

            // SCENARIO 2: Specifieke regel voor pakketnummer 3 van ZevenhuizenGezin
            if ($result->PakketNummer == 3 && $result->GezinNaam == 'ZevenhuizenGezin') {
                return false;  // Mag niet gewijzigd worden
            }

            // Anders check of gezin nog actief is
            return (bool)$result->IsActief;

        } catch (Exception $e) {
            $this->logError(__METHOD__, $e->getMessage(), ['voedselpakketId' => $voedselpakketId]);
            return false;
        }
    }

    /**
     * Wijzigt de status van een voedselpakket
     * 
     * Deze methode wijzigt de status van een voedselpakket en:
     * - Zet DatumUitgifte bij status 'Uitgereikt'
     * - Controleert of wijziging toegestaan is
     * - Update DatumGewijzigd timestamp
     * 
     * @param int $voedselpakketId ID van het voedselpakket
     * @param string $nieuweStatus Nieuwe status ('NietUitgereikt' of 'Uitgereikt')
     * @return bool True bij succes, false bij fout
     * @throws Exception Bij validatie of database fouten
     */
    public function wijzigVoedselpakketStatus(int $voedselpakketId, string $nieuweStatus): bool
    {
        try {
            // Valideer input parameters
            if ($voedselpakketId <= 0) {
                throw new InvalidArgumentException('Voedselpakket ID moet groter zijn dan 0');
            }

            if (!in_array($nieuweStatus, ['NietUitgereikt', 'Uitgereikt'])) {
                throw new InvalidArgumentException('Ongeldige status: ' . $nieuweStatus);
            }

            // Haal voedselpakket op om te controleren
            $voedselpakket = $this->getVoedselpakketById($voedselpakketId);
            if (!$voedselpakket) {
                throw new Exception('Voedselpakket niet gevonden');
            }

            // Controleer of wijziging toegestaan is
            if (!$this->magVoedselpakketGewijzigdWorden($voedselpakketId)) {
                throw new Exception('Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt');
            }

            // Bepaal DatumUitgifte waarde
            $datumUitgifte = ($nieuweStatus === 'Uitgereikt') ? 'CURDATE()' : 'NULL';
            
            // SQL query om status te wijzigen
            $this->db->query("
                UPDATE voedselpakket 
                SET Status = :status,
                    DatumUitgifte = {$datumUitgifte},        -- Zet datum als uitgereikt
                    DatumGewijzigd = NOW(6)                  -- Update timestamp
                WHERE Id = :voedselpakketId AND IsActief = 1
            ");

            // Bind parameters
            $this->db->bind(':status', $nieuweStatus);
            $this->db->bind(':voedselpakketId', $voedselpakketId, PDO::PARAM_INT);
            
            // Voer update uit
            $result = $this->db->execute();

            // Log success als update succesvol
            if ($result) {
                $this->logInfo(__METHOD__, "Voedselpakket status gewijzigd naar {$nieuweStatus}", [
                    'voedselpakketId' => $voedselpakketId,
                    'nieuweStatus' => $nieuweStatus
                ]);
            }

            return $result;

        } catch (Exception $e) {
            // Log error en gooi exception door
            $this->logError(__METHOD__, $e->getMessage(), [
                'voedselpakketId' => $voedselpakketId,
                'nieuweStatus' => $nieuweStatus
            ]);
            throw $e;
        }
    }

    // ==================== LOGGING METHODS ====================

    /**
     * Log een error naar het logbestand
     * 
     * Deze methode logt errors naar een logbestand voor debugging
     * 
     * @param string $method Methode naam waar error optrad
     * @param string $message Error bericht
     * @param array $context Context data (parameters, etc.)
     */
    private function logError(string $method, string $message, array $context = []): void
    {
        // Bouw log bericht op
        $logMessage = date('Y-m-d H:i:s') . " [ERROR] {$method}: {$message}";
        if (!empty($context)) {
            $logMessage .= " | Context: " . json_encode($context);
        }
        
        // Zorg ervoor dat de logs directory bestaat
        $logDir = APPROOT . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        // Schrijf naar error logbestand
        error_log($logMessage . PHP_EOL, 3, $logDir . '/errors.log');
    }

    /**
     * Log een info bericht naar het logbestand
     * 
     * Deze methode logt informatie berichten voor monitoring
     * 
     * @param string $method Methode naam
     * @param string $message Info bericht
     * @param array $context Context data
     */
    private function logInfo(string $method, string $message, array $context = []): void
    {
        // Bouw log bericht op
        $logMessage = date('Y-m-d H:i:s') . " [INFO] {$method}: {$message}";
        if (!empty($context)) {
            $logMessage .= " | Context: " . json_encode($context);
        }
        
        // Zorg ervoor dat de logs directory bestaat
        $logDir = APPROOT . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        // Schrijf naar info logbestand
        error_log($logMessage . PHP_EOL, 3, $logDir . '/info.log');
    }
}