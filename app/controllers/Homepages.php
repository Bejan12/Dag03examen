<?php

class Homepages extends BaseController
{

    public function index($firstname = NULL, $infix = NULL, $lastname = NULL)
    {
        // Controleer of gebruiker ingelogd is
        requireLogin();

        /**
         * Het $data-array geeft informatie mee aan de view-pagina
         */
        $data = [
            'title' => 'Homepagina',
            'user_name' => $_SESSION['user_name'] ?? 'Gebruiker',
            'user_role' => $_SESSION['user_role'] ?? 'Gast'
        ];

        /**
         * Met de view-method uit de BaseController-class wordt de view
         * aangeroepen met de informatie uit het $data-array
         */
        $this->view('homepages/index', $data);
    }

    /**
     * De optellen-method berekent de som van twee getallen
     * We gebruiken deze method voor een unittest
     */
}