<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Login user
    public function login($email, $password)
    {
        $this->db->query('SELECT 
            g.Id,
            g.InlogNaam,
            g.Gebruikersnaam,
            g.Wachtwoord,
            r.Naam as RolNaam
        FROM Gebruiker g
        LEFT JOIN RolPerGebruiker rpg ON g.Id = rpg.GebruikerId AND rpg.IsActief = 1
        LEFT JOIN Rol r ON rpg.RolId = r.Id AND r.IsActief = 1
        WHERE g.Gebruikersnaam = :email AND g.IsActief = 1');

        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($row) {
            $hashed_password = $row->Wachtwoord;
            
            // First try bcrypt verification (preferred method)
            if (password_verify($password, $hashed_password)) {
                return $row;
            } 
            // Fallback: check if password matches plain text (temporary for testing)
            else if ($password === $hashed_password) {
                return $row;
            } 
            else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM Gebruiker WHERE Gebruikersnaam = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Get user by id
    public function getUserById($id)
    {
        $this->db->query('SELECT 
            g.Id,
            g.InlogNaam,
            g.Gebruikersnaam,
            r.Naam as RolNaam
        FROM Gebruiker g
        LEFT JOIN RolPerGebruiker rpg ON g.Id = rpg.GebruikerId AND rpg.IsActief = 1
        LEFT JOIN Rol r ON rpg.RolId = r.Id AND r.IsActief = 1
        WHERE g.Id = :id AND g.IsActief = 1');

        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }
}
