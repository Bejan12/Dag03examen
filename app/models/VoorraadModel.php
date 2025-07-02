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

    public function getMagazijnIdByProductId(int $productId): ?int
    {
        try {
            $sql = "SELECT pm.MagazijnId FROM productpermagazijn pm 
                    WHERE pm.ProductId = :productId AND pm.IsActief = 1 LIMIT 1";
            $this->db->query($sql);
            $this->db->bind(':productId', $productId, PDO::PARAM_INT);
            $row = $this->db->single();
            return $row ? (int)$row->MagazijnId : null;
        } catch (PDOException $e) {
            error_log('Fout bij ophalen magazijnId: ' . $e->getMessage());
            return null;
        }
    }

    public function updateProductDetailsAll(int $productId, string $magazijnLocatie, int $aantal, ?string $ontvangstdatum, ?string $uitleveringsdatum, ?string $barcode): bool
    {
        try {
            // Stap 1: Vind het juiste magazijnId via productId
            $this->db->query("SELECT pm.MagazijnId FROM productpermagazijn pm WHERE pm.ProductId = :productId AND pm.IsActief = 1 LIMIT 1");
            $this->db->bind(':productId', $productId);
            $row = $this->db->single();
            if ($row) {
                $magazijnId = $row->MagazijnId;
            } else {
                // Geen magazijn gevonden, stop met update
                return false;
            }

            // Stap 2: Update locatie in productpermagazijn
            $this->db->query("UPDATE productpermagazijn SET Locatie = :locatie WHERE ProductId = :productId AND MagazijnId = :magazijnId AND IsActief = 1");
            $this->db->bind(':locatie', $magazijnLocatie);
            $this->db->bind(':productId', $productId);
            $this->db->bind(':magazijnId', $magazijnId);
            $this->db->execute();

            // Stap 3: Update voorraad en uitleveringsdatum in magazijn
            $this->db->query("UPDATE magazijn SET Aantal = :aantal, Uitleveringsdatum = :uitleveringsdatum WHERE Id = :magazijnId AND IsActief = 1");
            $this->db->bind(':aantal', $aantal);
            $this->db->bind(':uitleveringsdatum', $uitleveringsdatum);
            $this->db->bind(':magazijnId', $magazijnId);
            $this->db->execute();

            // Stap 4: Update barcode indien aanwezig
            if ($barcode !== null) {
                $this->db->query("UPDATE product SET Barcode = :barcode WHERE Id = :productId");
                $this->db->bind(':barcode', $barcode);
                $this->db->bind(':productId', $productId);
                $this->db->execute();
            }

            return true;
        } catch (PDOException $e) {
            error_log("Fout bij updaten productdetails: " . $e->getMessage());
            return false;
        }
    }

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
            $this->db->bind(':aantal', $aantal);
            $this->db->bind(':productId', $productId);
            $this->db->bind(':magazijnId', $magazijnId);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log('Fout bij updaten voorraad: ' . $e->getMessage());
            return false;
        }
    }

    public function getProductFullDetails(int $id): ?object
    {
        try {
            $sql = "SELECT p.Id, p.Naam AS productnaam, c.Naam AS categorienaam, 
                           m.VerpakkingsEenheid AS eenheid, m.Aantal AS aantal, 
                           p.Houdbaarheidsdatum, pm.Locatie AS magazijn, 
                           p.Omschrijving, p.Status, p.Barcode, m.Ontvangstdatum, m.Uitleveringsdatum, m.Id AS magazijnId
                    FROM product p
                    JOIN categorie c ON p.CategorieId = c.Id
                    JOIN productpermagazijn pm ON p.Id = pm.ProductId
                    JOIN magazijn m ON pm.MagazijnId = m.Id
                    WHERE p.Id = :id 
                      AND p.IsActief = 1 
                      AND pm.IsActief = 1 
                      AND m.IsActief = 1
                    LIMIT 1";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen volledige productdetails: ' . $e->getMessage());
            return null;
        }
    }

    public function getAllVoorraadViaStoredProcedure(?int $categorieId = null): array
    {
        try {
            $sql = "CALL sp_getVoorraad(:categorieId)";
            $this->db->query($sql);
            $this->db->bind(':categorieId', $categorieId ?? null, $categorieId !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen via stored procedure: ' . $e->getMessage());
            return [];
        }
    }
}
