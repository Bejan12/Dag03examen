<?php

class ProductenPerLeverancier extends BaseController
{
    public function __construct()
    {
        // Alleen controleren of gebruiker ingelogd is
        requireLogin();
    }

    public function index($leverancierNummer = null)
    {
        $leverancierModel = $this->model('Leverancier');
        $producten = $leverancierModel->getProductenPerLeverancier($leverancierNummer);

        // Nieuw: haal leverancier op via leverancierNummer
        $leverancier = $leverancierModel->getLeverancierByNummer($leverancierNummer);

        $data = [
            'producten' => $producten,
            'leverancierNummer' => $leverancierNummer,
            'leverancier' => $leverancier // toegevoegd
        ];

        $this->view('productenperleverancier/index', $data);
    }

    public function wijzig($productId)
    {
        $leverancierModel = $this->model('Leverancier');
        $product = $leverancierModel->getProductById($productId);

        // Haal het leverancierNummer op via het productId
        $leverancierNummer = $leverancierModel->getLeverancierNummerByProductId($productId);

        $melding = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nieuweDatum = $_POST['houdbaarheidsdatum'];
            $oudeDatum = $product->Houdbaarheidsdatum;

            $dtOud = new DateTime($oudeDatum);
            $dtNieuw = new DateTime($nieuweDatum);

            // Alleen verlengen toegestaan, max 7 dagen
            if ($dtNieuw <= $dtOud) {
                $melding = 'De houdbaarheidsdatum is niet gewijzigd. De houdbaarheidsdatum mag alleen verlengd worden.';
            } else {
                $diff = $dtOud->diff($dtNieuw)->days;
                if ($diff > 7) {
                    $melding = 'De houdbaarheidsdatum is niet gewijzigd. De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd.';
                } else {
                    $leverancierModel->updateHoudbaarheidsdatum($productId, $nieuweDatum);
                    // Redirect naar het overzicht met melding
                    header('Location: ' . URLROOT . '/productenPerLeverancier/index/' . urlencode($leverancierNummer) . '?melding=' . urlencode('De houdbaarbaarheidsdatum is gewijzigd'));
                    exit;
                }
            }
        }

        $data = [
            'product' => $product,
            'melding' => $melding,
            'leverancierNummer' => $leverancierNummer
        ];
        $this->view('productenperleverancier/wijzig', $data);
    }
}



