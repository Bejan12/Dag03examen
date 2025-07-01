<?php
/**
 * Model voor voorraadbeheer
 * Haalt alle voorraadproducten op uit de database
 * @author Bejan Afkar
 */
class VoorraadModel
{
    /**
     * @var Database $db Database connectie object
     */
    private $db;

    /**
     * Constructor
     * Initialiseer de Database klasse voor gebruik in dit model
     */
    public function __construct()
    {
        // Maak een nieuwe database verbinding aan
        $this->db = new Database();
    }

    /**
     * Haal alle voorraadproducten op met alle benodigde informatie
     * Optioneel filteren op categorieId
     * 
     * @param int|null $categorieId Optioneel ID van categorie om te filteren
     * @return array Resultaatset van voorraadproducten
     */
    public function getAllVoorraad($categorieId = null)
    {
        try {
            // Basis SQL query om producten met categorie, magazijn info op te halen
            $sql = "SELECT p.Id, p.Naam AS productnaam, c.Naam AS categorienaam, 
                           m.VerpakkingsEenheid AS eenheid, m.Aantal AS aantal, 
                           p.Houdbaarheidsdatum, pm.Locatie AS magazijn
                    FROM product p
                    JOIN categorie c ON p.CategorieId = c.Id
                    JOIN productpermagazijn pm ON p.Id = pm.ProductId
                    JOIN magazijn m ON pm.MagazijnId = m.Id
                    WHERE p.IsActief = 1 AND pm.IsActief = 1 AND m.IsActief = 1";

            // Voeg filter toe indien categorieId meegegeven is
            if ($categorieId) {
                $sql .= " AND c.Id = :categorieId";
            }

            // Bereid query voor
            $this->db->query($sql);

            // Bind parameter categorieId als deze is meegegeven
            if ($categorieId) {
                $this->db->bind(':categorieId', $categorieId, PDO::PARAM_INT);
            }

            // Voer query uit en geef resultaat als array terug
            return $this->db->resultSet();

        } catch (PDOException $e) {
            // Log eventuele fouten in errorlog en geef lege array terug
            error_log('Fout bij ophalen voorraad: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Haal details op van één product op basis van product ID
     * 
     * @param int $id ID van het product
     * @return object|null Product details object of null bij fout
     */
    public function getProductDetails($id)
    {
        try {
            // SQL query om productdetails inclusief categorie, magazijn en omschrijving op te halen
            $sql = "SELECT p.Id, p.Naam AS productnaam, c.Naam AS categorienaam, 
                           m.VerpakkingsEenheid AS eenheid, m.Aantal AS aantal, 
                           p.Houdbaarheidsdatum, pm.Locatie AS magazijn, 
                           p.Omschrijving, p.Status
                    FROM product p
                    JOIN categorie c ON p.CategorieId = c.Id
                    JOIN productpermagazijn pm ON p.Id = pm.ProductId
                    JOIN magazijn m ON pm.MagazijnId = m.Id
                    WHERE p.Id = :id AND p.IsActief = 1 AND pm.IsActief = 1 AND m.IsActief = 1";

            // Bereid de query voor
            $this->db->query($sql);

            // Bind de parameter :id aan het product ID
            $this->db->bind(':id', $id, PDO::PARAM_INT);

            // Voer de query uit en retourneer één resultaat als object
            return $this->db->single();

        } catch (PDOException $e) {
            // Log eventuele fouten en geef null terug
            error_log('Fout bij ophalen productdetails: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Haal alle actieve categorieën op
     * 
     * @return array Lijst met categorieën als array
     */
    public function getCategorieen()
    {
        try {
            // Selecteer alle actieve categorieën uit de database
            $this->db->query('SELECT Id, Naam FROM categorie WHERE IsActief = 1');

            // Voer de query uit en retourneer het resultaat als array
            return $this->db->resultSet();

        } catch (PDOException $e) {
            // Log eventuele fouten en geef lege array terug
            error_log('Fout bij ophalen categorieën: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Update het aantal uitgeleverde producten in het magazijn
     * 
     * @param int $productId ID van het product dat geüpdatet wordt
     * @param int $magazijnId ID van het magazijn waar voorraad wordt aangepast
     * @param int $aantal Het nieuwe aantal in voorraad
     * @return bool True als update gelukt is, false bij een fout
     */
    public function updateVoorraad($productId, $magazijnId, $aantal)
    {
        try {
            // Update query om het aantal voorraad te wijzigen in magazijn
            $sql = "UPDATE magazijn m
                    JOIN productpermagazijn pm ON m.Id = pm.MagazijnId
                    SET m.Aantal = :aantal
                    WHERE pm.ProductId = :productId AND m.Id = :magazijnId AND m.IsActief = 1 AND pm.IsActief = 1";

            // Bereid de query voor
            $this->db->query($sql);

            // Bind de parameters met juiste types
            $this->db->bind(':aantal', $aantal, PDO::PARAM_INT);
            $this->db->bind(':productId', $productId, PDO::PARAM_INT);
            $this->db->bind(':magazijnId', $magazijnId, PDO::PARAM_INT);

            // Voer de update uit en retourneer resultaat (true/false)
            return $this->db->execute();

        } catch (PDOException $e) {
            // Log fouten en geef false terug bij een mislukte update
            error_log('Fout bij updaten voorraad: ' . $e->getMessage());
            return false;
        }
    }
}