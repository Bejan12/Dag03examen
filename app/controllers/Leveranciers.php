<?php

class Leveranciers extends BaseController
{
    public function index()
    {
        $leverancierModel = $this->model('Leverancier');
        $type = isset($_POST['leveranciertype']) ? $_POST['leveranciertype'] : null;
        $leveranciers = $leverancierModel->getLeveranciers($type);
        $types = $leverancierModel->getLeverancierTypes();

        $data = [
            'leveranciers' => $leveranciers,
            'types' => $types,
            'selectedType' => $type,
            'melding' => ($type && count($leveranciers) == 0) ? 'Er zijn geen leveranciers bekent van het geselecteerde leverancierstype' : ''
        ];

        $this->view('leveranciers/index', $data);
    }
}

// geen wijzigingen nodig in deze controller voor deze user story
