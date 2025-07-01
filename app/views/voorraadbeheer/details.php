<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><i class="bi bi-cube me-2"></i><?= htmlspecialchars($data['title']) ?></h2>
</div>
                <div class="card-body bg-light">
                    <?php if ($data['product']): ?>                        <table class="table table-bordered">
                            <tr><th>Productnaam</th><td><?= htmlspecialchars($data['product']->productnaam) ?></td></tr>
                            <tr><th>Categorie</th><td><?= htmlspecialchars($data['product']->categorienaam) ?></td></tr>
                            <tr><th>Eenheid</th><td><?= htmlspecialchars($data['product']->eenheid) ?></td></tr>
                            <tr><th>Aantal</th><td><?= htmlspecialchars($data['product']->aantal) ?></td></tr>
                            <tr><th>Houdbaarheidsdatum</th><td><?= htmlspecialchars($data['product']->Houdbaarheidsdatum) ?></td></tr>
                            <tr><th>Ontvangstdatum</th><td><?= htmlspecialchars($data['product']->Ontvangstdatum ?? 'Niet beschikbaar') ?></td></tr>
                            <tr><th>Uitleveringsdatum</th><td><?= htmlspecialchars($data['product']->Uitleveringsdatum ?? 'Nog niet uitgereikt') ?></td></tr>
                            <tr><th>Magazijn</th><td><?= htmlspecialchars($data['product']->magazijn) ?></td></tr>
                            <tr><th>Status</th><td><?= htmlspecialchars($data['product']->Status) ?></td></tr>
                            <tr><th>Omschrijving</th><td><?= htmlspecialchars($data['product']->Omschrijving) ?></td></tr>
                        </table>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="<?= URLROOT; ?>/voorraadbeheer/wijzig/<?= $data['product']->Id; ?>" class="btn btn-primary">
                                <i class="bi bi-pencil-square"></i> Wijzig
                            </a>
                            <div>
                                <a href="<?= URLROOT; ?>/voorraadbeheer/index" class="btn btn-secondary ms-2">terug</a>
                                <a href="<?= URLROOT; ?>/" class="btn btn-secondary ms-2">home</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">Product niet gevonden.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>