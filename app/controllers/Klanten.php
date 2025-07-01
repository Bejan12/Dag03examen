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
        // Require login
        requireLogin();
        
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
        // Require login
        requireLogin();
        
        if (!$id) {
            redirect('klanten');
        }
        
        $klant = $this->klantModel->getKlantById($id);
        
        if (!$klant || empty($klant)) {
            redirect('klanten');
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
        // Require login
        requireLogin();
        
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
            // Sanitize POST data (modern approach)
            $_POST = array_map('trim', $_POST);

            $data = [
                'id' => $id,
                'straat' => trim($_POST['straat']),
                'huisnummer' => trim($_POST['huisnummer']),
                'toevoeging' => trim($_POST['toevoeging']),
                'postcode' => trim($_POST['postcode']),
                'woonplaats' => trim($_POST['woonplaats']),
                'email' => trim($_POST['email']),
                'mobiel' => trim($_POST['mobiel']),
                'klant' => $hoofdklant, // Alleen de hoofdklant object
                'title' => $klantnaam,
                // Readonly velden toevoegen
                'voornaam' => $hoofdklant->Voornaam,
                'tussenvoegsel' => $hoofdklant->Tussenvoegsel,
                'achternaam' => $hoofdklant->Achternaam,
                'geboortedatum' => $hoofdklant->Geboortedatum,
                'typepersoon' => $hoofdklant->TypePersoon,
                'vertegenwoordiger' => $hoofdklant->IsVertegenwoordiger ? 'Ja' : 'Nee',
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
                'klant' => $hoofdklant, // Alleen de hoofdklant object
                'title' => $klantnaam,
                // Readonly velden toevoegen
                'voornaam' => $hoofdklant->Voornaam,
                'tussenvoegsel' => $hoofdklant->Tussenvoegsel,
                'achternaam' => $hoofdklant->Achternaam,
                'geboortedatum' => $hoofdklant->Geboortedatum,
                'typepersoon' => $hoofdklant->TypePersoon,
                'vertegenwoordiger' => $hoofdklant->IsVertegenwoordiger ? 'Ja' : 'Nee',
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

}
