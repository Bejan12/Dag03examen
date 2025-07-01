<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            
            <!-- Success/Error messages -->
            <?php if (isset($data['success_message']) && !empty($data['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                    <?= htmlspecialchars($data['success_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($data['error_message']) && !empty($data['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Header - Responsive -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <h3 class="text-success">Overzicht voedselpakketten</h3>
                </div>
                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                    <a href="<?= URLROOT; ?>voedselpakketten/overzicht" class="btn btn-secondary me-2">Terug</a>
                    <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">Home</a>
                </div>
            </div>

            <!-- Gezin informatie - Responsive Card -->
            <?php if (isset($data['gezin']) && $data['gezin']): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Naam</h5>
                                        <p><?= htmlspecialchars($data['gezin']->Naam ?? ''); ?></p>
                                        
                                        <h5>Omschrijving</h5>
                                        <p><?= htmlspecialchars($data['gezin']->Omschrijving ?? ''); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Totaal aantal personen</h5>
                                        <p><?= (int)($data['gezin']->TotaalAantalPersonen ?? 0); ?></p>
                                        
                                        <h5>Samenstelling</h5>
                                        <p>
                                            <?= (int)($data['gezin']->AantalVolwassenen ?? 0); ?> volwassenen, 
                                            <?= (int)($data['gezin']->AantalKinderen ?? 0); ?> kinderen, 
                                            <?= (int)($data['gezin']->AantalBabys ?? 0); ?> baby's
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pakketnummer</th>
                            <th>Datum samenstelling</th>
                            <th>Datum uitgifte</th>
                            <th>Status</th>
                            <th>Aantal producten</th>
                            <th>Wijzig status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data['voedselpakketten']) && !empty($data['voedselpakketten'])): ?>
                            <?php foreach($data['voedselpakketten'] as $pakket): ?>
                               <tr>
                                    <td><?= (int)$pakket->PakketNummer; ?></td>
                                    <td><?= $pakket->DatumSamenstelling ? date('d-m-Y', strtotime($pakket->DatumSamenstelling)) : '-'; ?></td>
                                    <td><?= $pakket->DatumUitgifte ? date('d-m-Y', strtotime($pakket->DatumUitgifte)) : '-'; ?></td>
                                    <td>
                                        <?php
                                        switch($pakket->Status) {
                                            case 'NietUitgereikt':
                                                echo 'Niet uitgereikt';
                                                break;
                                            case 'Uitgereikt':
                                                echo 'Uitgereikt';
                                                break;
                                            case 'NietMeerIngeschreven':
                                                echo 'Niet meer ingeschreven';
                                                break;
                                            default:
                                                echo htmlspecialchars($pakket->Status);
                                        }
                                        ?>
                                    </td>
                                    <td><?= (int)($pakket->AantalProducten ?? 0); ?></td>
                                    <td>
                                        <a href="<?= URLROOT; ?>voedselpakketten/wijzigStatus/<?= (int)$pakket->Id; ?>" 
                                           class="btn btn-sm btn-warning" title="Wijzig status">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Geen voedselpakketten gevonden</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile/Tablet Card View -->
            <div class="d-block d-lg-none">
                <?php if (isset($data['voedselpakketten']) && !empty($data['voedselpakketten'])): ?>
                    <?php foreach($data['voedselpakketten'] as $pakket): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">Pakket #<?= (int)$pakket->PakketNummer; ?></h5>
                                        <p class="card-text mb-1">
                                            <strong>Samenstelling:</strong><br>
                                            <small><?= $pakket->DatumSamenstelling ? date('d-m-Y', strtotime($pakket->DatumSamenstelling)) : '-'; ?></small>
                                        </p>
                                        <p class="card-text mb-1">
                                            <strong>Uitgifte:</strong><br>
                                            <small><?= $pakket->DatumUitgifte ? date('d-m-Y', strtotime($pakket->DatumUitgifte)) : '-'; ?></small>
                                        </p>
                                        <p class="card-text mb-1">
                                            <strong>Status:</strong> 
                                            <span class="badge <?php
                                                switch($pakket->Status) {
                                                    case 'NietUitgereikt': echo 'bg-warning text-dark'; break;
                                                    case 'Uitgereikt': echo 'bg-success'; break;
                                                    case 'NietMeerIngeschreven': echo 'bg-danger'; break;
                                                    default: echo 'bg-secondary';
                                                }
                                            ?>">
                                                <?php
                                                switch($pakket->Status) {
                                                    case 'NietUitgereikt': echo 'Niet uitgereikt'; break;
                                                    case 'Uitgereikt': echo 'Uitgereikt'; break;
                                                    case 'NietMeerIngeschreven': echo 'Niet meer ingeschreven'; break;
                                                    default: echo htmlspecialchars($pakket->Status);
                                                }
                                                ?>
                                            </span>
                                        </p>
                                        <p class="card-text mb-0">
                                            <strong>Producten:</strong> <?= (int)($pakket->AantalProducten ?? 0); ?>
                                        </p>
                                    </div>
                                    <div class="col-4 text-end">
                                        <a href="<?= URLROOT; ?>voedselpakketten/wijzigStatus/<?= (int)$pakket->Id; ?>" 
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i><br>
                                            <small>Wijzig</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        Geen voedselpakketten gevonden
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000);
    }
});
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>