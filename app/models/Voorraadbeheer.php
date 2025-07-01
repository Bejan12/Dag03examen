<?php
/**
 * Model voor voorraadbeheer
 * Haalt alle voorraadproducten op uit de database
 * @author Bejan Afkar
 */
class VoorraadModel
    /**
     * Haal het magazijnId op bij een productId
     * @param int $productId
     * @return int|null
     */
    public function getMagazijnIdByProductId($productId)
    {
        try {
            $this->db->query('SELECT pm.MagazijnId FROM productpermagazijn pm WHERE pm.ProductId = :productId AND pm.IsActief = 1 LIMIT 1');
            $this->db->bind(':productId', $productId, PDO::PARAM_INT);
            $row = $this->db->single();
            return $row ? $row->MagazijnId : null;
        } catch (PDOException $e) {
            error_log('Fout bij ophalen magazijnId: ' . $e->getMessage());
            return null;
        }
    }
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Haal alle voorraadproducten op met alle benodigde info
     * @return array
     */
    public function getAllVoorraad($categorieId = null)
    {
        try {
            $sql = "SELECT p.Id, p.Naam AS productnaam, c.Naam AS categorienaam, m.VerpakkingsEenheid AS eenheid, m.Aantal AS aantal, p.Houdbaarheidsdatum, pm.Locatie AS magazijn
                    FROM product p
                    JOIN categorie c ON p.CategorieId = c.Id
                    JOIN productpermagazijn pm ON p.Id = pm.ProductId
                    JOIN magazijn m ON pm.MagazijnId = m.Id
                    WHERE p.IsActief = 1 AND pm.IsActief = 1 AND m.IsActief = 1";
            if ($categorieId) {
                $sql .= " AND c.Id = :categorieId";
            }
            $this->db->query($sql);
            if ($categorieId) {
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
    public function getProductDetails($id)
    {
        try {
            $sql = "SELECT p.Id, p.Naam AS productnaam, c.Naam AS categorienaam, m.VerpakkingsEenheid AS eenheid, m.Aantal AS aantal, p.Houdbaarheidsdatum, pm.Locatie AS magazijn, p.Omschrijving, p.Status
                    FROM product p
                    JOIN categorie c ON p.CategorieId = c.Id
                    JOIN productpermagazijn pm ON p.Id = pm.ProductId
                    JOIN magazijn m ON pm.MagazijnId = m.Id
                    WHERE p.Id = :id AND p.IsActief = 1 AND pm.IsActief = 1 AND m.IsActief = 1";
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
    public function getCategorieen()
    {
        try {
            $this->db->query('SELECT Id, Naam FROM categorie WHERE IsActief = 1');
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen categorieën: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Update het aantal uitgeleverde producten (voorraad)
     * @param int $productId
     * @param int $magazijnId
     * @param int $aantal
     * @return bool
     */
    public function updateVoorraad($productId, $magazijnId, $aantal)
    {
        try {
            $sql = "UPDATE magazijn m
                    JOIN productpermagazijn pm ON m.Id = pm.MagazijnId
                    SET m.Aantal = :aantal
                    WHERE pm.ProductId = :productId AND m.Id = :magazijnId AND m.IsActief = 1 AND pm.IsActief = 1";
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
    public function updateProductMagazijnEnAantal($productId, $magazijnLocatie, $aantal)
    {
        try {
            // Zoek magazijnId op basis van locatie, of maak aan als niet bestaat
            $this->db->query('SELECT Id FROM magazijn WHERE Locatie = :locatie AND IsActief = 1 LIMIT 1');
            $this->db->bind(':locatie', $magazijnLocatie, PDO::PARAM_STR);
            $magazijn = $this->db->single();
            if ($magazijn) {
                $magazijnId = $magazijn->Id;
            } else {
                // Magazijn bestaat niet, maak aan
                $this->db->query('INSERT INTO magazijn (Locatie, IsActief, Aantal, VerpakkingsEenheid) VALUES (:locatie, 1, 0, "stuks")');
                $this->db->bind(':locatie', $magazijnLocatie, PDO::PARAM_STR);
                $this->db->execute();
                $magazijnId = $this->db->lastInsertId();
            }
            // Update productpermagazijn
            $this->db->query('UPDATE productpermagazijn SET MagazijnId = :magazijnId WHERE ProductId = :productId AND IsActief = 1');
            $this->db->bind(':magazijnId', $magazijnId, PDO::PARAM_INT);
            $this->db->bind(':productId', $productId, PDO::PARAM_INT);
            $this->db->execute();
            // Update aantal in magazijn
            $this->db->query('UPDATE magazijn SET Aantal = :aantal WHERE Id = :magazijnId');
            $this->db->bind(':aantal', $aantal, PDO::PARAM_INT);
            $this->db->bind(':magazijnId', $magazijnId, PDO::PARAM_INT);
            $this->db->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Fout bij updaten product magazijn en aantal: " . $e->getMessage());
            return false;
        }
    }
}
