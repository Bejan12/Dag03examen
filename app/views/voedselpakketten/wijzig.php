<?php
/**
 * WIJZIG VIEW - Voedselpakket status wijzigen
 * 
 * Deze view toont het formulier om de status van een voedselpakket te wijzigen
 * 
 * Functionaliteiten:
 * - Responsive formulier layout
 * - Voedselpakket informatie weergave
 * - Status dropdown met huidige selectie
 * - Scenario 2 waarschuwing (ZevenhuizenGezin pakket 3)
 * - CSRF beveiliging
 * - Auto-redirect na successful update
 * - Form validatie
 * 
 * Data verwacht van controller:
 * - $data['voedselpakket'] - Voedselpakket object
 * - $data['magGewijzigdWorden'] - Boolean of wijziging toegestaan is
 * - $data['isIngeschreven'] - Boolean of gezin nog ingeschreven is
 * - $data['csrf_token'] - CSRF token voor beveiliging
 * - $data['success_message'] - Success bericht (optioneel)
 * - $data['error_message'] - Error bericht (optioneel)
 * - $data['redirect_url'] - URL voor redirect na success (optioneel)
 * 
 * @author Voedselbank Maaskantje
 * @version 1.0
 */

// Laad header
require_once APPROOT . '/views/includes/header.php'; 
?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            
            <!-- SUCCESS/ERROR BERICHTEN SECTIE -->
            <!-- Success bericht met auto-redirect functionaliteit -->
            <?php if (isset($data['success_message']) && !empty($data['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                    <?= htmlspecialchars($data['success_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Error berichten -->
            <?php if (isset($data['error_message']) && !empty($data['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- HEADER SECTIE - Gecentreerde titel -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3>Wijzig voedselpakket status</h3>
                </div>
            </div>

            <!-- MAIN CONTENT - Gecentreerd formulier -->
            <div class="row justify-content-center">
                <!-- Responsive formulier container -->
                <div class="col-lg-6 col-md-8 col-12">
                    
                    <!-- Controleer of voedselpakket data beschikbaar is -->
                    <?php if (isset($data['voedselpakket']) && $data['voedselpakket']): ?>
                        
                        <!-- PAKKET INFORMATIE CARD - Responsive voedselpakket details -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Basis pakket informatie - linker helft -->
                                    <div class="col-md-6">
                                        <h5>Pakketnummer: <?= (int)$data['voedselpakket']->PakketNummer; ?></h5>
                                        <p><strong>Gezin:</strong> <?= htmlspecialchars($data['voedselpakket']->GezinNaam ?? ''); ?></p>
                                    </div>
                                    
                                    <!-- Status informatie - rechter helft -->
                                    <div class="col-md-6">
                                        <p><strong>Huidige status:</strong></p>
                                        <!-- Status badge met kleurcodering -->
                                        <span class="badge <?php
                                            // Bepaal badge kleur op basis van status
                                            switch($data['voedselpakket']->Status) {
                                                case 'NietUitgereikt': echo 'bg-warning text-dark'; break;
                                                case 'Uitgereikt': echo 'bg-success'; break;
                                                case 'NietMeerIngeschreven': echo 'bg-danger'; break;
                                                default: echo 'bg-secondary';
                                            }
                                        ?>">
                                            <?php
                                            // Nederlandse status tekst
                                            switch($data['voedselpakket']->Status) {
                                                case 'NietUitgereikt': echo 'Niet uitgereikt'; break;
                                                case 'Uitgereikt': echo 'Uitgereikt'; break;
                                                case 'NietMeerIngeschreven': echo 'Niet meer ingeschreven'; break;
                                                default: echo htmlspecialchars($data['voedselpakket']->Status);
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SCENARIO 2 WAARSCHUWING -->
                        <!-- Toon waarschuwing als wijziging niet toegestaan is -->
                        <?php if (!$data['magGewijzigdWorden']): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt
                            </div>
                        <?php endif; ?>

                        <!-- STATUS WIJZIG FORMULIER -->
                        <!-- Toon alleen formulier als nog geen success bericht -->
                        <?php if (!isset($data['success_message']) || empty($data['success_message'])): ?>
                        <form method="POST" action="<?= URLROOT; ?>/voedselpakketten/updateStatus" id="statusForm">
                            
                            <!-- HIDDEN FIELDS - Beveiliging en identificatie -->
                            <!-- CSRF token voor beveiliging tegen cross-site request forgery -->
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token'] ?? ''); ?>">
                            <!-- Voedselpakket ID voor update -->
                            <input type="hidden" name="voedselpakket_id" value="<?= (int)$data['voedselpakket']->Id; ?>">
                            
                            <!-- STATUS DROPDOWN -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select name="status" id="status" class="form-select" 
                                        <?= !$data['magGewijzigdWorden'] ? 'disabled' : ''; ?>>
                                    
                                    <!-- Niet uitgereikt optie -->
                                    <option value="NietUitgereikt" 
                                        <?= ($data['voedselpakket']->Status === 'NietUitgereikt') ? 'selected' : ''; ?>>
                                        Niet uitgereikt
                                    </option>
                                    
                                    <!-- Uitgereikt optie -->
                                    <option value="Uitgereikt" 
                                        <?= ($data['voedselpakket']->Status === 'Uitgereikt') ? 'selected' : ''; ?>>
                                        Uitgereikt
                                    </option>
                                </select>
                            </div>

                            <!-- FORMULIER KNOPPEN - Responsive button layout -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <!-- Submit knop - disabled als wijziging niet toegestaan -->
                                <button type="submit" class="btn btn-primary" 
                                        <?= !$data['magGewijzigdWorden'] ? 'disabled' : ''; ?>>
                                    Wijzig status voedselpakket
                                </button>
                                
                                <!-- Terug naar details knop -->
                                <a href="<?= URLROOT; ?>/voedselpakketten/details/<?= (int)$data['voedselpakket']->GezinId; ?>" 
                                   class="btn btn-secondary">Terug</a>
                                
                                <!-- Home knop -->
                                <a href="<?= URLROOT; ?>/homepages/index" class="btn btn-secondary">Home</a>
                            </div>
                        </form>
                        
                        <?php else: ?>
                            <!-- SUCCESS STATE - Toon na succesvolle wijziging -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <p class="text-center w-100">U wordt automatisch doorverwezen...</p>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- ERROR STATE - Voedselpakket niet gevonden -->
                        <div class="alert alert-danger">
                            Voedselpakket niet gevonden.
                        </div>
                        
                        <!-- Terug naar overzicht knop -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="<?= URLROOT; ?>/voedselpakketten" class="btn btn-secondary">Terug naar overzicht</a>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>

        </div>
    </div>
</div>

<!-- JAVASCRIPT SECTIE -->
<script>
// DOM ready functie
document.addEventListener('DOMContentLoaded', function() {
    
    // AUTO-REDIRECT FUNCTIONALITEIT
    // Redirect automatisch na success bericht
    const successAlert = document.getElementById('successAlert');
    
    if (successAlert) {
        setTimeout(function() {
            // Gebruik redirect URL uit data of fallback naar overzicht
            <?php if (isset($data['redirect_url']) && !empty($data['redirect_url'])): ?>
                window.location.href = '<?= $data['redirect_url']; ?>';
            <?php else: ?>
                window.location.href = '<?= URLROOT; ?>/voedselpakketten';
            <?php endif; ?>
        }, 3000); // 3 seconden delay
    }
    
  // FORM VALIDATIE
    const form = document.getElementById('statusForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Haal geselecteerde status op
            const status = document.getElementById('status').value;
            
            // Valideer dat een status is geselecteerd
            if (!status) {
                e.preventDefault(); // Stop form submission
                alert('Selecteer een status');
                return false;
            }
            
            // EXTRA BEVESTIGING WEGGEHAALD!
            // Nu wordt er geen confirm() dialog meer getoond
            
            // Als alles OK, ga door met submit
            return true;
        });
    }
    
    // KEYBOARD NAVIGATION
    // Voeg keyboard shortcuts toe voor betere accessibility
    document.addEventListener('keydown', function(e) {
        // ESC key = ga terug
        if (e.key === 'Escape') {
            const terugLink = document.querySelector('a.btn-secondary');
            if (terugLink) {
                window.location.href = terugLink.href;
            }
        }
        
        // Enter key = submit form (als form actief is)
        if (e.key === 'Enter' && e.target.tagName !== 'BUTTON') {
            const submitButton = document.querySelector('button[type="submit"]');
            if (submitButton && !submitButton.disabled) {
                submitButton.click();
            }
        }
    });
    
    // FOCUS MANAGEMENT
    // Focus op status dropdown bij pagina load
    const statusSelect = document.getElementById('status');
    if (statusSelect && !statusSelect.disabled) {
        statusSelect.focus();
    }
});
</script>

<?php 
// Laad footer
require_once APPROOT . '/views/includes/footer.php'; 
?>