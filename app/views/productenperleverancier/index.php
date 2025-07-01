<?php require_once APPROOT . '/views/includes/header.php'; ?>

<h1>
    <?php
    echo htmlspecialchars($titel ?? '', ENT_QUOTES, 'UTF-8');
    ?>
</h1>

<h3>Overzicht producten van leverancier <?= htmlspecialchars($data['leverancierNummer'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Productnaam</th>
            <th>Houdbaarheidsdatum</th>
            <th>Wijzig Product</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['producten'] as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p->Naam) ?></td>
                <td><?= htmlspecialchars($p->Houdbaarheidsdatum) ?></td>
                <td>
                    <a href="<?= URLROOT ?>/productenPerLeverancier/wijzig/<?= $p->ProductId ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= URLROOT ?>/leveranciers" class="btn btn-secondary">Terug naar leveranciers</a>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
