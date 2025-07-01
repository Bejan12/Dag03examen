<?php
/**
 * Model voor voorraadbeheer
 * Haalt alle voorraadproducten op uit de database
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
}
