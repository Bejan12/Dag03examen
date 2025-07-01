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
     * Haal alle voorraadproducten op
     * @return array
     */
    public function getAllVoorraad()
    {
        try {
            $this->db->query('SELECT v.id, v.productnaam, c.naam AS categorienaam, v.voorraad FROM voorraad v JOIN categorie c ON v.categorie_id = c.id');
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen voorraad: ' . $e->getMessage());
            return [];
        }
    }
}
