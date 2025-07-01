<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="row align-items-center mb-3">
    <div class="col">
        <h3 class="mb-0">Overzicht Leveranciers</h3>
    </div>
    <div class="col-auto">
        <form method="post" class="mb-0">
            <div class="input-group">
                <span class="input-group-text" id="label-leveranciertype">Leverancierstype:</span>
                <select name="leveranciertype" id="leveranciertype" class="form-select" aria-label="Leverancierstype" aria-describedby="label-leveranciertype" style="min-width: 180px;">
                    <option value="">-- Alle types --</option>
                    <?php foreach ($data['types'] as $type): ?>
                        <option value="<?= $type->LeverancierType ?>" <?= ($data['selectedType'] == $type->LeverancierType) ? 'selected' : '' ?>>
                            <?= $type->LeverancierType ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="ms-2">
                    <button type="submit" class="btn btn-primary">Toon Leveranciers</button>
                </div>
            </div>
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
                        <a href="<?= URLROOT ?>/productenPerLeverancier/index/<?= $l->LeverancierNummer ?>" class="btn btn-info btn-sm">
                            Product Details
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
<?php require_once APPROOT . '/views/includes/footer.php'; ?>


