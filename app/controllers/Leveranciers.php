<?php

class Leveranciers extends BaseController
{
    public function index()
    {
<<<<<<< HEAD
        // Controleer Manager of Medewerker autorisatie
        requireManagerOrMedewerkerRole();
        
=======
        // Toegangscontrole: alleen voor manager of medewerker
        session_start();
        if (
            !isset($_SESSION['user_role']) ||
            !in_array($_SESSION['user_role'], ['manager', 'medewerker'])
        ) {
            header('Location: ' . URLROOT . '/login');
            exit;
        }

>>>>>>> Feature_Leverancier
        $leverancierModel = $this->model('Leverancier');
        $type = isset($_POST['leveranciertype']) ? $_POST['leveranciertype'] : null;
        // Als Donor is geselecteerd, altijd een lege lijst tonen
        if ($type === 'Donor') {
            $leveranciers = [];
        } else {
            $leveranciers = $leverancierModel->getLeveranciers($type);
        }
        $types = $leverancierModel->getLeverancierTypes();

        $data = [
            'leveranciers' => $leveranciers,
            'types' => $types,
            'selectedType' => $type,
            // Toon altijd de melding als 'Donor' is geselecteerd
            'melding' => ($type === 'Donor') ? 'Er zijn geen leveranciers bekend van het geselecteerde leverancierstype' : (($type && count($leveranciers) == 0) ? 'Er zijn geen leveranciers bekend van het geselecteerde leverancierstype' : '')
        ];

        $this->view('leveranciers/index', $data);
    }
}

// geen wijzigingen nodig in deze controller voor deze user story
