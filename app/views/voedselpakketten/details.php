<?php
/**
 * DETAILS VIEW - Voedselpakketten details per gezin
 * 
 * Deze view toont alle voedselpakketten behorend bij een specifiek gezin
 * 
 * Functionaliteiten:
 * - Gezin informatie card
 * - Responsieve tabel met voedselpakketten voor desktop
 * - Card layout voor voedselpakketten op mobiel/tablet
 * - Status weergave zonder kleurtjes (zoals gevraagd)
 * - Datum formatting (DD-MM-YYYY)
 * - Wijzig status links per pakket
 * 
 * Data verwacht van controller:
 * - $data['gezin'] - Gezin object met details
 * - $data['voedselpakketten'] - Array met voedselpakketten
 * - $data['success_message'] - Success bericht (optioneel)
 * - $data['error_message'] - Error bericht (optioneel)
 * 
 * @author Voedselbank Maaskantje
 * @version 1.0
 */

// Laad header met Bootstrap en navigatie
require_once APPROOT . '/views/includes/header.php'; 
?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            
            <!-- SUCCESS/ERROR BERICHTEN SECTIE -->
            <!-- Success melding met auto-hide functionaliteit -->
            <?php if (isset($data['success_message']) && !empty($data['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                    <?= htmlspecialchars($data['success_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Error melding -->
            <?php if (isset($data['error_message']) && !empty($data['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- HEADER SECTIE - Responsive header met titel en navigatie -->
            <div class="row mb-4">
                <!-- Titel sectie -->
                <div class="col-md-8">
                    <h3 class="text-success">Overzicht voedselpakketten</h3>
                </div>
                
                <!-- Navigatie knoppen - stapelen op mobiel -->
                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                    <a href="<?= URLROOT; ?>voedselpakketten/overzicht" class="btn btn-secondary me-2">Terug</a>
                    <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">Home</a>
                </div>
            </div>

            <!-- GEZIN INFORMATIE CARD - Responsive gezin details -->
            <?php if (isset($data['gezin']) && $data['gezin']): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Basis informatie - linker helft -->
                                    <div class="col-md-6">
                                        <h5>Naam</h5>
                                        <p><?= htmlspecialchars($data['gezin']->Naam ?? ''); ?></p>
                                        
                                        <h5>Omschrijving</h5>
                                        <p><?= htmlspecialchars($data['gezin']->Omschrijving ?? ''); ?></p>
                                    </div>
                                    
                                    <!-- Samenstelling informatie - rechter helft -->
                                    <div class="col-md-6">
                                        <h5>Totaal aantal personen</h5>
                                        <p><?= (int)($data['gezin']->TotaalAantalPersonen ?? 0); ?></p>
                                        
                                        <h5>Samenstelling</h5>
                                        <p>
                                            <?= (int)($data['gezin']->AantalVolwassenen ?? 0); ?> volwassenen, 
                                            <?= (int)($data['gezin']->AantalKinderen ?? 0); ?> kinderen, 
                                            <?= (int)($data['gezin']->AantalBabys ?? 0); ?> baby's
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- VOEDSELPAKKETTEN SECTIE TITEL -->
            <h4 class="mb-3">Voedselpakketten</h4>

            <!-- DESKTOP TABEL VIEW - Alleen zichtbaar op large+ schermen -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pakketnummer</th>
                            <th>Datum samenstelling</th>
                            <th>Datum uitgifte</th>
                            <th>Status</th>
                            <th>Aantal producten</th>
                            <th>Wijzig status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Controleer of er voedselpakketten zijn -->
                        <?php if (isset($data['voedselpakketten']) && !empty($data['voedselpakketten'])): ?>
                            <!-- Loop door alle voedselpakketten -->
                            <?php foreach($data['voedselpakketten'] as $pakket): ?>
                               <tr>
                                    <!-- Pakketnummer - cast naar int -->
                                    <td><?= (int)$pakket->PakketNummer; ?></td>
                                    
                                    <!-- Datum samenstelling - Nederlandse format (DD-MM-YYYY) -->
                                    <td><?= $pakket->DatumSamenstelling ? date('d-m-Y', strtotime($pakket->DatumSamenstelling)) : '-'; ?></td>
                                    
                                    <!-- Datum uitgifte - Nederlandse format -->
                                    <td><?= $pakket->DatumUitgifte ? date('d-m-Y', strtotime($pakket->DatumUitgifte)) : '-'; ?></td>
                                    
                                    <!-- Status - Nederlandse tekst zonder kleurtjes -->
                                    <td>
                                        <?php
                                        // Switch voor Nederlandse status weergave
                                        switch($pakket->Status) {
                                            case 'NietUitgereikt':
                                                echo 'Niet uitgereikt';
                                                break;
                                            case 'Uitgereikt':
                                                echo 'Uitgereikt';
                                                break;
                                            case 'NietMeerIngeschreven':
                                                echo 'Niet meer ingeschreven';
                                                break;
                                            default:
                                                // Fallback voor onbekende status
                                                echo htmlspecialchars($pakket->Status);
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Aantal producten -->
                                    <td><?= (int)($pakket->AantalProducten ?? 0); ?></td>
                                    
                                    <!-- Wijzig status link -->
                                    <td>
                                        <a href="<?= URLROOT; ?>voedselpakketten/wijzigStatus/<?= (int)$pakket->Id; ?>" 
                                           class="btn btn-sm btn-warning" title="Wijzig status">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Geen voedselpakketten gevonden -->
                            <tr>
                                <td colspan="6" class="text-center">Geen voedselpakketten gevonden</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE/TABLET CARD VIEW -->
            <!-- Alleen zichtbaar op small/medium schermen -->
            <div class="d-block d-lg-none">
                <?php if (isset($data['voedselpakketten']) && !empty($data['voedselpakketten'])): ?>
                    <!-- Loop door voedselpakketten voor card weergave -->
                    <?php foreach($data['voedselpakketten'] as $pakket): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Informatie sectie - 2/3 breedte -->
                                    <div class="col-8">
                                        <!-- Pakketnummer als titel -->
                                        <h5 class="card-title">Pakket #<?= (int)$pakket->PakketNummer; ?></h5>
                                        
                                        <!-- Datum samenstelling -->
                                        <p class="card-text mb-1">
                                            <strong>Samenstelling:</strong><br>
                                            <small><?= $pakket->DatumSamenstelling ? date('d-m-Y', strtotime($pakket->DatumSamenstelling)) : '-'; ?></small>
                                        </p>
                                        
                                        <!-- Datum uitgifte -->
                                        <p class="card-text mb-1">
                                            <strong>Uitgifte:</strong><br>
                                            <small><?= $pakket->DatumUitgifte ? date('d-m-Y', strtotime($pakket->DatumUitgifte)) : '-'; ?></small>
                                        </p>
                                        
                                        <!-- Status met badge kleuren voor mobile (voor betere UX) -->
                                        <p class="card-text mb-1">
                                            <strong>Status:</strong> 
                                            <span class="badge <?php
                                                // Badge kleuren voor mobiele weergave
                                                switch($pakket->Status) {
                                                    case 'NietUitgereikt': echo 'bg-warning text-dark'; break;
                                                    case 'Uitgereikt': echo 'bg-success'; break;
                                                    case 'NietMeerIngeschreven': echo 'bg-danger'; break;
                                                    default: echo 'bg-secondary';
                                                }
                                            ?>">
                                                <?php
                                                // Nederlandse tekst in badge
                                                switch($pakket->Status) {
                                                    case 'NietUitgereikt': echo 'Niet uitgereikt'; break;
                                                    case 'Uitgereikt': echo 'Uitgereikt'; break;
                                                    case 'NietMeerIngeschreven': echo 'Niet meer ingeschreven'; break;
                                                    default: echo htmlspecialchars($pakket->Status);
                                                }
                                                ?>
                                            </span>
                                        </p>
                                        
                                        <!-- Aantal producten -->
                                        <p class="card-text mb-0">
                                            <strong>Producten:</strong> <?= (int)($pakket->AantalProducten ?? 0); ?>
                                        </p>
                                    </div>
                                    
                                    <!-- Actie sectie - 1/3 breedte -->
                                    <div class="col-4 text-end">
                                        <a href="<?= URLROOT; ?>voedselpakketten/wijzigStatus/<?= (int)$pakket->Id; ?>" 
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i><br>
                                            <small>Wijzig</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Geen voedselpakketten alert voor mobile -->
                    <div class="alert alert-info text-center">
                        Geen voedselpakketten gevonden
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<!-- JAVASCRIPT SECTIE -->
<script>
// DOM ready functie
document.addEventListener('DOMContentLoaded', function() {
    
    // AUTO-HIDE SUCCESS ALERT
    // Verberg success alert automatisch na 3 seconden
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000);
    }
    
    // FORM VALIDATIE
    // Voeg eventuele form validatie toe voor toekomstige functionaliteiten
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            // Hier kun je custom validatie toevoegen indien nodig
        });
    });
});
</script>

<?php 
// Laad footer
require_once APPROOT . '/views/includes/footer.php'; 
?>