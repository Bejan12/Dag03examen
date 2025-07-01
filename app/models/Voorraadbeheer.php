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
    public function getAllVoorraad()
    {
        try {
            $sql = "SELECT p.Id, p.Naam AS productnaam, c.Naam AS categorienaam, m.VerpakkingsEenheid AS eenheid, m.Aantal AS aantal, p.Houdbaarheidsdatum, pm.Locatie AS magazijn
                    FROM product p
                    JOIN categorie c ON p.CategorieId = c.Id
                    JOIN productpermagazijn pm ON p.Id = pm.ProductId
                    JOIN magazijn m ON pm.MagazijnId = m.Id
                    WHERE p.IsActief = 1 AND pm.IsActief = 1 AND m.IsActief = 1";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen voorraad: ' . $e->getMessage());
            return [];
        }
    }
}
