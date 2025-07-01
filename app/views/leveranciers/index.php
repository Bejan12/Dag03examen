<?php require_once APPROOT . '/views/includes/header.php'; ?>

<h3>Overzicht Leveranciers</h3>

<form method="post" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <label for="leveranciertype" class="col-form-label">Leverancierstype:</label>
        </div>
        <div class="col-auto">
            <select name="leveranciertype" id="leveranciertype" class="form-select">
                <option value="">-- Alle types --</option>
                <?php foreach ($data['types'] as $type): ?>
                    <option value="<?= $type->LeverancierType ?>" <?= ($data['selectedType'] == $type->LeverancierType) ? 'selected' : '' ?>>
                        <?= $type->LeverancierType ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Toon Leveranciers</button>
        </div>
    </div>
</form>

<?php if ($data['melding']): ?>
    <div class="alert alert-warning"><?= $data['melding'] ?></div>
<?php endif; ?>

<?php if (count($data['leveranciers']) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Contactpersoon</th>
                <th>Nummer</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['leveranciers'] as $l): ?>
                <tr>
                    <td><?= $l->Naam ?></td>
                    <td><?= $l->ContactPersoon ?></td>
                    <td><?= $l->LeverancierNummer ?></td>
                    <td><?= $l->LeverancierType ?></td>
                    <td><?= $l->IsActief ? 'Actief' : 'Inactief' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
