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
        $this->voorraadModel = $this->model('VoorraadModel');
    }

    /**
     * Toon overzicht van alle voorraadproducten
     */
    public function index()
    {
        $categorieId = isset($_GET['categorieId']) && $_GET['categorieId'] !== '' ? (int)$_GET['categorieId'] : null;
        $voorraad = $this->voorraadModel->getAllVoorraad($categorieId);
        $categorieen = $this->voorraadModel->getCategorieen();
        $feedback = null;
        if (isset($_GET['categorieId']) && $_GET['categorieId'] !== "" && empty($voorraad)) {
            $feedback = 'Er zijn geen producten bekent die behoren bij de geselecteerde productcategorie';
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
        $product = $this->voorraadModel->getProductDetails($id);
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
        $product = $this->voorraadModel->getProductDetails($id);

        // Haal alle magazijnlocaties op
        $magazijnen = $this->voorraadModel->getMagazijnLocaties();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aantalUitgeleverd = isset($_POST['aantal_uitgeleverd']) ? (int)$_POST['aantal_uitgeleverd'] : null;
            $magazijn = isset($_POST['magazijn']) ? $_POST['magazijn'] : null;
            $uitleveringsdatum = isset($_POST['uitleveringsdatum']) ? $_POST['uitleveringsdatum'] : null;

            $updateSuccess = false;

            $huidigeVoorraad = isset($product->aantal) ? (int)$product->aantal : 0;

            if ($aantalUitgeleverd !== null && $magazijn !== null) {
                if ($aantalUitgeleverd > $huidigeVoorraad) {
                    $_SESSION['voorraad_error'] = 'Er worden meer producten uitgeleverd dan er in voorraad zijn';
                } else {
                    // Update voorraad met nieuw magazijn en uitleveringsdatum
                    $updateSuccess = $this->voorraadModel->updateVoorraadMetMagazijn($id, $magazijn, $aantalUitgeleverd, $uitleveringsdatum);
                }
            }

            if ($updateSuccess) {
                $_SESSION['success'] = 'De productgegevens zijn gewijzigd.';
            } else if (!isset($_SESSION['voorraad_error'])) {
                $_SESSION['error'] = 'Wijzigen mislukt.';
            }

            // Haal opnieuw de productdetails op na wijziging
            $product = $this->voorraadModel->getProductDetails($id);
        }

        $data = [
            'title' => 'Wijzig Productvoorraad',
            'product' => $product,
            'magazijnen' => $magazijnen
        ];

        $this->view('voorraadbeheer/wijzig', $data);
    }
}
