<?php

class Klanten extends BaseController
{
    private $klantModel;

    public function __construct()
    {
        $this->klantModel = $this->model('Klant');
    }

    public function index()
    {
        // Haal alle klanten op uit de database
        $klanten = $this->klantModel->getAllKlanten();

        $data = [
            'title' => 'Overzicht Klanten',
            'klanten' => $klanten
        ];

        $this->view('klant/index', $data);
    }

    public function details($id)
    {
        // Debug: laat zien dat de method wordt aangeroepen
        if (!$id) {
            die("Details method aangeroepen maar geen ID ontvangen");
        }
        
        echo "Details method aangeroepen met ID: " . $id . "<br>";
        
        // Laat alle beschikbare gezin ID's zien
        $allIds = $this->klantModel->getAllGezinIds();
        echo "Beschikbare Gezin IDs: ";
        foreach ($allIds as $gezin) {
            echo $gezin->Id . " ";
        }
        echo "<br><br>";
        
        $klant = $this->klantModel->getKlantById($id);
        
        echo "Aantal gevonden records: " . count($klant) . "<br>";
        
        if (!$klant || empty($klant)) {
            echo "Geen klant gevonden met ID: " . $id . "<br>";
            echo "Probeer een van de beschikbare IDs hierboven.<br>";
            echo '<a href="' . URLROOT . '/klanten">Terug naar overzicht</a>';
            exit;
        }

        // Haal de naam van de hoofdklant voor de titel
        $hoofdklant = $klant[0];
        $klantnaam = $hoofdklant->Voornaam . ' ' . $hoofdklant->Tussenvoegsel . ' ' . $hoofdklant->Achternaam;
        $klantnaam = trim(str_replace('  ', ' ', $klantnaam)); // Verwijder dubbele spaties

        $data = [
            'title' => $klantnaam,
            'klant' => $klant
        ];

        $this->view('klant/details', $data);
    }

    public function edit($id)
    {
        $klant = $this->klantModel->getKlantById($id);
        
        if (!$klant) {
            redirect('klanten');
        }

        // Haal de naam van de hoofdklant voor de titel
        $hoofdklant = $klant[0];
        $klantnaam = $hoofdklant->Voornaam . ' ' . $hoofdklant->Tussenvoegsel . ' ' . $hoofdklant->Achternaam;
        $klantnaam = trim(str_replace('  ', ' ', $klantnaam)); // Verwijder dubbele spaties

        // Check for POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'straat' => trim($_POST['straat']),
                'huisnummer' => trim($_POST['huisnummer']),
                'toevoeging' => trim($_POST['toevoeging']),
                'postcode' => trim($_POST['postcode']),
                'woonplaats' => trim($_POST['woonplaats']),
                'email' => trim($_POST['email']),
                'mobiel' => trim($_POST['mobiel']),
                'klant' => $klant,
                'title' => $klantnaam,
                'straat_err' => '',
                'huisnummer_err' => '',
                'postcode_err' => '',
                'woonplaats_err' => '',
                'email_err' => '',
                'mobiel_err' => ''
            ];

            // Validate data
            if (empty($data['straat'])) {
                $data['straat_err'] = 'Voer een straatnaam in';
            }

            if (empty($data['huisnummer'])) {
                $data['huisnummer_err'] = 'Voer een huisnummer in';
            }

            if (empty($data['postcode'])) {
                $data['postcode_err'] = 'Voer een postcode in';
            }

            if (empty($data['woonplaats'])) {
                $data['woonplaats_err'] = 'Voer een woonplaats in';
            }

            if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Voer een geldig emailadres in';
            }

            // Make sure no errors
            if (empty($data['straat_err']) && empty($data['huisnummer_err']) && 
                empty($data['postcode_err']) && empty($data['woonplaats_err']) && 
                empty($data['email_err'])) {
                
                // Update contact gegevens
                if ($this->klantModel->updateKlantContact($data)) {
                    $data['success'] = 'De klantgegevens zijn gewijzigd';
                    $this->view('klant/edit', $data);
                } else {
                    die('Er is iets fout gegaan');
                }
            } else {
                // Load view with errors
                $this->view('klant/edit', $data);
            }
        } else {
            // Get existing contact data
            $contactData = $this->klantModel->getContactByGezinId($id);
            
            $data = [
                'id' => $id,
                'klant' => $klant,
                'title' => $klantnaam,
                'straat' => $contactData ? $contactData->Straat : '',
                'huisnummer' => $contactData ? $contactData->Huisnummer : '',
                'toevoeging' => $contactData ? $contactData->Toevoeging : '',
                'postcode' => $contactData ? $contactData->Postcode : '',
                'woonplaats' => $contactData ? $contactData->Woonplaats : '',
                'email' => $contactData ? $contactData->Email : '',
                'mobiel' => $contactData ? $contactData->Mobiel : '',
                'straat_err' => '',
                'huisnummer_err' => '',
                'postcode_err' => '',
                'woonplaats_err' => '',
                'email_err' => '',
                'mobiel_err' => ''
            ];

            $this->view('klant/edit', $data);
        }
    }

    public function test()
    {
        echo "Test routing werkt! Je bent op klanten/test";
        exit;
    }
}
