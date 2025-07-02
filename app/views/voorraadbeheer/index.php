
<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-5">
    <div class="row mt-3">
        <div class="col-12">
            <!-- HEADER SECTIE - Responsive header met titel en filter -->
            <div class="row mb-4">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h3 class="text-success"><i class="bi bi-box-seam me-2"></i><?= htmlspecialchars($data['title']) ?></h3>
                </div>
                <div class="col-md-6">
                    <form class="d-flex flex-column flex-md-row justify-content-md-end gap-2" method="get" action="">
                        <select class="form-select me-md-2 mb-2 mb-md-0" name="categorieId" style="min-width:180px;max-width:250px;">
                            <option value="">Alle categorieën</option>
                            <?php foreach ($data['categorieen'] as $cat): ?>
                                <option value="<?= $cat->Id ?>" <?= isset($_GET['categorieId']) && $_GET['categorieId'] == $cat->Id ? 'selected' : '' ?>><?= htmlspecialchars($cat->Naam) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-success" type="submit">Toon Voorraad</button>
                    </form>
                </div>
            </div>

            <!-- DESKTOP TABEL VIEW -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-striped align-middle text-center mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">PakketNMR</th>
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
                            <?php 
                                // Sorteer op Id (pakketnummer) oplopend
                                $producten_sorted = $data['voorraad'];
                                usort($producten_sorted, function($a, $b) { return $a->Id <=> $b->Id; });
                                foreach ($producten_sorted as $product): 
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($product->Id); ?></td>
                                    <td class="fw-semibold text-start"><i class="bi bi-cube me-1"></i><?= htmlspecialchars($product->productnaam); ?></td>
                                    <td><?= htmlspecialchars($product->categorienaam); ?></td>
                                    <td><?= htmlspecialchars($product->eenheid); ?></td>
                                    <td><span class="badge bg-success fs-6"><?= htmlspecialchars($product->aantal); ?></span></td>
                                    <td>
                                        <?php
                                            $houdb = $product->Houdbaarheidsdatum ?? '';
                                            $houdb_nl = $houdb ? date('d-m-Y', strtotime($houdb)) : '';
                                            echo htmlspecialchars($houdb_nl);
                                        ?>
                                    </td>
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

            <!-- MOBILE/TABLET CARD VIEW -->
            <div class="d-block d-lg-none">
                <?php if (!empty($data['voorraad'])): ?>
                    <?php 
                        $producten_sorted = $data['voorraad'];
                        usort($producten_sorted, function($a, $b) { return $a->Id <=> $b->Id; });
                        foreach ($producten_sorted as $product): 
                    ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-5 fw-bold">PakketNMR:</div>
                                    <div class="col-7"><?= htmlspecialchars($product->Id); ?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 fw-bold">Productnaam:</div>
                                    <div class="col-7"><?= htmlspecialchars($product->productnaam); ?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 fw-bold">Categorie:</div>
                                    <div class="col-7"><?= htmlspecialchars($product->categorienaam); ?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 fw-bold">Eenheid:</div>
                                    <div class="col-7"><?= htmlspecialchars($product->eenheid); ?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 fw-bold">Aantal:</div>
                                    <div class="col-7"><span class="badge bg-success fs-6"><?= htmlspecialchars($product->aantal); ?></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 fw-bold">Houdbaarheidsdatum:</div>
                                    <div class="col-7">
                                        <?php
                                            $houdb = $product->Houdbaarheidsdatum ?? '';
                                            $houdb_nl = $houdb ? date('d-m-Y', strtotime($houdb)) : '';
                                            echo htmlspecialchars($houdb_nl);
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 fw-bold">Magazijn:</div>
                                    <div class="col-7"><?= htmlspecialchars($product->magazijn); ?></div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 d-grid gap-2">
                                        <a href="<?= URLROOT; ?>/voorraadbeheer/details/<?= $product->Id; ?>" class="btn btn-info btn-sm">
                                            <i class="bi bi-search"></i> Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php elseif (isset($_GET['categorieId']) && $_GET['categorieId'] !== ""): ?>
                    <div class="alert alert-warning text-center">
                        Er zijn geen producten bekent die behoren bij de geselecteerde productcategorie
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        Geen voorraadproducten gevonden.
                    </div>
                <?php endif; ?>
            </div>

            <!-- HOME KNOP SECTIE -->
            <div class="mt-3 text-center text-md-start">
                <a href="<?= URLROOT; ?>" class="btn btn-secondary">Home</a>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>