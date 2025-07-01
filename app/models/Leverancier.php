<?php

class Leverancier
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getLeveranciers($type = null)
    {
        if ($type) {
            $this->db->query("SELECT * FROM Leverancier WHERE LeverancierType = :type");
            $this->db->bind(':type', $type);
        } else {
            $this->db->query("SELECT * FROM Leverancier");
        }
        return $this->db->resultSet();
    }

    public function getLeverancierTypes()
    {
        $this->db->query("SELECT DISTINCT LeverancierType FROM Leverancier");
        return $this->db->resultSet();
    }

    public function getProductenPerLeverancier($leverancierNummer)
    {
        $this->db->query(
            "SELECT p.Id as ProductId, p.Naam, p.Houdbaarheidsdatum, ppl.LeverancierId, l.LeverancierNummer
             FROM Product p
             JOIN ProductPerLeverancier ppl ON ppl.ProductId = p.Id
             JOIN Leverancier l ON l.Id = ppl.LeverancierId
             WHERE l.LeverancierNummer = :levnr"
        );
        $this->db->bind(':levnr', $leverancierNummer);
        return $this->db->resultSet();
    }

    public function getProductById($productId)
    {
        $this->db->query("SELECT * FROM Product WHERE Id = :id");
        $this->db->bind(':id', $productId);
        return $this->db->single();
    }

    public function updateHoudbaarheidsdatum($productId, $nieuweDatum)
    {
        $this->db->query("UPDATE Product SET Houdbaarheidsdatum = :datum WHERE Id = :id");
        $this->db->bind(':datum', $nieuweDatum);
        $this->db->bind(':id', $productId);
        return $this->db->execute();
    }

    public function getLeverancierNummerByProductId($productId)
    {
        $this->db->query(
            "SELECT l.LeverancierNummer
             FROM ProductPerLeverancier ppl
             JOIN Leverancier l ON l.Id = ppl.LeverancierId
             WHERE ppl.ProductId = :productId
             LIMIT 1"
        );
        $this->db->bind(':productId', $productId);
        $result = $this->db->single();
        return $result ? $result->LeverancierNummer : null;
    }
}
