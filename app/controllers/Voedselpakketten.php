<?php


/**
 * Voedselpakketten Controller
 * 
 * @author Voedselbank Maaskantje
 * @version 1.0
 */
class Voedselpakketten extends BaseController
{
    private $voedselpakketModel;

    public function __construct()
    {
        $this->voedselpakketModel = $this->model('VoedselpakketModel');
    }

    public function index(): void
    {
        $this->overzicht();
    }

    public function overzicht(): void
    {
        try {
            $gezinnen = $this->voedselpakketModel->getAllGezinnenMetVoedselpakketten();
            $eetwensen = $this->voedselpakketModel->getAllEetwensen();

            $data = [
                'title' => 'Overzicht gezinnen',
                'gezinnen' => $gezinnen,
                'eetwensen' => $eetwensen,
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            $this->view('voedselpakketten/index', $data);
        } catch (Exception $e) {
            $this->handleError($e, 'Er is een fout opgetreden');
        }
    }

    public function filterByEetwens(): void
    {
        try {
            $eetwensId = (int)($_GET['eetwens'] ?? 0);

            if ($eetwensId > 0) {
                $gezinnen = $this->voedselpakketModel->getGezinnenByEetwens($eetwensId);
            } else {
                $gezinnen = $this->voedselpakketModel->getAllGezinnenMetVoedselpakketten();
            }

            $eetwensen = $this->voedselpakketModel->getAllEetwensen();

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
            $this->handleError($e, 'Er is een fout opgetreden bij het filteren');
        }
    }

    public function details(int $gezinId): void
    {
        try {
            $gezinDetails = $this->voedselpakketModel->getGezinDetails($gezinId);
            $voedselpakketten = $this->voedselpakketModel->getVoedselpakkettenByGezin($gezinId);

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

    public function wijzigStatus(int $voedselpakketId): void
    {
        try {
            $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
            
            if (!$voedselpakket) {
                throw new Exception('Voedselpakket niet gevonden');
            }

            $magGewijzigdWorden = $this->voedselpakketModel->magVoedselpakketGewijzigdWorden($voedselpakketId);
            $isIngeschreven = $this->voedselpakketModel->isGezinIngeschreven($voedselpakket->GezinId);

            $data = [
                'title' => 'Wijzig voedselpakket status',
                'voedselpakket' => $voedselpakket,
                'isIngeschreven' => $isIngeschreven,
                'magGewijzigdWorden' => $magGewijzigdWorden,
                'csrf_token' => $this->generateCSRFToken(),
                'success_message' => $this->getFlashMessage('success'),
                'error_message' => $this->getFlashMessage('error')
            ];

            $this->view('voedselpakketten/wijzig', $data);
        } catch (Exception $e) {
            $this->handleError($e, 'Kon wijzig status pagina niet laden');
        }
    }

   
public function updateStatus(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $voedselpakketId = (int)$_POST['voedselpakket_id'] ?? 0;
            $nieuweStatus = $_POST['status'] ?? '';

            if ($voedselpakketId <= 0) {
                throw new Exception('Ongeldige voedselpakket ID');
            }

            if (!in_array($nieuweStatus, ['NietUitgereikt', 'Uitgereikt'])) {
                throw new Exception('Ongeldige status');
            }

            $result = $this->voedselpakketModel->wijzigVoedselpakketStatus($voedselpakketId, $nieuweStatus);

            if ($result) {
                // Haal voedselpakket op voor redirect URL
                $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
                if ($voedselpakket) {
                    // Toon success message op de wijzig pagina met auto-redirect
                    $this->wijzigStatusWithSuccess($voedselpakketId, $voedselpakket->GezinId);
                    return;
                }
            } else {
                throw new Exception('Status wijziging mislukt');
            }

        } catch (Exception $e) {
            $voedselpakketId = (int)$_POST['voedselpakket_id'] ?? 0;
            if ($voedselpakketId > 0) {
                $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
                if ($voedselpakket) {
                    $this->setFlashMessage('error', $e->getMessage());
                    $this->redirect('voedselpakketten/wijzigStatus/' . $voedselpakketId);
                    return;
                }
            }
            
            $this->redirect('voedselpakketten/overzicht');
        }
    } else {
        $this->redirect('voedselpakketten/overzicht');
    }
}

private function wijzigStatusWithSuccess(int $voedselpakketId, int $gezinId): void
{
    try {
        $voedselpakket = $this->voedselpakketModel->getVoedselpakketById($voedselpakketId);
        
        if (!$voedselpakket) {
            throw new Exception('Voedselpakket niet gevonden');
        }

        $magGewijzigdWorden = $this->voedselpakketModel->magVoedselpakketGewijzigdWorden($voedselpakketId);
        $isIngeschreven = $this->voedselpakketModel->isGezinIngeschreven($voedselpakket->GezinId);

        $data = [
            'title' => 'Wijzig voedselpakket status',
            'voedselpakket' => $voedselpakket,
            'isIngeschreven' => $isIngeschreven,
            'magGewijzigdWorden' => $magGewijzigdWorden,
            'csrf_token' => $this->generateCSRFToken(),
            'success_message' => 'De wijziging is doorgevoerd',
            'redirect_url' => URLROOT . 'voedselpakketten/details/' . $gezinId,
            'error_message' => null
        ];

        $this->view('voedselpakketten/wijzig', $data);
    } catch (Exception $e) {
        $this->handleError($e, 'Kon wijzig status pagina niet laden');
    }
}

    // Helper methods
    private function generateCSRFToken(): string
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    private function setFlashMessage(string $type, string $message): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash_' . $type] = $message;
    }

    private function getFlashMessage(string $type): ?string
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $message = $_SESSION['flash_' . $type] ?? null;
        unset($_SESSION['flash_' . $type]);
        return $message;
    }

    private function handleError(Exception $e, string $userMessage): void
    {
        $this->setFlashMessage('error', $userMessage);
        $this->redirect('voedselpakketten/overzicht');
    }

    private function redirect(string $url): void
    {
        header('Location: ' . URLROOT . $url);
        exit;
    }
}