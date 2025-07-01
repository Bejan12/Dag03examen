<?php
/**
 * Controller voor voorraadbeheer
 * Toont een overzicht van alle voorraadproducten
 * @author Bejan Afkar
 */

class Voorraadbeheer extends BaseController
{
    private $voorraadModel;

    public function __construct()
    {
        // Laad het model voor voorraadbeheer
        $this->voorraadModel = $this->model('VoorraadModel');
    }

    /**
     * Toon overzicht van alle voorraadproducten
     */
    public function index()
    {
        // Optionele filter op categorieId via GET
        $categorieId = isset($_GET['categorieId']) && $_GET['categorieId'] !== '' ? (int)$_GET['categorieId'] : null;

        // Haal voorraad en categorieën op
        $voorraad = $this->voorraadModel->getAllVoorraad($categorieId);
        $categorieen = $this->voorraadModel->getCategorieen();

        $feedback = null;
        if ($categorieId !== null && empty($voorraad)) {
            $feedback = 'Er zijn geen producten bekend die behoren bij de geselecteerde productcategorie.';
        }

        $data = [
            'title' => 'Overzicht Productvoorraad',
            'voorraad' => $voorraad,
            'categorieen' => $categorieen,
            'feedback' => $feedback
        ];

        $this->view('voorraadbeheer/index', $data);
    }

    /**
     * Toon details van een product
     */
    public function details($id)
    {
        $product = $this->voorraadModel->getProductDetails((int)$id);

        if (!$product) {
            // Product niet gevonden, eventueel redirect of foutmelding tonen
            $_SESSION['error'] = 'Product niet gevonden.';
            header('Location: ' . URLROOT . '/voorraadbeheer');
            exit;
        }

        $data = [
            'title' => 'Product Details',
            'product' => $product
        ];

        $this->view('voorraadbeheer/details', $data);
    }

    /**
     * Wijzig voorraad van een product
     */
    public function wijzig($id)
    {
        $id = (int)$id;

        $product = $this->voorraadModel->getProductDetails($id);
        $magazijnen = $this->voorraadModel->getMagazijnLocaties();

        if (!$product) {
            $_SESSION['error'] = 'Product niet gevonden.';
            header('Location: ' . URLROOT . '/voorraadbeheer');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Filter en valideer input
            $aantalUitgeleverd = isset($_POST['aantal_uitgeleverd']) ? (int)$_POST['aantal_uitgeleverd'] : null;
            $magazijn = isset($_POST['magazijn']) ? trim($_POST['magazijn']) : null;
            $uitleveringsdatum = isset($_POST['uitleveringsdatum']) ? trim($_POST['uitleveringsdatum']) : null;

            $_SESSION['voorraad_error'] = null;
            $_SESSION['success'] = null;

            $huidigeVoorraad = isset($product->aantal) ? (int)$product->aantal : 0;

            if ($aantalUitgeleverd === null || $magazijn === null || $magazijn === '') {
                $_SESSION['voorraad_error'] = 'Alle velden zijn verplicht.';
            } elseif ($aantalUitgeleverd > $huidigeVoorraad) {
                $_SESSION['voorraad_error'] = 'Er worden meer producten uitgeleverd dan er in voorraad zijn.';
            } else {
                // Update de voorraad en magazijnlocatie
                $updateSuccess = $this->voorraadModel->updateProductMagazijnEnAantal($id, $magazijn, $aantalUitgeleverd);

                if ($updateSuccess) {
                    $_SESSION['success'] = 'De productgegevens zijn succesvol gewijzigd.';
                    // Product details opnieuw ophalen na update
                    $product = $this->voorraadModel->getProductDetails($id);
                } else {
                    $_SESSION['voorraad_error'] = 'Wijzigen mislukt, probeer het opnieuw.';
                }
            }
        }

        $data = [
            'title' => 'Wijzig Productvoorraad',
            'product' => $product,
            'magazijnen' => $magazijnen,
            'feedback' => $_SESSION['voorraad_error'] ?? null,
            'success' => $_SESSION['success'] ?? null
        ];

        // Zorg dat feedback en success na tonen verdwijnen uit sessie
        unset($_SESSION['voorraad_error'], $_SESSION['success']);

        $this->view('voorraadbeheer/wijzig', $data);
    }
}
