<?php
/**
 * Model voor voorraadbeheer
 * Verzorgt alle database interacties voor voorraadproducten
 * @author Bejan Afkar
 */
class VoorraadModel
{
    private $db;

    public function __construct()
    {
        // Database connectie
        $this->db = new Database();
    }

    /**
     * Haal alle voorraadproducten op met JOINs
     * @return array
     */
    public function getAllVoorraad()
    {
        try {
            $sql = "CALL spGetVoorraadOverzicht()";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            // Log technische fout
            error_log('Fout bij ophalen voorraad: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Haal voorraad op per categorie
     * @param int $categorieId
     * @return array
     */
    public function getVoorraadByCategorie($categorieId)
    {
        try {
            $sql = "CALL spGetVoorraadByCategorie(:categorieId)";
            $this->db->query($sql);
            $this->db->bind(':categorieId', $categorieId, PDO::PARAM_INT);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen voorraad per categorie: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Haal details van één product op
     * @param int $id
     * @return object|null
     */
    public function getProductById($id)
    {
        try {
            $sql = "CALL spGetProductById(:id)";
            $this->db->query($sql);
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            return $this->db->single();
        } catch (PDOException $e) {
            error_log('Fout bij ophalen product: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update voorraad van een product
     * @param int $id
     * @param int $aantal
     * @return bool
     */
    public function updateVoorraad($id, $aantal)
    {
        try {
            $sql = "CALL spUpdateVoorraad(:id, :aantal)";
            $this->db->query($sql);
            $this->db->bind(':id', $id, PDO::PARAM_INT);
            $this->db->bind(':aantal', $aantal, PDO::PARAM_INT);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log('Fout bij updaten voorraad: ' . $e->getMessage());
            return false;
        }
    }
}
