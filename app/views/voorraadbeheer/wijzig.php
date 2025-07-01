<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        <?= htmlspecialchars($data['title']) ?>
                    </h2>
                </div>
                <div class="card-body bg-light">

                    <!-- Succesbericht -->
                    <?php if (!empty($data['success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($data['success']) ?>
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.href = "<?= URLROOT; ?>/voorraadbeheer/details/<?= $data['product']->Id ?>";
                            }, 3000);
                        </script>
                    <?php endif; ?>

                    <!-- Foutmeldingen -->
                    <?php if (!empty($data['feedback'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($data['feedback']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($data['product']): ?>
                        <form method="post" novalidate>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Productnaam</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($data['product']->productnaam) ?>" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Houdbaarheidsdatum</th>
                                    <td>
                                        <input type="date" class="form-control" value="<?= htmlspecialchars($data['product']->Houdbaarheidsdatum) ?>" readonly max="2030-12-31">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Barcode</th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($data['product']->Barcode ?? '') ?>" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Magazijn locatie</th>
                                    <td>
<select name="magazijn" class="form-select" required>
    <option value="" disabled <?= empty($data['product']->magazijn) ? 'selected' : '' ?>>-- Kies magazijn --</option>
    <?php if (!empty($data['magazijnen'])): ?>
        <?php foreach ($data['magazijnen'] as $magazijn): ?>
            <option value="<?= htmlspecialchars($magazijn->Locatie) ?>" <?= ($magazijn->Locatie === $data['product']->magazijn) ? 'selected' : '' ?>>
                <?= htmlspecialchars($magazijn->Locatie) ?>
            </option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="">Geen magazijnen beschikbaar</option>
    <?php endif; ?>
</select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ontvangstdatum</th>
                                    <td>
                                        <input type="date" class="form-control" value="<?= htmlspecialchars($data['product']->Ontvangstdatum ?? '') ?>" readonly max="2030-12-31">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Aantal uitgeleverde producten</th>
                                    <td>
                                        <input type="number" class="form-control" name="aantal_uitgeleverd" min="0" max="<?= (int)$data['product']->aantal ?>" value="<?= htmlspecialchars($_POST['aantal_uitgeleverd'] ?? '') ?>" required>
                                        <?php if (!empty($data['feedback']) && strpos($data['feedback'], 'meer producten uitgeleverd') !== false): ?>
                                            <small class="text-danger">Er worden meer producten uitgeleverd dan in voorraad zijn.</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Uitleveringsdatum</th>
                                    <td>
                                        <input type="date" class="form-control" name="uitleveringsdatum"
                                               value="<?= htmlspecialchars($_POST['uitleveringsdatum'] ?? '') ?>"
                                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                               max="2030-12-31"
                                               required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Aantal op voorraad</th>
                                    <td>
                                        <input type="number" class="form-control" value="<?= htmlspecialchars($data['product']->aantal) ?>" readonly>
                                    </td>
                                </tr>
                            </table>

                            <button type="submit" class="btn btn-primary">Wijzig Product Details</button>
                            <a href="<?= URLROOT; ?>/voorraadbeheer/details/<?= $data['product']->Id ?>" class="btn btn-secondary ms-2">Terug</a>
                            <a href="<?= URLROOT; ?>/" class="btn btn-secondary ms-2">Home</a>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger">Product niet gevonden.</div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
