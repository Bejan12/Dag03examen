<?php
/**
 * INDEX VIEW - Voedselpakketten hoofdpagina
 * 
 * Deze view toont het overzicht van alle gezinnen met voedselpakketten
 * 
 * Functionaliteiten:
 * - Responsieve tabel voor desktop/laptop
 * - Card layout voor tablet/mobiel
 * - Filter dropdown voor eetwensen
 * - Success/error berichten weergave
 * - Handmatige submit via knop (GEEN auto-submit meer)
 * 
 * Data verwacht van controller:
 * - $data['gezinnen'] - Array met gezinnen
 * - $data['eetwensen'] - Array met eetwensen voor filter
 * - $data['selectedEetwens'] - Geselecteerde eetwens ID
 * - $data['success_message'] - Success bericht (optioneel)
 * - $data['error_message'] - Error bericht (optioneel)
 * 
 * @author Voedselbank Maaskantje
 * @version 1.0
 */

// Laad de header inclusief Bootstrap CSS en navigatie
require_once APPROOT . '/views/includes/header.php'; 
?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            
            <!-- SUCCESS/ERROR BERICHTEN SECTIE -->
            <!-- Toon success bericht als deze bestaat in sessie -->
            <?php if (isset($data['success_message']) && !empty($data['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['success_message']); ?>
                    <!-- Bootstrap dismiss knop voor sluiten alert -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Toon error bericht als deze bestaat in sessie -->
            <?php if (isset($data['error_message']) && !empty($data['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- HEADER SECTIE - Responsive header met titel en filter -->
            <div class="row mb-4">
                <!-- Titel sectie - neemt halve breedte op medium+ schermen -->
                <div class="col-md-6 mb-2 mb-md-0">
                    <h3 class="text-success">Overzicht gezinnen met voedselpakketten</h3>
                </div>
                
                <!-- Filter sectie - neemt andere helft, stapelt op kleine schermen -->
                <div class="col-md-6">
                    <!-- Form voor eetwens filtering -->
                    <form method="GET" action="<?= URLROOT; ?>voedselpakketten/filterByEetwens" 
                          class="d-flex flex-column flex-md-row justify-content-md-end" id="eetwensForm">
                        
                        <!-- Dropdown voor eetwens selectie -->
                        <select name="eetwens" class="form-select me-md-2 mb-2 mb-md-0" id="eetwensSelect">
                            <option value="">Selecteer eetwens</option>
                            
                            <!-- Loop door alle beschikbare eetwensen -->
                            <?php if (isset($data['eetwensen']) && is_array($data['eetwensen'])): ?>
                                <?php foreach($data['eetwensen'] as $eetwens): ?>
                                    <option value="<?= (int)$eetwens->Id; ?>" 
                                        <?= (isset($data['selectedEetwens']) && $data['selectedEetwens'] == $eetwens->Id) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($eetwens->EetwensNaam); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        
                        <!-- Submit knop voor filter -->
                        <button type="submit" class="btn btn-primary">Toon gezinnen</button>
                    </form>
                </div>
            </div>

            <!-- DESKTOP TABEL VIEW -->
            <!-- Alleen zichtbaar op large+ schermen (≥992px) -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Gezinsnaam</th>
                            <th>Omschrijving</th>
                            <th>Volwassenen</th>
                            <th>Kinderen</th>
                            <th>Baby's</th>
                            <th>Vertegenwoordiger</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Controleer of er gezinnen zijn om te tonen -->
                        <?php if (isset($data['gezinnen']) && !empty($data['gezinnen'])): ?>
                            <!-- Loop door alle gezinnen -->
                            <?php foreach($data['gezinnen'] as $gezin): ?>
                                <tr>
                                    <!-- Gezinsnaam - gebruik htmlspecialchars voor XSS beveiliging -->
                                    <td><?= htmlspecialchars($gezin->GezinNaam ?? ''); ?></td>
                                    
                                    <!-- Omschrijving -->
                                    <td><?= htmlspecialchars($gezin->Omschrijving ?? ''); ?></td>
                                    
                                    <!-- Aantal personen - cast naar int voor veiligheid -->
                                    <td><?= (int)($gezin->AantalVolwassenen ?? 0); ?></td>
                                    <td><?= (int)($gezin->AantalKinderen ?? 0); ?></td>
                                    <td><?= (int)($gezin->AantalBabys ?? 0); ?></td>
                                    
                                    <!-- Vertegenwoordiger met fallback -->
                                    <td><?= htmlspecialchars($gezin->Vertegenwoordiger ?? 'Niet ingesteld'); ?></td>
                                    
                                    <!-- Details link naar specifiek gezin -->
                                    <td>
                                        <a href="<?= URLROOT; ?>voedselpakketten/details/<?= (int)$gezin->Id; ?>" 
                                           class="btn btn-sm btn-primary">Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Toon bericht als geen gezinnen gevonden -->
                            <tr>
                                <td colspan="7" class="text-center">
                                    <!-- Verschillende berichten afhankelijk van filter status -->
                                    <?php if (isset($data['selectedEetwens']) && $data['selectedEetwens'] > 0): ?>
                                        <div class="alert" style="background-color: #ffe4e1; border-color: #ffc0cb; color: #8b0000;">
                                            Er zijn geen gezinnen bekend die de geselecteerde eetwens hebben
                                        </div>
                                    <?php else: ?>
                                        Geen gezinnen gevonden
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE/TABLET CARD VIEW -->
            <!-- Alleen zichtbaar op small/medium schermen (<992px) -->
            <div class="d-block d-lg-none">
                <?php if (isset($data['gezinnen']) && !empty($data['gezinnen'])): ?>
                    <!-- Loop door gezinnen voor card weergave -->
                    <?php foreach($data['gezinnen'] as $gezin): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Informatie sectie - 2/3 van de breedte -->
                                    <div class="col-8">
                                        <!-- Gezinsnaam als card titel -->
                                        <h5 class="card-title"><?= htmlspecialchars($gezin->GezinNaam ?? ''); ?></h5>
                                        
                                        <!-- Compacte informatie weergave -->
                                        <p class="card-text">
                                            <strong>Omschrijving:</strong> <?= htmlspecialchars($gezin->Omschrijving ?? ''); ?><br>
                                            <strong>Personen:</strong> 
                                            <?= (int)($gezin->AantalVolwassenen ?? 0); ?> volw. | 
                                            <?= (int)($gezin->AantalKinderen ?? 0); ?> kind. | 
                                            <?= (int)($gezin->AantalBabys ?? 0); ?> baby's<br>
                                            <strong>Vertegenwoordiger:</strong> <?= htmlspecialchars($gezin->Vertegenwoordiger ?? 'Niet ingesteld'); ?>
                                        </p>
                                    </div>
                                    
                                    <!-- Actie sectie - 1/3 van de breedte, rechts uitgelijnd -->
                                    <div class="col-4 text-end">
                                        <a href="<?= URLROOT; ?>voedselpakketten/details/<?= (int)$gezin->Id; ?>" 
                                           class="btn btn-primary btn-sm">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Alert voor geen gevonden gezinnen in card view -->
                    <div class="alert alert-info text-center">
                        <?php if (isset($data['selectedEetwens']) && $data['selectedEetwens'] > 0): ?>
                            Er zijn geen gezinnen bekend die de geselecteerde eetwens hebben
                        <?php else: ?>
                            Geen gezinnen gevonden
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- HOME KNOP SECTIE -->
            <!-- Gecentreerd op mobiel, links uitgelijnd op desktop -->
            <div class="mt-3 text-center text-md-start">
                <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">Home</a>
            </div>

        </div>
    </div>
</div>

<!-- JAVASCRIPT SECTIE -->
<script>
// Wacht tot DOM volledig geladen is
document.addEventListener('DOMContentLoaded', function() {
    
    // GEEN AUTO-SUBMIT MEER!
    // De gebruiker moet nu handmatig op "Toon gezinnen" klikken
    
    // RESET KNOP FUNCTIONALITEIT
    // Als gebruiker "Selecteer eetwens" kiest, toon alle gezinnen
    const eetwensForm = document.getElementById('eetwensForm');
    const eetwensSelect = document.getElementById('eetwensSelect');
    
    if (eetwensForm && eetwensSelect) {
        eetwensForm.addEventListener('submit', function(e) {
            // Als geen eetwens geselecteerd, ga naar hoofdpagina
            if (eetwensSelect.value === '') {
                e.preventDefault(); // Stop normale submit
                window.location.href = '<?= URLROOT; ?>voedselpakketten';
            }
            // Anders laat normale submit gebeuren
        });
    }
    
    // BEVESTIGING VOOR DELETE ACTIES
    // Voeg bevestiging toe aan eventuele delete knoppen
    document.querySelectorAll('.btn-danger').forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Weet je zeker dat je deze actie wilt uitvoeren?')) {
                e.preventDefault();
            }
        });
    });
    
    // KEYBOARD SHORTCUTS
    // Enter key in dropdown = submit form
    if (eetwensSelect) {
        eetwensSelect.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                eetwensForm.submit();
            }
        });
    }
});
</script>

<?php 
// Laad de footer inclusief Bootstrap JS
require_once APPROOT . '/views/includes/footer.php'; 
?>