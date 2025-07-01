<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <h3><?= $data['title']; ?></h3>
    <?php if (isset($data['product'])): ?>
        <table class="table table-bordered">
            <tr><th>Product</th><td><?= htmlspecialchars($data['product']->productnaam); ?></td></tr>
            <tr><th>Categorie</th><td><?= htmlspecialchars($data['product']->categorienaam); ?></td></tr>
            <tr><th>Voorraad</th><td><?= htmlspecialchars($data['product']->voorraad); ?></td></tr>
        </table>
        <a href="<?= URLROOT; ?>/voorraadbeheer/wijzig/<?= $data['product']->id; ?>" class="btn btn-warning">
            <i class="bi bi-pencil-square"></i> Wijzig
        </a>
    <?php else: ?>
        <div class="alert alert-danger">Product niet gevonden.</div>
    <?php endif; ?>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
