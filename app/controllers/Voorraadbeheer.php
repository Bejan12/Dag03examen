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
}
