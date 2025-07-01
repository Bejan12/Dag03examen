<?php

/**
 * Voedselpakketten Controller
 * 
 * Deze controller beheert alle functionaliteiten voor voedselpakketten:
 * - Tonen van gezinnen overzicht
 * - Filteren van gezinnen op eetwens
 * - Tonen van voedselpakket details per gezin
 * - Wijzigen van voedselpakket status
 * 
 * @author Voedselbank Maaskantje
 * @version 1.0
 */
class Voedselpakketten extends BaseController
{
    /**
     * @var VoedselpakketModel $voedselpakketModel Model voor database operaties
     */
    private $voedselpakketModel;

    /**
     * Constructor - Initialiseert het model
     * Wordt automatisch aangeroepen bij het maken van een controller object
     */
    public function __construct()
    {
        // Laad het VoedselpakketModel voor database operaties
        $this->voedselpakketModel = $this->model('VoedselpakketModel');
    }

    /**
     * Index methode - Standaard methode die wordt aangeroepen
     * Redirect naar overzicht methode
     */
    public function index(): void
    {
        $this->overzicht();
    }

    /**
     * Overzicht methode - Toont alle gezinnen met voedselpakketten
     * 
     * Functionaliteit:
     * - Alleen toegankelijk voor Manager rol
     * - Haalt alle gezinnen op uit database
     * - Haalt alle eetwensen op voor filter dropdown
     * - Toont success/error berichten
     * - Laadt de index view
     */
    public function overzicht(): void
    {
        // Controleer Manager autorisatie
        requireManagerRole();
        
        try {
            // Haal alle gezinnen met hun voedselpakketten op
            $gezinnen = $this->voedselpakketModel->getAllGezinnenMetVoedselpakketten();
            
            // Haal alle eetwensen op voor de filter dropdown
            $eetwensen = $this->voedselpakketModel->getAllEetwensen();

            // Prepareer data voor de view
            $data = [
                'title' => 'Overzicht gezinnen',
                'gezinnen' => $gezinnen,                           // Array met alle gezinnen
                'eetwensen' => $eetwensen,                         // Array met alle eetwensen voor dropdown
                'success_message' => $this->getFlashMessage('success'), // Success bericht uit sessie
                'error_message' => $this->getFlashMessage('error')      // Error bericht uit sessie
            ];

            // Laad de index view met de data
            $this->view('voedselpakketten/index', $data);
            
        } catch (Exception $e) {
            // Als er een fout optreedt, toon error pagina
            $this->handleError($e, 'Er is een fout opgetreden');
        }
    }

    /**
     * FilterByEetwens methode - Filtert gezinnen op basis van geselecteerde eetwens
     * 
     * Functionaliteit:
     * - Alleen toegankelijk voor Manager rol
     * - Ontvangt eetwens ID via GET parameter
     * - Filtert gezinnen op basis van eetwens
     * - Als geen eetwens geselecteerd, toon alle gezinnen
     * 
     * @param int $eetwensId ID van de geselecteerde eetwens (via GET)
     */
    public function filterByEetwens(): void
    {
        // Controleer Manager autorisatie
        requireManagerRole();
        
        try {
            // Haal eetwens ID op uit GET parameter, default 0
            $eetwensId = (int)($_GET['eetwens'] ?? 0);

            // Als een eetwens is geselecteerd, filter daarop
            if ($eetwensId > 0) {
                $gezinnen = $this->voedselpakketModel->getGezinnenByEetwens($eetwensId);
            } else {
                // Anders toon alle gezinnen
                $gezinnen = $this->voedselpakketModel->getAllGezinnenMetVoedselpakketten();
            }

            // Haal alle eetwensen op voor dropdown (onafhankelijk van filter)
            $eetwensen = $this->voedselpakketModel->getAllEetwensen();

            // Prepareer data voor view
            $data = [
                'title' => 'Overzicht gezinnen',
                'gezinnen' => $gezinnen,                    // Gefilterde of alle gezinnen
                'eetwensen' => $eetwensen,                  // Alle eetwensen voor dropdown
                'selectedEetwens' => $eetwensId,            // Geselecteerde eetwens voor dropdown
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            // Laad dezelfde index view maar met gefilterde data
            $this->view('voedselpakketten/index', $data);
            
        } catch (Exception $e) {
            $this->handleError($e, 'Er is een fout opgetreden bij het filteren');
        }
    }

    /**
     * Details methode - Toont voedselpakketten details voor een specifiek gezin
     * 
     * Functionaliteit:
     * - Alleen toegankelijk voor Manager rol
     * - Ontvangt gezin ID via URL parameter
     * - Haalt gezin details op
     * - Haalt alle voedselpakketten voor dit gezin op
     * - Toont details view
     * 
     * @param int $gezinId ID van het gezin
     */
    public function details(int $gezinId): void
    {
        // Controleer Manager autorisatie
        requireManagerRole();
        
        try {
            // Haal details van het specifieke gezin op
            $gezinDetails = $this->voedselpakketModel->getGezinDetails($gezinId);
            
            // Haal alle voedselpakketten voor dit gezin op
            $voedselpakketten = $this->voedselpakketModel->getVoedselpakkettenByGezin($gezinId);

            // Prepareer data voor details view
            $data = [
                'title' => 'Overzicht voedselpakketten',
                'gezin' => $gezinDetails,                   // Gezin informatie
                'voedselpakketten' => $voedselpakketten,    // Array met voedselpakketten
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            // Laad de details view
            $this->view('voedselpakketten/details', $data);
            
        } catch (Exception $e) {
            $this->handleError($e, 'Kon gezin details niet laden');
        }
    }

    /**
     * WijzigStatus methode - Toont formulier om voedselpakket status te wijzigen
     * 
     * Functionaliteit:
     * - Alleen toegankelijk voor Manager rol
     * - Ontvangt voedselpakket ID via URL parameter
     * - Controleert of pakket bestaat
     * - Controleert of wijziging toegestaan is (scenario 2 check)
     * - Toont wijzig formulier
     * 
     * @param int $voedselpakketId ID van het voedselpakket
     */
    public function wijzigStatus(int $voedselpakketId): void
    {
        // Controleer Manager autorisatie
        requireManagerRole();
        
        try {
            // Haal voedselpakket op basis van ID
            $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
            
            // Controleer of voedselpakket bestaat
            if (!$voedselpakket) {
                throw new Exception('Voedselpakket niet gevonden');
            }

            // Controleer of voedselpakket gewijzigd mag worden (scenario 2)
            $magGewijzigdWorden = $this->voedselpakketModel->magVoedselpakketGewijzigdWorden($voedselpakketId);
            
            // Controleer of gezin nog ingeschreven is
            $isIngeschreven = $this->voedselpakketModel->isGezinIngeschreven($voedselpakket->GezinId);

            // Prepareer data voor wijzig view
            $data = [
                'title' => 'Wijzig voedselpakket status',
                'voedselpakket' => $voedselpakket,          // Voedselpakket gegevens
                'isIngeschreven' => $isIngeschreven,        // Is gezin nog ingeschreven?
                'magGewijzigdWorden' => $magGewijzigdWorden, // Mag pakket gewijzigd worden?
                'csrf_token' => $this->generateCSRFToken(), // CSRF bescherming
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            // Laad wijzig view
            $this->view('voedselpakketten/wijzig', $data);
            
        } catch (Exception $e) {
            $this->handleError($e, 'Kon wijzig status pagina niet laden');
        }
    }

    /**
     * UpdateStatus methode - Verwerkt het wijzigen van voedselpakket status
     * 
     * Functionaliteit:
     * - Alleen toegankelijk voor Manager rol
     * - Ontvangt POST data van wijzig formulier
     * - Valideert input data
     * - Wijzigt status in database
     * - Redirect naar juiste pagina met bericht
     */
    public function updateStatus(): void
    {
        // Controleer Manager autorisatie
        requireManagerRole();
        
        // Controleer of het een POST request is
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Haal POST data op
                $voedselpakketId = (int)$_POST['voedselpakket_id'] ?? 0;
                $nieuweStatus = $_POST['status'] ?? '';

                // Valideer voedselpakket ID
                if ($voedselpakketId <= 0) {
                    throw new Exception('Ongeldige voedselpakket ID');
                }

                // Valideer status (alleen deze twee zijn toegestaan)
                if (!in_array($nieuweStatus, ['NietUitgereikt', 'Uitgereikt'])) {
                    throw new Exception('Ongeldige status');
                }

                // Probeer status te wijzigen via model
                $result = $this->voedselpakketModel->wijzigVoedselpakketStatus($voedselpakketId, $nieuweStatus);

                if ($result) {
                    // Als wijziging succesvol, haal voedselpakket op voor redirect
                    $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
                    if ($voedselpakket) {
                        // Toon success bericht op wijzig pagina met auto-redirect
                        $this->wijzigStatusWithSuccess($voedselpakketId, $voedselpakket->GezinId);
                        return;
                    }
                } else {
                    throw new Exception('Status wijziging mislukt');
                }

            } catch (Exception $e) {
                // Bij fout, ga terug naar wijzig pagina met error bericht
                $voedselpakketId = (int)$_POST['voedselpakket_id'] ?? 0;
                if ($voedselpakketId > 0) {
                    $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
                    if ($voedselpakket) {
                        $this->setFlashMessage('error', $e->getMessage());
                        $this->redirect('voedselpakketten/wijzigStatus/' . $voedselpakketId);
                        return;
                    }
                }
                
                // Als we hier komen, redirect naar overzicht
                $this->redirect('voedselpakketten/overzicht');
            }
        } else {
            // Als geen POST request, redirect naar overzicht
            $this->redirect('voedselpakketten/overzicht');
        }
    }

    /**
     * WijzigStatusWithSuccess methode - Toont success pagina na succesvolle status wijziging
     * 
     * Functionaliteit:
     * - Toont wijzig pagina met success bericht
     * - Automatische redirect na 3 seconden
     * - Gebruikt voor betere user experience
     * 
     * @param int $voedselpakketId ID van het gewijzigde voedselpakket
     * @param int $gezinId ID van het gezin voor redirect URL
     */
    private function wijzigStatusWithSuccess(int $voedselpakketId, int $gezinId): void
    {
        try {
            // Haal voedselpakket op voor weergave
            $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
            
            if (!$voedselpakket) {
                throw new Exception('Voedselpakket niet gevonden');
            }

            // Controleer nog steeds of wijziging toegestaan was
            $magGewijzigdWorden = $this->voedselpakketModel->magVoedselpakketGewijzigdWorden($voedselpakketId);
            $isIngeschreven = $this->voedselpakketModel->isGezinIngeschreven($voedselpakket->GezinId);

            // Prepareer data voor success view
            $data = [
                'title' => 'Wijzig voedselpakket status',
                'voedselpakket' => $voedselpakket,
                'isIngeschreven' => $isIngeschreven,
                'magGewijzigdWorden' => $magGewijzigdWorden,
                'csrf_token' => $this->generateCSRFToken(),
                'success_message' => 'De wijziging is doorgevoerd',        // Success bericht
                'redirect_url' => URLROOT . 'voedselpakketten/details/' . $gezinId, // Redirect URL
                'error_message' => null
            ];

            // Laad wijzig view (met success bericht en auto-redirect)
            $this->view('voedselpakketten/wijzig', $data);
            
        } catch (Exception $e) {
            $this->handleError($e, 'Kon wijzig status pagina niet laden');
        }
    }

    // ==================== HELPER METHODS ====================

    /**
     * HandleError methode - Centrale error handling
     * 
     * @param Exception $e De exception die opgetreden is
     * @param string $userMessage Gebruiksvriendelijk bericht
     */
    private function handleError(Exception $e, string $userMessage): void
    {
        // Log de werkelijke error voor debugging
        error_log("Voedselpakketten Controller Error: " . $e->getMessage());
        
        // Toon gebruiksvriendelijk bericht
        $this->setFlashMessage('error', $userMessage);
        $this->redirect('voedselpakketten/overzicht');
    }

    /**
     * SetFlashMessage methode - Zet bericht in sessie voor eenmalige weergave
     * 
     * @param string $type Type bericht ('success' of 'error')
     * @param string $message Het bericht
     */
    private function setFlashMessage(string $type, string $message): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['flash_' . $type] = $message;
    }

    /**
     * GetFlashMessage methode - Haalt bericht op uit sessie en verwijdert het
     * 
     * @param string $type Type bericht ('success' of 'error')
     * @return string|null Het bericht of null als niet gevonden
     */
    private function getFlashMessage(string $type): ?string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $message = $_SESSION['flash_' . $type] ?? null;
        unset($_SESSION['flash_' . $type]);
        return $message;
    }

    /**
     * GenerateCSRFToken methode - Genereert CSRF token voor formulier beveiliging
     * 
     * @return string CSRF token
     */
    private function generateCSRFToken(): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }

    /**
     * Redirect methode - Redirect naar andere URL
     * 
     * @param string $url Relatieve URL (zonder URLROOT)
     */
    private function redirect(string $url): void
    {
        header('Location: ' . URLROOT . $url);
        exit;
    }
}