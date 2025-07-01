<?php

/**
 * Voedselpakketten Controller
 * 
 * Beheert alle acties gerelateerd aan voedselpakketten
 * 
 * @author Voedselbank Maaskantje
 * @version 1.0
 */
class Voedselpakketten extends BaseController
{
    private $voedselpakketModel;

    /**
     * Constructor - Initialiseert het model
     */
    public function __construct()
    {
        $this->voedselpakketModel = $this->model('VoedselpakketModel');
    }

    /**
     * Index pagina - redirect naar overzicht
     */
    public function index(): void
    {
        $this->overzicht();
    }

    /**
     * Toont overzicht van alle gezinnen met voedselpakketten
     */
    public function overzicht(): void
    {
        try {
            // Haal data op uit model
            $gezinnen = $this->voedselpakketModel->getAllGezinnenMetVoedselpakketten();
            $eetwensen = $this->voedselpakketModel->getAllEetwensen();

            // Check of data succesvol opgehaald is
            if ($gezinnen === false || $eetwensen === false) {
                throw new Exception('Kon gegevens niet ophalen uit database');
            }

            $data = [
                'title' => 'Overzicht gezinnen',
                'gezinnen' => $gezinnen,
                'eetwensen' => $eetwensen,
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            $this->view('voedselpakketten/index', $data);
        } catch (Exception $e) {
            $this->handleError($e, 'Er is een fout opgetreden bij het laden van het overzicht');
        }
    }

    /**
     * Filter gezinnen op basis van eetwens
     * 
     * @param int|null $eetwensId ID van de eetwens (optioneel via GET parameter)
     */
    public function filterByEetwens(?int $eetwensId = null): void
    {
        try {
            // Haal eetwens ID uit GET parameter als niet via URL parameter gegeven
            if ($eetwensId === null && isset($_GET['eetwens'])) {
                $eetwensId = (int)$_GET['eetwens'];
            }

            // Server-side validatie
            if ($eetwensId !== null && $eetwensId <= 0) {
                // Als eetwens 0 is, toon alle gezinnen
                $eetwensId = null;
            }

            // Haal data op
            if ($eetwensId && $eetwensId > 0) {
                $gezinnen = $this->voedselpakketModel->getGezinnenByEetwens($eetwensId);
            } else {
                $gezinnen = $this->voedselpakketModel->getAllGezinnenMetVoedselpakketten();
            }

            $eetwensen = $this->voedselpakketModel->getAllEetwensen();

            if ($gezinnen === false || $eetwensen === false) {
                throw new Exception('Kon gegevens niet ophalen uit database');
            }

            $data = [
                'title' => 'Overzicht gezinnen',
                'gezinnen' => $gezinnen,
                'eetwensen' => $eetwensen,
                'selectedEetwens' => $eetwensId,
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            $this->view('voedselpakketten/index', $data);
        } catch (Exception $e) {
            $this->handleError($e, 'Er is een fout opgetreden bij het filteren op eetwens');
        }
    }

    /**
     * Toont details van een specifiek gezin met voedselpakketten (Wireframe 3)
     * 
     * @param int $gezinId ID van het gezin
     */
    public function details(int $gezinId): void
    {
        try {
            // Valideer input
            if ($gezinId <= 0) {
                throw new InvalidArgumentException('Ongeldige gezin ID');
            }

            $gezinDetails = $this->voedselpakketModel->getGezinDetails($gezinId);
            $voedselpakketten = $this->voedselpakketModel->getVoedselpakkettenByGezin($gezinId);

            if (!$gezinDetails) {
                throw new Exception('Gezin niet gevonden');
            }

            if ($voedselpakketten === false) {
                throw new Exception('Kon voedselpakketten niet ophalen');
            }

            $data = [
                'title' => 'Overzicht voedselpakketten',
                'gezin' => $gezinDetails,
                'voedselpakketten' => $voedselpakketten,
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            $this->view('voedselpakketten/details', $data);
        } catch (Exception $e) {
            $this->handleError($e, 'Kon gezin details niet laden');
        }
    }

    /**
     * Toont wijzig status pagina (Wireframe 4)
     * 
     * @param int $voedselpakketId ID van het voedselpakket
     */
    public function wijzigStatus(int $voedselpakketId): void
    {
        try {
            // Valideer input
            if ($voedselpakketId <= 0) {
                throw new InvalidArgumentException('Ongeldige voedselpakket ID');
            }

            $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);

            if (!$voedselpakket) {
                throw new Exception('Voedselpakket niet gevonden');
            }

            // Controleer of gezin nog ingeschreven is
            $isIngeschreven = $this->voedselpakketModel->isGezinIngeschreven($voedselpakket->GezinId);

            $data = [
                'title' => 'Wijzig voedselpakket status',
                'voedselpakket' => $voedselpakket,
                'isIngeschreven' => $isIngeschreven,
                'csrf_token' => $this->generateCSRFToken(),
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            $this->view('voedselpakketten/wijzig_status', $data);
        } catch (Exception $e) {
            $this->handleError($e, 'Kon wijzig status pagina niet laden');
        }
    }

    /**
     * Verwerkt de status wijziging (POST)
     */
    public function updateStatus(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // CSRF token validatie
                if (!$this->validateCSRFToken()) {
                    throw new Exception('Ongeldige aanvraag');
                }

                // Sanitize en valideer input
                $voedselpakketId = (int)$this->sanitizeInput($_POST['voedselpakket_id'] ?? '');
                $nieuweStatus = $this->sanitizeInput($_POST['status'] ?? '');

                // Server-side validatie
                if ($voedselpakketId <= 0) {
                    throw new InvalidArgumentException('Ongeldige voedselpakket ID');
                }

                $geldige_statussen = ['NietUitgereikt', 'Uitgereikt'];
                if (!in_array($nieuweStatus, $geldige_statussen)) {
                    throw new InvalidArgumentException('Ongeldige status');
                }

                // Wijzig status
                $result = $this->voedselpakketModel->wijzigVoedselpakketStatus($voedselpakketId, $nieuweStatus);

                if ($result) {
                    $this->setFlashMessage('success', 'De wijziging is doorgevoerd');
                    
                    // Haal gezin ID op voor redirect
                    $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
                    if ($voedselpakket) {
                        // Redirect naar details pagina van het gezin
                        $this->redirect('voedselpakketten/details/' . $voedselpakket->GezinId);
                    } else {
                        $this->redirect('voedselpakketten/overzicht');
                    }
                } else {
                    throw new Exception('Kon status niet wijzigen');
                }

            } catch (Exception $e) {
                // Als het een specifieke foutmelding is over inschrijving, toon die
                if (strpos($e->getMessage(), 'niet meer ingeschreven') !== false) {
                    $this->setFlashMessage('error', $e->getMessage());
                    // Ga terug naar wijzig status pagina met disabled velden
                    $voedselpakketId = (int)($_POST['voedselpakket_id'] ?? 0);
                    if ($voedselpakketId > 0) {
                        $this->redirect('voedselpakketten/wijzigStatus/' . $voedselpakketId);
                    }
                } else {
                    $this->handleError($e, 'Er is een fout opgetreden bij het wijzigen van de status');
                }
            }
        }

        // Als niet POST, redirect naar overzicht
        $this->redirect('voedselpakketten/overzicht');
    }

    /**
     * Sanitize user input
     * 
     * @param string $input Input string
     * @return string Geschoonde string
     */
    private function sanitizeInput(string $input): string
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Valideer CSRF token
     * 
     * @return bool True als geldig
     */
    private function validateCSRFToken(): bool
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        return isset($_POST['csrf_token']) && 
               isset($_SESSION['csrf_token']) && 
               hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
    }

    /**
     * Genereer CSRF token
     * 
     * @return string CSRF token
     */
    private function generateCSRFToken(): string
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    /**
     * Zet een flash bericht
     * 
     * @param string $type Type bericht (success, error, info, warning)
     * @param string $message Bericht
     */
    private function setFlashMessage(string $type, string $message): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash_' . $type] = $message;
    }

    /**
     * Haal een flash bericht op
     * 
     * @param string $type Type bericht
     * @return string|null Bericht of null
     */
    private function getFlashMessage(string $type): ?string
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $message = $_SESSION['flash_' . $type] ?? null;
        unset($_SESSION['flash_' . $type]);
        return $message;
    }

    /**
     * Behandel errors en toon gebruiksvriendelijke foutmelding
     * 
     * @param Exception $e Exception object
     * @param string $userMessage Gebruiksvriendelijke foutmelding
     */
    private function handleError(Exception $e, string $userMessage): void
    {
        // Log de technische fout
        $this->logError($e);

        // Toon gebruiksvriendelijke foutmelding
        $this->setFlashMessage('error', $userMessage);
        
        // Redirect naar overzicht
        $this->redirect('voedselpakketten/overzicht');
    }

    /**
     * Log een error
     * 
     * @param Exception $e Exception object
     */
    private function logError(Exception $e): void
    {
        $logMessage = date('Y-m-d H:i:s') . " [ERROR] " . get_class($this) . ": " . $e->getMessage() . 
                     " | File: " . $e->getFile() . " | Line: " . $e->getLine();
        
        // Zorg ervoor dat de logs directory exists
        $logDir = APPROOT . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        error_log($logMessage . PHP_EOL, 3, $logDir . '/errors.log');
    }

    /**
     * Redirect naar andere pagina
     * 
     * @param string $url URL om naar te redirecten
     */
    private function redirect(string $url): void
    {
        header('Location: ' . URLROOT . $url);
        exit;
    }
}