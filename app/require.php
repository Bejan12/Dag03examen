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
     * Maak een instantie of object van de Core-Class
     */
    $init = new Core();
