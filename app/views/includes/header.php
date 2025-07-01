<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voedselbank Maaskantje</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/css/style.css">
    <link rel="shortcut icon" href="<?= URLROOT; ?>/public/img/favicon.ico" type="image/x-icon">
  </head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand fw-bold" href="<?= URLROOT; ?>">
                <i class="bi bi-house-heart-fill me-2"></i>
                Voedselbank Maaskantje
            </a>
            
            <!-- Mobile toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/klanten">
                            <i class="bi bi-people-fill me-1"></i>
                            Overzicht Klanten
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/leveranciers">
                            <i class="bi bi-truck me-1"></i>
                            Overzicht Leveranciers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/voorraadbeheer/index">
                            <i class="bi bi-box-seam me-1"></i>
                            Overzicht Voorraad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT; ?>/voedselpakket">
                            <i class="bi bi-bag-heart-fill me-1"></i>
                            Overzicht Voedselpakket
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main content container -->
    <div class="container-fluid mt-4">