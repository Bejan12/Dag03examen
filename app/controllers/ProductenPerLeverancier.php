<?php

class ProductenPerLeverancier extends BaseController
{
    public function index($leverancierNummer = null)
    {
        $leverancierModel = $this->model('Leverancier');
        $producten = $leverancierModel->getProductenPerLeverancier($leverancierNummer);

        $data = [
            'producten' => $producten,
            'leverancierNummer' => $leverancierNummer
        ];

        $this->view('productenperleverancier/index', $data);
    }

    public function wijzig($productId)
    {
        $leverancierModel = $this->model('Leverancier');
        $product = $leverancierModel->getProductById($productId);

        // Haal het leverancierNummer op via het productId
        $leverancierNummer = $leverancierModel->getLeverancierNummerByProductId($productId);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nieuweDatum = $_POST['houdbaarheidsdatum'];
            $leverancierModel->updateHoudbaarheidsdatum($productId, $nieuweDatum);

            $data = [
                'product' => $leverancierModel->getProductById($productId),
                'melding' => 'De houdbaarbaarheidsdatum is gewijzigd',
                'leverancierNummer' => $leverancierNummer
            ];
            $this->view('productenperleverancier/wijzig', $data);
            return;
        }

        $data = [
            'product' => $product,
            'melding' => '',
            'leverancierNummer' => $leverancierNummer
        ];
        $this->view('productenperleverancier/wijzig', $data);
    }
}
