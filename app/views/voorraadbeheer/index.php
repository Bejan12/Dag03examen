<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><i class="bi bi-box-seam me-2"></i><?= htmlspecialchars($data['title']) ?></h2>
                </div>
                <div class="card-body bg-light">
                    <?php if (empty($data['voorraad'])): ?>
                        <div class="alert alert-warning text-center">Er zijn geen producten in de voorraad gevonden.</div>
                    <?php else: ?>
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Productnaam</th>
                                    <th scope="col">Categorie</th>
                                    <th scope="col">Voorraad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['voorraad'] as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product->id); ?></td>
                                        <td class="fw-semibold text-start"><i class="bi bi-cube me-1"></i><?= htmlspecialchars($product->productnaam); ?></td>
                                        <td><?= htmlspecialchars($product->categorienaam); ?></td>
                                        <td><span class="badge bg-success fs-6"><?= htmlspecialchars($product->voorraad); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
