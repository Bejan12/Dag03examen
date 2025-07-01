<?php

class Auth extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function login()
    {
        // Check if user is already logged in
        if ($this->isLoggedIn()) {
            redirect('');
        }

        // Check for POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = array_map('trim', $_POST);

            $data = [
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Voer een emailadres in';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Voer een wachtwoord in';
            }

            // Make sure no errors
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Validated
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Onjuiste inloggegevens';
                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Load view
            $this->view('auth/login', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        redirect('auth/login');
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->Id;
        $_SESSION['user_email'] = $user->Gebruikersnaam;
        $_SESSION['user_name'] = $user->InlogNaam;
        $_SESSION['user_role'] = $user->RolNaam;
        redirect('');
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}
