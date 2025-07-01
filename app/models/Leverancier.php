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
}
