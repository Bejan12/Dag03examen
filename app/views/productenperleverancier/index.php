<?php require_once APPROOT . '/views/includes/header.php'; ?>

<?php
$melding = $_GET['melding'] ?? '';
if ($melding):
?>
    <div class="alert alert-success"><?= htmlspecialchars($melding, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h1>
    <?php
    echo htmlspecialchars($titel ?? '', ENT_QUOTES, 'UTF-8');
    ?>
</h1>

<table class="table table-sm w-auto mb-4">
    <tr>
        <th>Naam</th>
        <td><?= htmlspecialchars($data['leverancier']->Naam ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Leveranciernummer</th>
        <td><?= htmlspecialchars($data['leverancier']->LeverancierNummer ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Leveranciertype</th>
        <td><?= htmlspecialchars($data['leverancier']->LeverancierType ?? '', ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
</table>

<h3>Overzicht producten</h3>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Naam</th>
            <th>Soort Allergie</th>
            <th>Barcode</th>
            <th>Houdbaarheidsdatum</th>
            <th>Wijzig Product</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['producten'] as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p->Naam ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?= htmlspecialchars(($p->Soort ?? '') .   ($p->Allergie ?? ''), ENT_QUOTES, 'UTF-8') ?>
                </td>
                <td><?= htmlspecialchars($p->Barcode ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($p->Houdbaarheidsdatum ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a href="<?= URLROOT ?>/productenPerLeverancier/wijzig/<?= $p->ProductId ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Wijzig
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= URLROOT ?>/leveranciers" class="btn btn-secondary">Terug naar leveranciers</a>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>

