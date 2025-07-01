<?php

class Voedselpakketten extends BaseController
{
    private $voedselpakketModel;

    public function __construct()
    {
        $this->voedselpakketModel = $this->model('VoedselpakketModel');
    }

    public function overzicht()
    {
        // Get all families with food packages
        $gezinnen = $this->voedselpakketModel->getAllGezinnenMetVoedselpakketten();
        
        // Get dietary preferences for dropdown
        $eetwensen = $this->voedselpakketModel->getAllEetwensen();

        $data = [
            'title' => 'Overzicht gezinnen met voedselpakketten',
            'gezinnen' => $gezinnen,
            'eetwensen' => $eetwensen
        ];

        $this->view('voedselpakketten/overzicht', $data);
    }

    public function filterByEetwens($eetwensId = null)
    {
        if ($eetwensId) {
            $gezinnen = $this->voedselpakketModel->getGezinnenByEetwens($eetwensId);
        } else {
            $gezinnen = $this->voedselpakketModel->getAllGezinnenMetVoedselpakketten();
        }
        
        $eetwensen = $this->voedselpakketModel->getAllEetwensen();

        $data = [
            'title' => 'Overzicht gezinnen met voedselpakketten',
            'gezinnen' => $gezinnen,
            'eetwensen' => $eetwensen,
            'selectedEetwens' => $eetwensId
        ];

        $this->view('voedselpakketten/overzicht', $data);
    }
}