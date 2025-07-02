<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <!-- WELKOM SECTIE -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h2 class="mb-1">
                                        <i class="bi bi-heart-fill me-2"></i>
                                        Welkom bij <?= htmlspecialchars($data['title']); ?>
                                    </h2>
                                    <p class="mb-0 fs-5">
                                        Hallo <?= htmlspecialchars($data['user_name']); ?>! 
                                        U bent ingelogd als <strong><?= htmlspecialchars($data['user_role']); ?></strong>
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <i class="bi bi-house-heart display-4 opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATISTIEKEN CARDS -->
            <div class="row mb-4">
                <!-- Totaal Klanten -->
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted mb-2">Totaal Gezinnen</h6>
                                    <h2 class="mb-0"><?= (int)($data['statistics']['totaal_klanten'] ?? 0); ?></h2>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people-fill text-primary fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($data['user_role'] === 'Manager'): ?>
                    <!-- Totaal Voedselpakketten -->
                    <div class="col-lg-3 col-sm-6 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-uppercase text-muted mb-2">Totaal Pakketten</h6>
                                        <h2 class="mb-0"><?= (int)($data['statistics']['totaal_voedselpakketten'] ?? 0); ?></h2>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-box-seam-fill text-success fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Uitgereikt Deze Maand -->
                    <div class="col-lg-3 col-sm-6 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-uppercase text-muted mb-2">Uitgereikt Deze Maand</h6>
                                        <h2 class="mb-0 text-success"><?= (int)($data['statistics']['uitgereikt_deze_maand'] ?? 0); ?></h2>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-check-circle-fill text-success fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nog Niet Uitgereikt -->
                    <div class="col-lg-3 col-sm-6 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="text-uppercase text-muted mb-2">Nog Niet Uitgereikt</h6>
                                        <h2 class="mb-0 text-warning"><?= (int)($data['statistics']['niet_uitgereikt'] ?? 0); ?></h2>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-clock-fill text-warning fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ACTIES SECTIE -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">
                                <i class="bi bi-lightning-fill me-2 text-primary"></i>
                                Snelle Acties
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Klanten Beheer -->
                                <div class="col-md-6">
                                    <a href="<?= URLROOT; ?>/klanten" class="btn btn-outline-primary btn-lg w-100 h-100 d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                                            <strong>Klanten Beheer</strong>
                                            <div class="small text-muted">Beheer klanten en gezinnen</div>
                                        </div>
                                    </a>
                                </div>

                                <?php if ($data['user_role'] === 'Manager'): ?>
                                    <!-- Voedselpakketten -->
                                    <div class="col-md-6">
                                        <a href="<?= URLROOT; ?>/voedselpakketten" class="btn btn-outline-success btn-lg w-100 h-100 d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                                <strong>Voedselpakketten</strong>
                                                <div class="small text-muted">Beheer voedselpakketten</div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if ($data['user_role'] === 'Manager' || $data['user_role'] === 'Medewerker'): ?>
                                    <!-- Leveranciers -->
                                    <div class="col-md-6">
                                        <a href="<?= URLROOT; ?>/leveranciers" class="btn btn-outline-info btn-lg w-100 h-100 d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <i class="bi bi-truck fs-1 d-block mb-2"></i>
                                                <strong>Leveranciers</strong>
                                                <div class="small text-muted">Beheer leveranciers</div>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Producten -->
                                    <div class="col-md-6">
                                        <a href="<?= URLROOT; ?>productenperleverancier" class="btn btn-outline-warning btn-lg w-100 h-100 d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <i class="bi bi-box fs-1 d-block mb-2"></i>
                                                <strong>Producten</strong>
                                                <div class="small text-muted">Beheer producten per leverancier</div>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RECENTE ACTIVITEITEN -->
                <?php if ($data['user_role'] === 'Manager' && !empty($data['statistics']['recent_activities'])): ?>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">
                                <i class="bi bi-clock-history me-2 text-info"></i>
                                Recente Activiteiten
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($data['statistics']['recent_activities'] as $activity): ?>
                                    <div class="list-group-item border-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    Pakket #<?= (int)$activity->PakketNummer; ?>
                                                </h6>
                                                <p class="mb-1 text-muted">
                                                    <?= htmlspecialchars($activity->GezinNaam ?? 'Onbekend gezin'); ?>
                                                </p>
                                                <small class="text-muted">
                                                    <?= date('d-m-Y H:i', strtotime($activity->UpdatedAt)); ?>
                                                </small>
                                            </div>
                                            <span class="badge <?php
                                                switch($activity->Status) {
                                                    case 'Uitgereikt': echo 'bg-success'; break;
                                                    case 'NietUitgereikt': echo 'bg-warning text-dark'; break;
                                                    default: echo 'bg-secondary';
                                                }
                                            ?> ms-2">
                                                <?php
                                                switch($activity->Status) {
                                                    case 'Uitgereikt': echo 'Uitgereikt'; break;
                                                    case 'NietUitgereikt': echo 'Niet uitgereikt'; break;
                                                    default: echo htmlspecialchars($activity->Status);
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <a href="<?= URLROOT; ?>voedselpakketten/overzicht" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-arrow-right me-1"></i>
                                Alle voedselpakketten bekijken
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- EXTRA INFO SECTIE -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-2">
                                        <i class="bi bi-info-circle me-2 text-info"></i>
                                        Welkom bij Voedselbank Maaskantje
                                    </h5>
                                    <p class="text-muted mb-0">
                                        Samen zorgen we ervoor dat niemand honger hoeft te lijden. 
                                        Gebruik de bovenstaande knoppen om door het systeem te navigeren.
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="text-muted">
                                        <small>Laatste login: <?= date('d-m-Y H:i'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- CUSTOM DASHBOARD STYLING -->
<style>
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-info:hover,
.btn-outline-warning:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
}

.list-group-item {
    transition: background-color 0.2s ease-in-out;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.display-4 {
    font-size: 2.5rem;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .btn-lg {
        font-size: 1rem;
    }
    
    .fs-1 {
        font-size: 1.5rem !important;
    }
}
</style>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>