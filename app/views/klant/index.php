<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-success">Overzicht Klanten</h2>

            <!-- Filter sectie volgens wireframe -->
            <div class="row mb-4 justify-content-end">
                <div class="col-md-3 col-lg-2">
                    <label for="postcodeFilter" class="form-label">Selecteer Postcode</label>
                    <select class="form-select form-select-sm" id="postcodeFilter">
                        <option value="">Alle postcodes</option>
                        <?php 
                        $postcodes = [];
                        if (!empty($data['klanten'])) {
                            foreach ($data['klanten'] as $klant) {
                                if (!empty($klant->Postcode) && !in_array($klant->Postcode, $postcodes)) {
                                    $postcodes[] = $klant->Postcode;
                                }
                            }
                            sort($postcodes);
                            foreach ($postcodes as $postcode) {
                                echo '<option value="' . htmlspecialchars($postcode) . '">' . htmlspecialchars($postcode) . '</option>';
                            }
                        }
                        ?>
                        <!-- Dummy postcode voor testing unhappy scenario -->
                        <option value="5271ZH">5271ZH</option>
                    </select>
                </div>
                <div class="col-auto d-flex align-items-end">
                    <button class="btn btn-primary btn-sm" id="toonKlantenBtn">Toon Klanten</button>
                </div>
            </div>

            <!-- Klanten Tabel volgens wireframe -->
            <?php if (empty($data['klanten'])): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Er zijn nog geen klanten geregistreerd.
                </div>
            <?php else: ?>
                <!-- Desktop Tabel (normaal) -->
                <div class="table-responsive d-none d-md-block" id="klantenTableContainer">
                    <table class="table table-striped table-bordered table-sm" id="klantenTable">
                        <thead class="table-light">
                            <tr>
                                <th>Naam Gezin</th>
                                <th>Vertegenwoordiger</th>
                                <th>E-mailadres</th>
                                <th>Mobiel</th>
                                <th>Adres</th>
                                <th>Woonplaats</th>
                                <th class="text-center">Klant Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Error row voor unhappy scenario -->
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="7" class="text-center p-2 text-warning" style="background-color: #fff3cd;">
                                    <small>Er zijn geen klanten bekend die de geselecteerde postcode hebben</small>
                                </td>
                            </tr>

                            <?php foreach ($data['klanten'] as $klant): ?>
                                <tr data-postcode="<?= htmlspecialchars($klant->Postcode ?? ''); ?>" class="klant-row">
                                    <td><?= htmlspecialchars($klant->GezinNaam); ?></td>
                                    <td>
                                        <?php if (!empty($klant->Voornaam)): ?>
                                            <?= htmlspecialchars($klant->Voornaam); ?>
                                            <?= !empty($klant->Tussenvoegsel) ? ' ' . htmlspecialchars($klant->Tussenvoegsel) : ''; ?>
                                            <?= ' ' . htmlspecialchars($klant->Achternaam); ?>
                                        <?php else: ?>
                                            ~~/~~
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($klant->Email)): ?>
                                            <?= htmlspecialchars($klant->Email); ?>
                                        <?php else: ?>
                                            ~~/~~
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($klant->Mobiel)): ?>
                                            <?= htmlspecialchars($klant->Mobiel); ?>
                                        <?php else: ?>
                                            ~~/~~
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($klant->Straat)): ?>
                                            <?= htmlspecialchars($klant->Straat); ?> 
                                            <?= htmlspecialchars($klant->Huisnummer); ?>
                                            <?= !empty($klant->Toevoeging) ? htmlspecialchars($klant->Toevoeging) : ''; ?>
                                        <?php else: ?>
                                            ~~/~~
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($klant->Woonplaats)): ?>
                                            <?= htmlspecialchars($klant->Woonplaats); ?>
                                        <?php else: ?>
                                            ~~/~~
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= URLROOT; ?>/klanten/details/<?= $klant->GezinId; ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mobiele Card Layout -->
                <div class="d-md-none" id="klantenCardsContainer">
                    <!-- Error message voor mobiel -->
                    <div id="noResultsCard" style="display: none;" class="alert alert-warning">
                        <small>Er zijn geen klanten bekend die de geselecteerde postcode hebben</small>
                    </div>

                    <?php foreach ($data['klanten'] as $klant): ?>
                        <div class="card mb-3 klant-card" data-postcode="<?= htmlspecialchars($klant->Postcode ?? ''); ?>">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <h6 class="card-title mb-2 text-primary">
                                            <?= htmlspecialchars($klant->GezinNaam); ?>
                                        </h6>
                                        <div class="mb-2">
                                            <strong>Vertegenwoordiger:</strong><br>
                                            <small>
                                                <?php if (!empty($klant->Voornaam)): ?>
                                                    <?= htmlspecialchars($klant->Voornaam); ?>
                                                    <?= !empty($klant->Tussenvoegsel) ? ' ' . htmlspecialchars($klant->Tussenvoegsel) : ''; ?>
                                                    <?= ' ' . htmlspecialchars($klant->Achternaam); ?>
                                                <?php else: ?>
                                                    ~~/~~
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <a href="<?= URLROOT; ?>/klanten/details/<?= $klant->GezinId; ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="row text-muted">
                                    <div class="col-6">
                                        <?php if (!empty($klant->Email)): ?>
                                            <div class="mb-1">
                                                <i class="bi bi-envelope me-1"></i>
                                                <small><?= htmlspecialchars($klant->Email); ?></small>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($klant->Mobiel)): ?>
                                            <div class="mb-1">
                                                <i class="bi bi-phone me-1"></i>
                                                <small><?= htmlspecialchars($klant->Mobiel); ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-6">
                                        <?php if (!empty($klant->Straat)): ?>
                                            <div class="mb-1">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                <small>
                                                    <?= htmlspecialchars($klant->Straat); ?> 
                                                    <?= htmlspecialchars($klant->Huisnummer); ?>
                                                    <?= !empty($klant->Toevoeging) ? ' ' . htmlspecialchars($klant->Toevoeging) : ''; ?>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($klant->Woonplaats)): ?>
                                            <div class="mb-1">
                                                <small><?= htmlspecialchars($klant->Woonplaats); ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Extra responsive styling voor kleinere schermen */
@media (max-width: 576px) {
    .container-fluid {
        padding: 0.5rem;
    }
    
    .table-sm th,
    .table-sm td {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    h2 {
        font-size: 1.5rem;
        margin-bottom: 1rem !important;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .form-select-sm {
        font-size: 0.875rem;
    }
    
    .table-responsive {
        border: none;
    }
}

@media (max-width: 430px) {
    .container-fluid {
        padding: 0.25rem;
    }
    
    .table-sm th,
    .table-sm td {
        padding: 0.2rem 0.3rem;
        font-size: 0.8rem;
        vertical-align: middle;
    }
    
    h2 {
        font-size: 1.25rem;
        text-align: center;
    }
    
    .row.mb-4 {
        margin-bottom: 1rem !important;
    }
    
    .btn-sm {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
    
    .bi-eye {
        font-size: 0.9rem;
    }
}
</style>

<script>
// Postcode filter functionaliteit voor beide desktop tabel en mobiele cards
document.getElementById('toonKlantenBtn').addEventListener('click', function() {
    filterByPostcode();
});

function filterByPostcode() {
    const selectedPostcode = document.getElementById('postcodeFilter').value;
    
    // Filter desktop tabel rijen
    const tableRows = document.querySelectorAll('#klantenTable tbody tr.klant-row');
    const noResultsRow = document.getElementById('noResultsRow');
    
    // Filter mobiele cards
    const cards = document.querySelectorAll('.klant-card');
    const noResultsCard = document.getElementById('noResultsCard');

    let visibleRows = 0;
    let visibleCards = 0;

    // Filter tabel rijen (desktop)
    tableRows.forEach(row => {
        const rowPostcode = row.getAttribute('data-postcode');

        if (selectedPostcode === '' || rowPostcode === selectedPostcode) {
            row.style.display = '';
            visibleRows++;
        } else {
            row.style.display = 'none';
        }
    });

    // Filter cards (mobiel)
    cards.forEach(card => {
        const cardPostcode = card.getAttribute('data-postcode');

        if (selectedPostcode === '' || cardPostcode === selectedPostcode) {
            card.style.display = '';
            visibleCards++;
        } else {
            card.style.display = 'none';
        }
    });

    // Toon error messages als er geen resultaten zijn bij een specifieke postcode selectie
    if (selectedPostcode !== '' && visibleRows === 0) {
        noResultsRow.style.display = '';
    } else {
        noResultsRow.style.display = 'none';
    }

    if (selectedPostcode !== '' && visibleCards === 0) {
        noResultsCard.style.display = '';
    } else {
        noResultsCard.style.display = 'none';
    }
}

// Initieel alle klanten tonen
document.addEventListener('DOMContentLoaded', function() {
    // Toon alle tabel rijen bij het laden van de pagina
    const tableRows = document.querySelectorAll('#klantenTable tbody tr.klant-row');
    const noResultsRow = document.getElementById('noResultsRow');
    
    tableRows.forEach(row => {
        row.style.display = '';
    });
    
    noResultsRow.style.display = 'none';

    // Toon alle cards bij het laden van de pagina
    const cards = document.querySelectorAll('.klant-card');
    const noResultsCard = document.getElementById('noResultsCard');
    
    cards.forEach(card => {
        card.style.display = '';
    });
    
    noResultsCard.style.display = 'none';
});
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
