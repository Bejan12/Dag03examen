<?php
/**
 * Controller voor voorraadbeheer
 * Beheert het tonen en wijzigen van producten in de voorraad
 * 
 * @author ZZakaria el bakkali
 */
class Voorraadbeheer extends BaseController
{
    // Model instantie voor voorraad gerelateerde database acties
    private $voorraadModel;

    /**
     * Constructor: initialiseer het voorraadmodel
     * Dit zorgt ervoor dat de controller toegang heeft tot de methodes
     * in het VoorraadModel om data uit de database te halen of bij te werken.
     */
    public function __construct()
    {
        // Laad het voorraadmodel zodat we voorraad data kunnen ophalen en bewerken
        $this->voorraadModel = $this->model('VoorraadModel');
    }

    /**
     * Toon overzicht van alle voorraadproducten, eventueel gefilterd op categorie
     * Wordt aangeroepen wanneer gebruiker voorraadbeheer pagina bezoekt
     * 
     * Hier wordt gebruik gemaakt van het VoorraadModel om de gegevens op te halen.
     * De filter op categorieId komt uit de URL-parameter (GET).
     */
    public function index()
    {
        // Haal categorieId op uit de GET-parameters, als die er is en niet leeg is
        $categorieId = isset($_GET['categorieId']) && $_GET['categorieId'] !== '' ? (int)$_GET['categorieId'] : null;

        // Vraag het voorraadmodel om alle voorraadproducten op te halen, gefilterd op categorie indien van toepassing
        // Het model maakt gebruik van een JOIN tussen product, categorie, productpermagazijn en magazijn om alle relevante data te combineren
        $voorraad = $this->voorraadModel->getAllVoorraad($categorieId);

        // Vraag ook alle beschikbare categorieën op uit de database, zodat we een filter dropdown kunnen tonen in de view
        $categorieen = $this->voorraadModel->getCategorieen();

        // Initieer feedbackbericht, standaard null (geen feedback)
        $feedback = null;

        // Als er een categorie is geselecteerd, maar er geen producten gevonden zijn,
        // geef dan een feedbackbericht dat er geen producten in die categorie zijn
        if (isset($_GET['categorieId']) && $_GET['categorieId'] !== "" && empty($voorraad)) {
            $feedback = 'Er zijn geen producten bekent die behoren bij de geselecteerde productcategorie';
        }

        // Zet alle benodigde data in een array om door te geven aan de view
        $data = [
            'title' => 'Overzicht Productvoorraad', // Titel van de pagina
            'voorraad' => $voorraad,                 // Gevonden voorraadproducten (array van objecten)
            'categorieen' => $categorieen,           // Categorieën voor filter dropdown (array van objecten)
            'feedback' => $feedback                   // Feedbackbericht (string of null)
        ];

        // Laad de view 'voorraadbeheer/index' en geef de data array mee
        // De view kan dan deze data gebruiken om pagina te renderen
        $this->view('voorraadbeheer/index', $data);
    }

    /**
     * Toon details van een specifiek product
     * 
     * @param int $id ID van het product dat getoond moet worden
     * 
     * Deze methode roept het model aan om detailinformatie over één product op te halen.
     * Let op: de model query bevat meerdere JOINs om product-, categorie-, magazijn- en voorraaddata te combineren.
     */
    public function details($id)
    {
        // Vraag het voorraadmodel om de details van het product op te halen via product ID
        $product = $this->voorraadModel->getProductDetails($id);

        // Bereid de data array voor de view voor
        $data = [
            'title' => 'Product Details', // Titel van de pagina
            'product' => $product          // Productdetails als object (of null als niet gevonden)
        ];

        // Laad de view 'voorraadbeheer/details' met de data
        $this->view('voorraadbeheer/details', $data);
    }

    /**
     * Wijzig de voorraad van een product
     * 
     * Deze methode toont het formulier en verwerkt de POST data om voorraad aan te passen.
     * 
     * @param int $id ID van het product dat aangepast moet worden
     * 
     * De voorraadwijziging update de 'Aantal' kolom in de 'magazijn' tabel via een JOIN op productpermagazijn.
     * Hierbij wordt gecontroleerd dat er niet meer uitgeleverd wordt dan aanwezig is.
     */
    public function wijzig($id)
    {
        // Haal eerst de huidige productdetails op uit het model, dit bevat ook voorraad info en locatie
        $product = $this->voorraadModel->getProductDetails($id);

        // Probeer magazijnId te achterhalen vanuit het product object (indien aanwezig)
        $magazijnId = null;
        if ($product && property_exists($product, 'magazijnId')) {
            // Gebruik magazijnId uit product indien beschikbaar
            $magazijnId = $product->magazijnId;
        } else {
            // Fallback: vraag magazijnId op via het model aan de hand van productId
            // Dit is een mogelijke uitbreiding die je in het model zou kunnen maken
            $magazijnId = $this->voorraadModel->getMagazijnIdByProductId($id);
        }

        // Check of het formulier is verzonden via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Haal gegevens op uit POST data
            $aantalUitgeleverd = isset($_POST['aantal_uitgeleverd']) ? (int)$_POST['aantal_uitgeleverd'] : null;
            $magazijnLocatie = isset($_POST['magazijn']) ? trim($_POST['magazijn']) : null;
            $uitleveringsdatum = isset($_POST['uitleveringsdatum']) ? $_POST['uitleveringsdatum'] : null;

            // Variabele om bij te houden of de update succesvol was
            $updateSuccess = false;

            // Huidige voorraad van het product (int), default 0 als niet aanwezig
            $huidigeVoorraad = isset($product->aantal) ? (int)$product->aantal : 0;

            // Validatie: controleer of aantal uitgeleverd niet meer is dan beschikbare voorraad
            if ($aantalUitgeleverd !== null && $aantalUitgeleverd > $huidigeVoorraad) {
                // Zet een sessie-foutmelding als er teveel wordt uitgeleverd
                $_SESSION['voorraad_error'] = 'Er worden meer producten uitgeleverd dan er in voorraad zijn';
            } else {
                // Bereken het nieuwe voorraadaantal
                $nieuwVoorraadAantal = $huidigeVoorraad;
                if ($aantalUitgeleverd !== null) {
                    $nieuwVoorraadAantal = $huidigeVoorraad - $aantalUitgeleverd;
                }

                // Update magazijn locatie en voorraad
                if ($magazijnLocatie) {
                    $updateSuccess = $this->voorraadModel->updateProductMagazijnEnAantal($id, $magazijnLocatie, $nieuwVoorraadAantal);
                }
            }

            // Afhandeling na update poging:
            if ($updateSuccess) {
                // Succesmelding in sessie
                $_SESSION['success'] = 'De productgegevens zijn gewijzigd.';
            } else if (!isset($_SESSION['voorraad_error'])) {
                // Algemene foutmelding in sessie als geen voorraad_error is gezet
                $_SESSION['error'] = 'Wijzigen mislukt.';
            }

            // Haal productdetails opnieuw op om gewijzigde data te tonen (bijvoorbeeld nieuwe voorraad)
            $product = $this->voorraadModel->getProductDetails($id);
        }

        // Voorbereiden data voor de view
        $data = [
            'title' => 'Wijzig Productvoorraad', // Pagina titel
            'product' => $product                 // Product data (mogelijk bijgewerkt)
        ];

        // Laad de wijzig view met de data
        $this->view('voorraadbeheer/wijzig', $data);
    }
}
/**
 * Deze controller beheert de voorraad van producten.
 * Het biedt functionaliteit om producten te bekijken, details te tonen en voorraad aan te passen.
 * 
 * @package Controllers
 */
