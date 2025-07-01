<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h2 class="mb-0"><i class="bi bi-box-seam me-2"></i><?= htmlspecialchars($data['title']) ?></h2>
                    <form class="d-flex" method="get" action="">
                        <select class="form-select me-2" name="categorieId" style="min-width:200px;">
                            <option value="">Alle categorieën</option>
                            <?php foreach ($data['categorieen'] as $cat): ?>
                                <option value="<?= $cat->Id ?>" <?= isset($_GET['categorieId']) && $_GET['categorieId'] == $cat->Id ? 'selected' : '' ?>><?= htmlspecialchars($cat->Naam) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-success" type="submit">Toon Voorraad</button>
                    </form>
                </div>
                <div class="card-body bg-light">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Productnaam</th>
                                <th scope="col">Categorie</th>
                                <th scope="col">Eenheid</th>
                                <th scope="col">Aantal</th>
                                <th scope="col">Houdbaarheidsdatum</th>
                                <th scope="col">Magazijn</th>
                                <th scope="col">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['voorraad'])): ?>
                                <?php foreach ($data['voorraad'] as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product->Id); ?></td>
                                        <td class="fw-semibold text-start"><i class="bi bi-cube me-1"></i><?= htmlspecialchars($product->productnaam); ?></td>
                                        <td><?= htmlspecialchars($product->categorienaam); ?></td>
                                        <td><?= htmlspecialchars($product->eenheid); ?></td>
                                        <td><span class="badge bg-success fs-6"><?= htmlspecialchars($product->aantal); ?></span></td>
                                        <td><?= htmlspecialchars($product->Houdbaarheidsdatum); ?></td>
                                        <td><?= htmlspecialchars($product->magazijn); ?></td>
                                        <td>
                                            <a href="<?= URLROOT; ?>/voorraadbeheer/details/<?= $product->Id; ?>" class="btn btn-info btn-sm">
                                                <i class="bi bi-search"></i> Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php elseif (isset($_GET['categorieId']) && $_GET['categorieId'] !== ""): ?>
                                <tr><td colspan="8" class="text-center text-warning bg-light fs-5">Er zijn geen producten bekent die behoren bij de geselecteerde productcategorie</td></tr>
                            <?php else: ?>
                                <tr><td colspan="8" class="text-center text-muted">Geen voorraadproducten gevonden.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
