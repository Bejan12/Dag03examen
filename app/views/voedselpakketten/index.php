<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            
            <!-- Header section with green background -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h3 class="text-success"><?php echo $data['title']; ?></h3>
                </div>
                <div class="col-md-6">
                    <form method="GET" action="<?= URLROOT; ?>voedselpakketten/filterByEetwens" class="d-flex justify-content-end">
                        <select name="eetwens" class="form-select me-2" style="width: auto;">
                            <option value="">Selecteer eetwens</option>
                            <?php foreach($data['eetwensen'] as $eetwens): ?>
                                <option value="<?= $eetwens->Id; ?>" 
                                    <?= (isset($data['selectedEetwens']) && $data['selectedEetwens'] == $eetwens->Id) ? 'selected' : ''; ?>>
                                    <?= $eetwens->EetwensNaam; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Toon gezinnen</button>
                    </form>
                </div>
            </div>

            <!-- Table overview -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
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
                        <?php if (!empty($data['gezinnen'])): ?>
                            <?php foreach($data['gezinnen'] as $gezin): ?>
                                <tr>
                                    <td><?= htmlspecialchars($gezin->GezinNaam); ?></td>
                                    <td><?= htmlspecialchars($gezin->Adres . ', ' . $gezin->Postcode . ' ' . $gezin->Woonplaats); ?></td>
                                    <td><?= $gezin->AantalVolwassenen; ?></td>
                                    <td><?= $gezin->AantalKinderen; ?></td>
                                    <td><?= $gezin->AantalBabys; ?></td>
                                    <td><?= htmlspecialchars($gezin->Vertegenwoordiger ?? 'Niet ingesteld'); ?></td>
                                    <td>
                                        <a href="<?= URLROOT; ?>voedselpakketten/details/<?= $gezin->Id; ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Details
                                        </a>
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

            <!-- Back button -->
            <div class="mt-3">
                <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Terug naar home
                </a>
            </div>

        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>