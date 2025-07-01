<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-success">Overzicht Klanten</h2>
            
            <!-- Filter sectie volgens wireframe -->
            <div class="row mb-4">
                <div class="col-md-3">
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
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
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
                <div class="table-responsive">
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
                            <?php foreach ($data['klanten'] as $klant): ?>
                                <tr data-postcode="<?= htmlspecialchars($klant->Postcode ?? ''); ?>">
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
document.getElementById('postcodeFilter').addEventListener('change', function() {
    filterByPostcode();
});

document.getElementById('toonKlantenBtn').addEventListener('click', function() {
    filterByPostcode();
});

function filterByPostcode() {
    const selectedPostcode = document.getElementById('postcodeFilter').value;
    const tableRows = document.querySelectorAll('#klantenTable tbody tr');
    
    tableRows.forEach(row => {
        const rowPostcode = row.getAttribute('data-postcode');
        
        if (selectedPostcode === '' || rowPostcode === selectedPostcode) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Initieel alle klanten tonen
document.addEventListener('DOMContentLoaded', function() {
    filterByPostcode();
});
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
