<?php
/**
 * Model voor voorraadbeheer
 * Haalt voorraadproducten, categorieën en magazijnen op uit de database
 * @author Bejan Afkar
 */
class VoorraadModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Haal alle voorraadproducten op met alle benodigde info
     * @param int|null $categorieId
     * @return array
     */
    public function getAllVoorraad(?int $categorieId = null): array
    {
        try {
            $sql = "SELECT p.Id, p.Naam AS productnaam, c.Naam AS categorienaam, 
                           m.VerpakkingsEenheid AS eenheid, m.Aantal AS aantal, 
                           p.Houdbaarheidsdatum, pm.Locatie AS magazijn
                    FROM product p
                    JOIN categorie c ON p.CategorieId = c.Id
                    JOIN productpermagazijn pm ON p.Id = pm.ProductId
                    JOIN magazijn m ON pm.MagazijnId = m.Id
                    WHERE p.IsActief = 1 
                      AND pm.IsActief = 1 
                      AND m.IsActief = 1";

            if ($categorieId !== null) {
                $sql .= " AND c.Id = :categorieId";
            }

            $sql .= " ORDER BY p.Naam ASC";

            $this->db->query($sql);

            if ($categorieId !== null) {
                $this->db->bind(':categorieId', $categorieId, PDO::PARAM_INT);
            }

            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen voorraad: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Haal details van één product op
     * @param int $id
     * @return object|null
     */
    public function getProductDetails(int $id): ?object
    {
        try {
            $sql = "SELECT p.Id, p.Naam AS productnaam, c.Naam AS categorienaam, 
                           m.VerpakkingsEenheid AS eenheid, m.Aantal AS aantal, 
                           p.Houdbaarheidsdatum, pm.Locatie AS magazijn, 
                           p.Omschrijving, p.Status
                    FROM product p
                    JOIN categorie c ON p.CategorieId = c.Id
                    JOIN productpermagazijn pm ON p.Id = pm.ProductId
                    JOIN magazijn m ON pm.MagazijnId = m.Id
                    WHERE p.Id = :id 
                      AND p.IsActief = 1 
                      AND pm.IsActief = 1 
                      AND m.IsActief = 1";
            $this->db->query($sql);
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            return $this->db->single();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen productdetails: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Haal alle categorieën op
     * @return array
     */
    public function getCategorieen(): array
    {
        try {
            $sql = "SELECT Id, Naam FROM categorie WHERE IsActief = 1 ORDER BY Naam ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen categorieën: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Haal alle magazijnlocaties op
     * @return array
     */
    public function getMagazijnLocaties(): array
    {
        try {
            $sql = "SELECT Id, Locatie FROM magazijn WHERE IsActief = 1 ORDER BY Locatie ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen magazijnlocaties: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Haal het magazijnId op bij een productId
     * @param int $productId
     * @return int|null
     */
    public function getMagazijnIdByProductId(int $productId): ?int
    {
        try {
            $sql = "SELECT pm.MagazijnId FROM productpermagazijn pm WHERE pm.ProductId = :productId AND pm.IsActief = 1 LIMIT 1";
            $this->db->query($sql);
            $this->db->bind(':productId', $productId, PDO::PARAM_INT);
            $row = $this->db->single();
            return $row ? (int)$row->MagazijnId : null;
        } catch (PDOException $e) {
            error_log('Fout bij ophalen magazijnId: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update het aantal uitgeleverde producten (voorraad)
     * @param int $productId
     * @param int $magazijnId
     * @param int $aantal
     * @return bool
     */
    public function updateVoorraad(int $productId, int $magazijnId, int $aantal): bool
    {
        try {
            $sql = "UPDATE magazijn m
                    JOIN productpermagazijn pm ON m.Id = pm.MagazijnId
                    SET m.Aantal = :aantal
                    WHERE pm.ProductId = :productId
                      AND m.Id = :magazijnId
                      AND m.IsActief = 1
                      AND pm.IsActief = 1";
            $this->db->query($sql);
            $this->db->bind(':aantal', $aantal, PDO::PARAM_INT);
            $this->db->bind(':productId', $productId, PDO::PARAM_INT);
            $this->db->bind(':magazijnId', $magazijnId, PDO::PARAM_INT);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log('Fout bij updaten voorraad: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update magazijn locatie en aantal uitgeleverde producten voor een product
     * @param int $productId
     * @param string $magazijnLocatie
     * @param int $aantal
     * @return bool
     */
    public function updateProductMagazijnEnAantal(int $productId, string $magazijnLocatie, int $aantal): bool
    {
        try {
            // Zoek magazijnId op basis van locatie, of maak aan als niet bestaat
            $this->db->query("SELECT Id FROM magazijn WHERE Locatie = :locatie AND IsActief = 1 LIMIT 1");
            $this->db->bind(':locatie', $magazijnLocatie, PDO::PARAM_STR);
            $magazijn = $this->db->single();

            if ($magazijn) {
                $magazijnId = $magazijn->Id;
            } else {
                // Magazijn bestaat niet, maak aan
                $this->db->query("INSERT INTO magazijn (Locatie, IsActief, Aantal, VerpakkingsEenheid) VALUES (:locatie, 1, 0, 'stuks')");
                $this->db->bind(':locatie', $magazijnLocatie, PDO::PARAM_STR);
                $this->db->execute();
                $magazijnId = $this->db->lastInsertId();
            }

            // Update productpermagazijn
            $this->db->query("UPDATE productpermagazijn SET MagazijnId = :magazijnId WHERE ProductId = :productId AND IsActief = 1");
            $this->db->bind(':magazijnId', $magazijnId, PDO::PARAM_INT);
            $this->db->bind(':productId', $productId, PDO::PARAM_INT);
            $this->db->execute();

            // Update aantal in magazijn
            $this->db->query("UPDATE magazijn SET Aantal = :aantal WHERE Id = :magazijnId");
            $this->db->bind(':aantal', $aantal, PDO::PARAM_INT);
            $this->db->bind(':magazijnId', $magazijnId, PDO::PARAM_INT);
            $this->db->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Fout bij updaten product magazijn en aantal: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Voorbeeld: Haal voorraadproducten op via stored procedure
     * @param int|null $categorieId
     * @return array
     */
    public function getAllVoorraadViaStoredProcedure(?int $categorieId = null): array
    {
        try {
            // Stored procedure aanroepen, bijvoorbeeld 'sp_getVoorraad' met 1 parameter
            $sql = "CALL sp_getVoorraad(:categorieId)";
            $this->db->query($sql);
            
            // Bind parameter of bind null als geen categorieId is meegegeven
            if ($categorieId !== null) {
                $this->db->bind(':categorieId', $categorieId, PDO::PARAM_INT);
            } else {
                $this->db->bind(':categorieId', null, PDO::PARAM_NULL);
            }

            // Resultaat ophalen
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen voorraad via stored procedure: ' . $e->getMessage());
            return [];
        }
    }
}