<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-success">Overzicht Klanten</h2>

            <!-- Filter sectie volgens wireframe -->
            <div class="row mb-4 justify-content-end">
                <div class="col-md-1 col-lg-2">
                    <label for="postcodeFilter" class="form-label">Selecteer Postcode</label>
                    <select class="form-select" id="postcodeFilter">
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
                    <button class="btn btn-primary" id="toonKlantenBtn">Toon Klanten</button>
                </div>
            </div>

            <!-- Klanten Tabel volgens wireframe -->
            <?php if (empty($data['klanten'])): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Er zijn nog geen klanten geregistreerd.
                </div>
            <?php else: ?>
                <div class="table-responsive" id="klantenTableContainer">
                    <table class="table table-striped table-bordered" id="klantenTable">
                        <thead class="table-light">
                            <tr>
                                <th>Naam Gezin</th>
                                <th>Vertegenwoordiger</th>
                                <th>E-mailadres</th>
                                <th>Mobiel</th>
                                <th>Adres</th>
                                <th>Woonplaats</th>
                                <th>Klant Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Error row voor unhappy scenario -->
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="7" class="text-center p-3" style="background-color: #fff3cd; color: #856404;">
                                    Er zijn geen klanten bekend die de geselecteerde postcode hebben
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
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Postcode filter functionaliteit
document.getElementById('toonKlantenBtn').addEventListener('click', function() {
    filterByPostcode();
});

function filterByPostcode() {
    const selectedPostcode = document.getElementById('postcodeFilter').value;
    const tableRows = document.querySelectorAll('#klantenTable tbody tr.klant-row');
    const noResultsRow = document.getElementById('noResultsRow');

    let visibleRows = 0;

    tableRows.forEach(row => {
        const rowPostcode = row.getAttribute('data-postcode');

        if (selectedPostcode === '' || rowPostcode === selectedPostcode) {
            row.style.display = '';
            visibleRows++;
        } else {
            row.style.display = 'none';
        }
    });

    // Toon error row als er geen resultaten zijn bij een specifieke postcode selectie
    if (selectedPostcode !== '' && visibleRows === 0) {
        noResultsRow.style.display = '';
    } else {
        noResultsRow.style.display = 'none';
    }
}

// Initieel alle klanten tonen
document.addEventListener('DOMContentLoaded', function() {
    // Toon alle klanten bij het laden van de pagina
    const tableRows = document.querySelectorAll('#klantenTable tbody tr.klant-row');
    const noResultsRow = document.getElementById('noResultsRow');
    
    tableRows.forEach(row => {
        row.style.display = '';
    });
    
    noResultsRow.style.display = 'none';
});
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
