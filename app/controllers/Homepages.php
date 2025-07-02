<?php

class Homepages extends BaseController
{
    private $voedselpakketModel;
    private $klantModel;

    public function __construct()
    {
        $this->voedselpakketModel = $this->model('VoedselpakketModel');
        $this->klantModel = $this->model('Klant');
    }

    public function index($firstname = NULL, $infix = NULL, $lastname = NULL)
    {
        // Controleer of gebruiker ingelogd is
        requireLogin();

        // Haal dashboard statistieken op
        $dashboardData = $this->getDashboardStatistics();

        /**
         * Het $data-array geeft informatie mee aan de view-pagina
         */
        $data = [
            'title' => 'Dashboard - Voedselbank Maaskantje',
            'user_name' => $_SESSION['user_name'] ?? 'Gebruiker',
            'user_role' => $_SESSION['user_role'] ?? 'Gast',
            'statistics' => $dashboardData
        ];

        /**
         * Met de view-method uit de BaseController-class wordt de view
         * aangeroepen met de informatie uit het $data-array
         */
        $this->view('homepages/index', $data);
    }

    /**
     * Haal dashboard statistieken op
     */
    private function getDashboardStatistics()
    {
        try {
            $stats = [];

            // Basis statistieken voor alle gebruikers
            $stats['totaal_klanten'] = $this->klantModel->getTotalKlanten();
            
            // Manager specifieke statistieken
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Manager') {
                $stats['totaal_voedselpakketten'] = $this->voedselpakketModel->getTotalVoedselpakketten();
                $stats['uitgereikt_deze_maand'] = $this->voedselpakketModel->getUitgereiktDezeMaand();
                $stats['niet_uitgereikt'] = $this->voedselpakketModel->getNietUitgereikt();
                $stats['recent_activities'] = $this->voedselpakketModel->getRecentActivities(5);
            }

            return $stats;
        } catch (Exception $e) {
            // Als er een fout optreedt, return lege array
            return [];
        }
    }

    /**
     * De optellen-method berekent de som van twee getallen
     * We gebruiken deze method voor een unittest
     */
}