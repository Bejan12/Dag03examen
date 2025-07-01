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

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="text-success">Overzicht voedselpakketten</h3>
                </div>
            </div>

            <!-- Gezin informatie -->
            <?php if (isset($data['gezin']) && $data['gezin']): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>Naam</h5>
                                <p><?= htmlspecialchars($data['gezin']->Naam ?? ''); ?></p>
                                
                                <h5>Omschrijving</h5>
                                <p><?= htmlspecialchars($data['gezin']->Omschrijving ?? ''); ?></p>
                                
                                <h5>Totaal aantal personen</h5>
                                <p><?= (int)($data['gezin']->TotaalAantalPersonen ?? 0); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Voedselpakketten overzicht -->
            <div class="table-responsive">
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
                                    <td><?= htmlspecialchars($pakket->DatumSamenstelling ?? ''); ?></td>
                                    <td><?= $pakket->DatumUitgifte ? htmlspecialchars($pakket->DatumUitgifte) : '-'; ?></td>
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

            <!-- Terug buttons -->
            <div class="mt-3">
                <a href="<?= URLROOT; ?>voedselpakketten/overzicht" class="btn btn-secondary">Terug</a>
                <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">Home</a>
            </div>

        </div>
    </div>
</div>

<!-- Auto-redirect na 3 seconden bij success message -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        // Na 3 seconden de alert verbergen
        setTimeout(function() {
            successAlert.style.display = 'none';
        }, 3000);
    }
});
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>