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
        $data = [
            'title' => 'Overzicht Productvoorraad',
            'voorraad' => $voorraad,
            'categorieen' => $categorieen
        ];
        $this->view('voorraadbeheer/index', $data);
    }
}
