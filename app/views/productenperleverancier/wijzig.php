<?php require_once APPROOT . '/views/includes/header.php'; ?>

<h3>Wijzig houdbaarheidsdatum product</h3>

<?php if (!empty($data['melding'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($data['melding']) ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label for="naam" class="form-label">Productnaam</label>
        <input type="text" class="form-control" id="naam" value="<?= htmlspecialchars($data['product']->Naam) ?>" disabled>
    </div>
    <div class="mb-3">
        <label for="houdbaarheidsdatum" class="form-label">Houdbaarheidsdatum</label>
        <input type="date" class="form-control" id="houdbaarheidsdatum" name="houdbaarheidsdatum" value="<?= htmlspecialchars($data['product']->Houdbaarheidsdatum) ?>" required>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <button type="submit" class="btn btn-secondary">Wijzig Houdbaarheidsdatum</button>
        <div>
            <a href="<?= URLROOT ?>/productenPerLeverancier/index/<?= htmlspecialchars($data['leverancierNummer'] ?? '') ?>" class="btn btn-primary me-2">Terug</a>
            <a href="<?= URLROOT ?>" class="btn btn-primary">Home</a>
        </div>
    </div>
</form>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
