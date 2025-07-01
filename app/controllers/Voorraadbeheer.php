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
        $voorraad = $this->voorraadModel->getAllVoorraad();
        $data = [
            'title' => 'Overzicht Voorraad',
            'voorraad' => $voorraad
        ];
        $this->view('voorraadbeheer/index', $data);
    }
}
