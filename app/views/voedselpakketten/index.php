<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            
            <!-- Success/Error messages -->
            <?php if (isset($data['success_message']) && !empty($data['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['success_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($data['error_message']) && !empty($data['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Header section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h3 class="text-success">Overzicht gezinnen</h3>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="<?= URLROOT; ?>voedselpakketten/filterByEetwens" 
                          class="d-flex justify-content-end" id="eetwensForm">
                        <select name="eetwens" class="form-select me-2" style="width: auto;" id="eetwensSelect">
                            <option value="">Selecteer eetwens</option>
                            <?php if (isset($data['eetwensen']) && is_array($data['eetwensen'])): ?>
                                <?php foreach($data['eetwensen'] as $eetwens): ?>
                                    <option value="<?= (int)$eetwens->Id; ?>" 
                                        <?= (isset($data['selectedEetwens']) && $data['selectedEetwens'] == $eetwens->Id) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($eetwens->EetwensNaam); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Toon gezinnen</button>
                    </form>
                </div>
            </div>

            <!-- Table overview -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Gezinsnaam</th>
                            <th>Omschrijving</th>
                            <th>Volwassenen</th>
                            <th>Kinderen</th>
                            <th>Baby's</th>
                            <th>Vertegenwoordiger</th>
                            <th>Voedselpakket details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data['gezinnen']) && !empty($data['gezinnen'])): ?>
                            <?php foreach($data['gezinnen'] as $gezin): ?>
                                <tr>
                                    <td><?= htmlspecialchars($gezin->GezinNaam ?? ''); ?></td>
                                    <td><?= htmlspecialchars($gezin->Omschrijving ?? ''); ?></td>
                                    <td><?= (int)($gezin->AantalVolwassenen ?? 0); ?></td>
                                    <td><?= (int)($gezin->AantalKinderen ?? 0); ?></td>
                                    <td><?= (int)($gezin->AantalBabys ?? 0); ?></td>
                                    <td><?= htmlspecialchars($gezin->Vertegenwoordiger ?? 'Niet ingesteld'); ?></td>
                                    <td>
                                        <a href="<?= URLROOT; ?>voedselpakketten/details/<?= (int)$gezin->Id; ?>" 
                                           class="btn btn-sm btn-primary">Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Geen gezinnen gevonden</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Home button -->
            <div class="mt-3">
                <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">Home</a>
            </div>

        </div>
    </div>
</div>

<!-- Client-side validatie JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eetwensForm = document.getElementById('eetwensForm');
    const eetwensSelect = document.getElementById('eetwensSelect');
    
    // Auto-submit bij selectie wijziging (optioneel)
    eetwensSelect.addEventListener('change', function() {
        if (this.value !== '') {
            eetwensForm.submit();
        }
    });
});
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>