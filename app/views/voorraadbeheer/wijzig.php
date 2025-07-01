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

                    <!-- SERVER-SIDE FEEDBACK ABOVE FORM -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">De productgegevens zijn gewijzigd.</div>
                        <script>
                            setTimeout(function() {
                                window.location.href = "<?= URLROOT; ?>/voorraadbeheer/details/<?= $data['product']->Id; ?>";
                            }, 3000);
                        </script>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <!-- ALGEMENE FOUTMELDING BOVENAAN -->
                    <?php if (isset($_SESSION['error']) || isset($_SESSION['voorraad_error'])): ?>
                        <div class="alert alert-danger">De productgegevens kunnen niet worden gewijzigd.</div>
                        <script>
                            setTimeout(function() {
                                window.location.href = "<?= URLROOT; ?>/voorraadbeheer/details/<?= $data['product']->Id; ?>";
                            }, 3000);
                        </script>
                    <?php endif; ?>

                    <?php if ($data['product']): ?>
                        <form method="post">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Productnaam</th>
                                    <td><input type="text" class="form-control" value="<?= htmlspecialchars($data['product']->productnaam) ?>" readonly></td>
                                </tr>
                                <tr>
                                    <th>Houdbaarheidsdatum</th>
                                    <td>
                                        <input type="date" class="form-control" value="<?= htmlspecialchars($data['product']->Houdbaarheidsdatum) ?>" readonly max="2030-12-31">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Barcode</th>
                                    <td><input type="text" class="form-control" value="<?= htmlspecialchars($data['product']->Barcode ?? '') ?>" readonly></td>
                                </tr>
                                <tr>
                                    <th>Magazijn locatie</th>
                                    <td><input type="text" class="form-control" name="magazijn" value="<?= htmlspecialchars($data['product']->magazijn) ?>" required></td>
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
                                        <input type="number" class="form-control" name="aantal_uitgeleverd" value="<?= htmlspecialchars($data['product']->aantal_uitgeleverd ?? '') ?>" min="0" required>
                                        <?php if (isset($_SESSION['voorraad_error'])): ?>
                                            <small class="text-danger">Er worden meer producten uitgeleverd dan in voorraad zijn.</small>
                                            <?php unset($_SESSION['voorraad_error']); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Uitleveringsdatum</th>
                                    <td>
                                        <input type="date" class="form-control" name="uitleveringsdatum"
                                               value="<?= htmlspecialchars($data['product']->Uitleveringsdatum ?? '') ?>"
                                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                               max="2030-12-31"
                                               required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Aantal op voorraad</th>
                                    <td><input type="number" class="form-control" value="<?= htmlspecialchars($data['product']->aantal) ?>" readonly></td>
                                </tr>
                            </table>

                            <button type="submit" class="btn btn-primary">Wijzig Product Details</button>
                            <a href="<?= URLROOT; ?>/voorraadbeheer/details/<?= $data['product']->Id; ?>" class="btn btn-secondary ms-2">Terug</a>
                            <a href="<?= URLROOT; ?>/" class="btn btn-secondary ms-2">Home</a>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger">Product niet gevonden.</div>
                    <?php endif; ?>

                    <!-- VERGEET NIET error te unsetten als die bestaat -->
                    <?php if (isset($_SESSION['error'])) unset($_SESSION['error']); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
