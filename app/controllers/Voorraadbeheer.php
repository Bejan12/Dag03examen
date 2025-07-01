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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $magazijnLocatie = isset($_POST['magazijn']) ? trim($_POST['magazijn']) : $product->magazijn;
            $aantalUitgeleverd = isset($_POST['aantal_uitgeleverd']) ? (int)$_POST['aantal_uitgeleverd'] : null;
            $uitleveringsdatum = isset($_POST['uitleveringsdatum']) ? $_POST['uitleveringsdatum'] : null;

            $magazijnId = $this->voorraadModel->getMagazijnIdByProductId($id);
            $updateSuccess = true;
            if ($magazijnId && $aantalUitgeleverd !== null) {
                $updateSuccess = $this->voorraadModel->updateVoorraad($id, $magazijnId, $aantalUitgeleverd);
            } else {
                $updateSuccess = false;
            }

            if ($updateSuccess) {
                $_SESSION['success'] = 'De productgegevens zijn gewijzigd.';
                // Geen exit en geen header, zodat de melding zichtbaar blijft op de wijzigpagina
            } else {
                $_SESSION['error'] = 'Wijzigen mislukt.';
            }
            // Haal opnieuw de productdetails op na wijziging
            $product = $this->voorraadModel->getProductDetails($id);
        }
        $data = [
            'title' => 'Wijzig Productvoorraad',
            'product' => $product
        ];
        $this->view('voorraadbeheer/wijzig', $data);
    }
}
