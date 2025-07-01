<?php

class Leveranciers extends BaseController
{
    public function index()
    {
        // Toegangscontrole: alleen voor manager of medewerker
        session_start();
        if (
            !isset($_SESSION['user_role']) ||
            !in_array($_SESSION['user_role'], ['manager', 'medewerker'])
        ) {
            header('Location: ' . URLROOT . '/login');
            exit;
        }

        $leverancierModel = $this->model('Leverancier');
        $type = isset($_POST['leveranciertype']) ? $_POST['leveranciertype'] : null;
        $leveranciers = $leverancierModel->getLeveranciers($type);
        $types = $leverancierModel->getLeverancierTypes();

        $data = [
            'leveranciers' => $leveranciers,
            'types' => $types,
            'selectedType' => $type,
            'melding' => ($type && count($leveranciers) == 0) ? 'Er zijn geen leveranciers bekend van het geselecteerde leverancierstype' : ''
        ];

        $this->view('leveranciers/index', $data);
    }
}

// geen wijzigingen nodig in deze controller voor deze user story
