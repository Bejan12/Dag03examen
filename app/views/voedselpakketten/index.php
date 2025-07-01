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

            <!-- Header section - Responsive -->
            <div class="row mb-4">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h3 class="text-success">Overzicht gezinnen</h3>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="<?= URLROOT; ?>voedselpakketten/filterByEetwens" 
                          class="d-flex flex-column flex-md-row justify-content-md-end" id="eetwensForm">
                        <select name="eetwens" class="form-select me-md-2 mb-2 mb-md-0" id="eetwensSelect">
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

            <!-- Desktop Table View -->
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
                                <td colspan="7" class="text-center">
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

            <!-- Mobile/Tablet Card View -->
            <div class="d-block d-lg-none">
                <?php if (isset($data['gezinnen']) && !empty($data['gezinnen'])): ?>
                    <?php foreach($data['gezinnen'] as $gezin): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title"><?= htmlspecialchars($gezin->GezinNaam ?? ''); ?></h5>
                                        <p class="card-text">
                                            <strong>Omschrijving:</strong> <?= htmlspecialchars($gezin->Omschrijving ?? ''); ?><br>
                                            <strong>Personen:</strong> 
                                            <?= (int)($gezin->AantalVolwassenen ?? 0); ?> volw. | 
                                            <?= (int)($gezin->AantalKinderen ?? 0); ?> kind. | 
                                            <?= (int)($gezin->AantalBabys ?? 0); ?> baby's<br>
                                            <strong>Vertegenwoordiger:</strong> <?= htmlspecialchars($gezin->Vertegenwoordiger ?? 'Niet ingesteld'); ?>
                                        </p>
                                    </div>
                                    <div class="col-4 text-end">
                                        <a href="<?= URLROOT; ?>voedselpakketten/details/<?= (int)$gezin->Id; ?>" 
                                           class="btn btn-primary btn-sm">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <?php if (isset($data['selectedEetwens']) && $data['selectedEetwens'] > 0): ?>
                            Er zijn geen gezinnen bekend die de geselecteerde eetwens hebben
                        <?php else: ?>
                            Geen gezinnen gevonden
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Home button -->
            <div class="mt-3 text-center text-md-start">
                <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">Home</a>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bevestiging voor eventuele delete acties
    document.querySelectorAll('.btn-danger').forEach(function(button) {
        button.addEventListener('click', function(e) {
            if (!confirm('Weet je zeker dat je deze actie wilt uitvoeren?')) {
                e.preventDefault();
            }
        });
    });
    
    // Focus op dropdown bij pagina load
    const eetwensSelect = document.getElementById('eetwensSelect');
    if (eetwensSelect) {
        eetwensSelect.focus();
    }
});
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>