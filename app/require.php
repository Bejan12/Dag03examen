<?php
    /**
     * Start session
     */
    session_start();
    
    /**
     * We includen hier alle libraries die we nodig hebben
     * voor het mvc-framework
     */
    require_once 'libraries/Core.php';
    require_once 'libraries/BaseController.php';
    require_once 'libraries/Database.php';
    require_once 'config/config.php';
    
    /**
     * Helper functie voor redirects
     */
    function redirect($page) {
        header('location: ' . URLROOT . '/' . $page);
        exit();
    }
    
    /**
     * Helper functie om te checken of gebruiker is ingelogd
     */
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Helper functie om toegang te controleren
     */
    function requireLogin() {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
    }
    
    /**
     * Helper functie om Manager rol te controleren
     */
    function requireManagerRole() {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Manager') {
            // Toon de 403 foutpagina direct op de voedselpakketten pagina
            showUnauthorizedPage();
            exit();
        }
    }
    
    /**
     * Helper functie om Manager of Medewerker rol te controleren
     */
    function requireManagerOrMedewerkerRole() {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        
        if (!isset($_SESSION['user_role']) || 
            ($_SESSION['user_role'] !== 'Manager' && $_SESSION['user_role'] !== 'Medewerker')) {
            // Toon de 403 foutpagina
            showUnauthorizedPageForLeveranciers();
            exit();
        }
    }
    
    /**
     * Helper functie om ongeautoriseerde toegang pagina te tonen
     */
    function showUnauthorizedPage() {
        $data = [
            'title' => 'Geen toegang',
            'error_message' => 'U heeft geen toegang tot deze pagina. Alleen managers mogen het voedselpakket overzicht bekijken.',
            'user_role' => $_SESSION['user_role'] ?? 'Gast'
        ];
        
        require_once APPROOT . '/views/includes/header.php';
        ?>
        <div class="container">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Geen toegang</strong><br>
                        <?= htmlspecialchars($data['error_message']); ?><br>
                        <small>Uw huidige rol: <?= htmlspecialchars($data['user_role']); ?></small>
                    </div>
                    
                    <div class="mt-3">
                        <a href="<?= URLROOT; ?>" class="btn btn-primary">Terug naar homepagina</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once APPROOT . '/views/includes/footer.php';
    }
    
    /**
     * Helper functie om ongeautoriseerde toegang pagina te tonen voor leveranciers
     */
    function showUnauthorizedPageForLeveranciers() {
        $data = [
            'title' => 'Geen toegang',
            'error_message' => 'U heeft geen toegang tot deze pagina. Alleen managers en medewerkers mogen het leveranciers overzicht bekijken.',
            'user_role' => $_SESSION['user_role'] ?? 'Gast'
        ];
        
        require_once APPROOT . '/views/includes/header.php';
        ?>
        <div class="container">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Geen toegang</strong><br>
                        <?= htmlspecialchars($data['error_message']); ?><br>
                        <small>Uw huidige rol: <?= htmlspecialchars($data['user_role']); ?></small>
                    </div>
                    
                    <div class="mt-3">
                        <a href="<?= URLROOT; ?>" class="btn btn-primary">Terug naar homepagina</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once APPROOT . '/views/includes/footer.php';
    }
    
    /**
     * Maak een instantie of object van de Core-Class
     */
    $init = new Core();
