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
     * Toont details van een specifiek gezin
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

            if (!$gezinDetails) {
                throw new Exception('Gezin niet gevonden');
            }

            $data = [
                'title' => 'Gezin Details',
                'gezin' => $gezinDetails,
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            $this->view('voedselpakketten/details', $data);
        } catch (Exception $e) {
            $this->handleError($e, 'Kon gezin details niet laden');
        }
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