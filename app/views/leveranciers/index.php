<?php require_once APPROOT . '/views/includes/header.php'; ?>

<h3>Overzicht Leveranciers</h3>

<div class="row mb-3 justify-content-between align-items-center">
    <div class="col-auto">
        <form method="post" class="d-flex align-items-center">
            <label for="leveranciertype" class="col-form-label me-2">Leverancierstype:</label>
            <select name="leveranciertype" id="leveranciertype" class="form-select me-2">
                <option value="">-- Alle types --</option>
                <?php foreach ($data['types'] as $type): ?>
                    <option value="<?= $type->LeverancierType ?>" <?= ($data['selectedType'] == $type->LeverancierType) ? 'selected' : '' ?>>
                        <?= $type->LeverancierType ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Toon Leveranciers</button>
        </form>
    </div>
</div>

<?php if ($data['melding']): ?>
    <div class="alert alert-warning"><?= $data['melding'] ?></div>
<?php endif; ?>

<?php if (count($data['leveranciers']) > 0): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Contactpersoon</th>
                <th>Email</th>
                <th>Mobiel</th>
                <th>Leveranciernummer</th>
                <th>Leveranciertype</th>
                <th>Product</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['leveranciers'] as $l): ?>
                <tr>
                    <td><?= $l->Naam ?></td>
                    <td><?= $l->ContactPersoon ?></td>
                    <td><?= isset($l->Email) ? $l->Email : '-' ?></td>
                    <td><?= isset($l->Mobiel) ? $l->Mobiel : '-' ?></td>
                    <td><?= $l->LeverancierNummer ?></td>
                    <td><?= $l->LeverancierType ?></td>
                    <td><?= isset($l->Product) ? $l->Product : '-' ?></td>
                    <td>
                        <a href="<?= URLROOT ?>/leveranciers/details/<?= $l->LeverancierNummer ?>" class="btn btn-info btn-sm">Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
