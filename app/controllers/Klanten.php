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
                // Bewerkbare persoonlijke gegevens uit POST
                'voornaam' => trim($_POST['voornaam']),
                'tussenvoegsel' => trim($_POST['tussenvoegsel']),
                'achternaam' => trim($_POST['achternaam']),
                'geboortedatum' => trim($_POST['geboortedatum']),
                // Contactgegevens uit POST
                'straat' => trim($_POST['straat']),
                'huisnummer' => trim($_POST['huisnummer']),
                'toevoeging' => trim($_POST['toevoeging']),
                'postcode' => trim($_POST['postcode']),
                'woonplaats' => trim($_POST['woonplaats']),
                'email' => trim($_POST['email']),
                'mobiel' => trim($_POST['mobiel']),
                'klant' => $hoofdklant, // Alleen de hoofdklant object
                'title' => $klantnaam,
                // Readonly velden (niet bewerkbaar)
                'typepersoon' => $hoofdklant->TypePersoon,
                'vertegenwoordiger' => $hoofdklant->IsVertegenwoordiger ? 'Ja' : 'Nee',
                // Error fields
                'voornaam_err' => '',
                'tussenvoegsel_err' => '',
                'achternaam_err' => '',
                'geboortedatum_err' => '',
                'straat_err' => '',
                'huisnummer_err' => '',
                'postcode_err' => '',
                'woonplaats_err' => '',
                'email_err' => '',
                'mobiel_err' => '',
                'general_err' => ''
            ];

            // Validate data
            // Persoonlijke gegevens validatie
            if (empty($data['voornaam'])) {
                $data['voornaam_err'] = 'Voer een voornaam in';
            } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\'-]+$/', $data['voornaam'])) {
                $data['voornaam_err'] = 'Voornaam mag alleen letters, spaties, apostrofes en koppeltekens bevatten';
            }

            if (empty($data['achternaam'])) {
                $data['achternaam_err'] = 'Voer een achternaam in';
            } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\'-]+$/', $data['achternaam'])) {
                $data['achternaam_err'] = 'Achternaam mag alleen letters, spaties, apostrofes en koppeltekens bevatten';
            }

            // Tussenvoegsel validatie (optioneel veld)
            if (!empty($data['tussenvoegsel']) && !preg_match('/^[a-zA-ZÀ-ÿ\s\'-]+$/', $data['tussenvoegsel'])) {
                $data['tussenvoegsel_err'] = 'Tussenvoegsel mag alleen letters, spaties, apostrofes en koppeltekens bevatten';
            }

            if (empty($data['geboortedatum'])) {
                $data['geboortedatum_err'] = 'Voer een geboortedatum in';
            } elseif (!strtotime($data['geboortedatum'])) {
                $data['geboortedatum_err'] = 'Voer een geldige geboortedatum in';
            } else {
                $geboorteJaar = date('Y', strtotime($data['geboortedatum']));
                $huidigJaar = date('Y');
                $geboorteDatum = new DateTime($data['geboortedatum']);
                $vandaag = new DateTime();
                
                if ($geboorteJaar < 1920) {
                    $data['geboortedatum_err'] = 'Geboortedatum mag niet voor 1920 zijn';
                } elseif ($geboorteDatum > $vandaag) {
                    $data['geboortedatum_err'] = 'Geboortedatum mag niet in de toekomst liggen';
                }
            }
            
            // Contactgegevens validatie
            if (empty($data['straat'])) {
                $data['straat_err'] = 'Voer een straatnaam in';
            }

            if (empty($data['huisnummer'])) {
                $data['huisnummer_err'] = 'Voer een huisnummer in';
            } elseif (!preg_match('/^[0-9]+[a-zA-Z]*$/', $data['huisnummer'])) {
                $data['huisnummer_err'] = 'Huisnummer moet beginnen met cijfers, gevolgd door optionele letters';
            }

            if (empty($data['postcode'])) {
                $data['postcode_err'] = 'Voer een postcode in';
            } elseif (!$this->isPostcodeInMaaskantjeRegio($data['postcode'])) {
                $data['postcode_err'] = 'De postcode komt niet uit de regio Maaskantje';
            }

            if (empty($data['woonplaats'])) {
                $data['woonplaats_err'] = 'Voer een woonplaats in';
            }

            if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Voer een geldig emailadres in';
            }

            // Mobiel nummer validatie (optioneel veld)
            if (!empty($data['mobiel'])) {
                // Verwijder spaties, koppeltekens en plus teken voor validatie
                $cleanMobiel = preg_replace('/[\s\-\+]/', '', $data['mobiel']);
                if (!preg_match('/^[0-9]+$/', $cleanMobiel)) {
                    $data['mobiel_err'] = 'Mobiel nummer mag alleen cijfers, spaties, koppeltekens en + bevatten';
                } elseif (strlen($cleanMobiel) < 10 || strlen($cleanMobiel) > 15) {
                    $data['mobiel_err'] = 'Mobiel nummer moet tussen 10 en 15 cijfers lang zijn';
                }
            }

            // Make sure no errors
            if (empty($data['voornaam_err']) && empty($data['tussenvoegsel_err']) && empty($data['achternaam_err']) && 
                empty($data['geboortedatum_err']) && empty($data['straat_err']) && 
                empty($data['huisnummer_err']) && empty($data['postcode_err']) && 
                empty($data['woonplaats_err']) && empty($data['email_err']) && empty($data['mobiel_err'])) {
                
                // Update alle gegevens
                if ($this->klantModel->updateKlant($data)) {
                    $data['success'] = 'De klantgegevens zijn gewijzigd';
                    $this->view('klant/edit', $data);
                } else {
                    $data['general_err'] = 'De contactgegevens van de geselecteerde klant kunnen niet gewijzigd worden';
                    $this->view('klant/edit', $data);
                }
            } else {
                // Als er postcode validatie errors zijn, toon specifieke foutmelding
                if (!empty($data['postcode_err']) && $data['postcode_err'] === 'De postcode komt niet uit de regio Maaskantje') {
                    $data['general_err'] = 'De contactgegevens van de geselecteerde klant kunnen niet gewijzigd worden';
                }
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
                // Persoonlijke gegevens (bewerkbaar)
                'voornaam' => $hoofdklant->Voornaam,
                'tussenvoegsel' => $hoofdklant->Tussenvoegsel,
                'achternaam' => $hoofdklant->Achternaam,
                'geboortedatum' => $hoofdklant->Geboortedatum,
                // Readonly velden
                'typepersoon' => $hoofdklant->TypePersoon,
                'vertegenwoordiger' => $hoofdklant->IsVertegenwoordiger ? 'Ja' : 'Nee',
                // Contactgegevens
                'straat' => $contactData ? $contactData->Straat : '',
                'huisnummer' => $contactData ? $contactData->Huisnummer : '',
                'toevoeging' => $contactData ? $contactData->Toevoeging : '',
                'postcode' => $contactData ? $contactData->Postcode : '',
                'woonplaats' => $contactData ? $contactData->Woonplaats : '',
                'email' => $contactData ? $contactData->Email : '',
                'mobiel' => $contactData ? $contactData->Mobiel : '',
                // Error fields
                'voornaam_err' => '',
                'tussenvoegsel_err' => '',
                'achternaam_err' => '',
                'geboortedatum_err' => '',
                'straat_err' => '',
                'huisnummer_err' => '',
                'postcode_err' => '',
                'woonplaats_err' => '',
                'email_err' => '',
                'mobiel_err' => '',
                'general_err' => ''
            ];

            $this->view('klant/edit', $data);
        }
    }

    /**
     * Controleert of een postcode binnen de regio Maaskantje valt
     * @param string $postcode De postcode om te controleren
     * @return bool True als de postcode binnen de regio valt, anders false
     */
    private function isPostcodeInMaaskantjeRegio($postcode)
    {
        // Verwijder spaties en zet om naar hoofdletters voor consistentie
        $postcode = strtoupper(str_replace(' ', '', $postcode));
        
        // Definieer geldige postcodes voor de regio Maaskantje
        // Dit zijn voorbeelden - in een echte situatie zou dit uit een database komen
        $geldigePostcodes = [
            '5271', '5272', '5273', '5274', '5275', // Den Bosch gebied
            '4901', '4902', '4903', '4904', '4905', // Oosterhout gebied
            '5161', '5162', '5163', '5164', '5165'  // Waalwijk gebied
        ];
        
        // Haal de eerste 4 cijfers van de postcode
        $postcodeStart = substr($postcode, 0, 4);
        
        // Controleer of de postcode start begint in de lijst staat
        return in_array($postcodeStart, $geldigePostcodes);
    }

}