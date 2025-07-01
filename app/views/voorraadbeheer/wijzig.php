<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <h3><?= $data['title']; ?></h3>
    <?php if (isset($data['error'])): ?>
        <div class="alert alert-danger"> <?= $data['error']; ?> </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"> <?= $_SESSION['success']; unset($_SESSION['success']); ?> </div>
    <?php endif; ?>
    <?php if (isset($data['product'])): ?>
        <form method="post" onsubmit="return validateForm();">
            <div class="mb-3">
                <label for="aantal" class="form-label">Aantal aangeleverde producten</label>
                <input type="number" class="form-control" id="aantal" name="aantal" min="0" value="<?= htmlspecialchars($data['product']->voorraad); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Wijzig Product Details</button>
        </form>
        <script>
        function validateForm() {
            var aantal = document.getElementById('aantal').value;
            if (aantal === '' || isNaN(aantal) || parseInt(aantal) < 0) {
                alert('Vul een geldig aantal in!');
                return false;
            }
            return true;
        }
        </script>
    <?php else: ?>
        <div class="alert alert-danger">Product niet gevonden.</div>
    <?php endif; ?>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
