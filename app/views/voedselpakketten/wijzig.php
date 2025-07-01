<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            
            <!-- Error messages -->
            <?php if (isset($data['error_message']) && !empty($data['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3>Wijzig voedselpakket status</h3>
                </div>
            </div>

            <!-- Form -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <?php if (isset($data['voedselpakket']) && $data['voedselpakket']): ?>
                        
                        <!-- Pakket informatie -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Pakketnummer: <?= (int)$data['voedselpakket']->PakketNummer; ?></h5>
                                <p><strong>Gezin:</strong> <?= htmlspecialchars($data['voedselpakket']->GezinNaam ?? ''); ?></p>
                                <p><strong>Huidige status:</strong> 
                                    <?php
                                    switch($data['voedselpakket']->Status) {
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
                                            echo htmlspecialchars($data['voedselpakket']->Status);
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <!-- Scenario 2: AUTOMATISCH tonen als het niet mag gewijzigd worden -->
                        <?php if (!$data['magGewijzigdWorden']): ?>
                            <div class="alert" style="background-color: #ffe4e1; border-color: #ffc0cb; color: #8b0000;">
                                Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt
                            </div>
                        <?php endif; ?>

                        <!-- Status wijzig form -->
                        <form method="POST" action="<?= URLROOT; ?>voedselpakketten/updateStatus" id="statusForm">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token'] ?? ''); ?>">
                            <input type="hidden" name="voedselpakket_id" value="<?= (int)$data['voedselpakket']->Id; ?>">
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select name="status" id="status" class="form-select" 
                                        <?= !$data['magGewijzigdWorden'] ? 'disabled' : ''; ?>>
                                    <option value="NietUitgereikt" 
                                        <?= ($data['voedselpakket']->Status === 'NietUitgereikt') ? 'selected' : ''; ?>>
                                        Niet uitgereikt
                                    </option>
                                    <option value="Uitgereikt" 
                                        <?= ($data['voedselpakket']->Status === 'Uitgereikt') ? 'selected' : ''; ?>>
                                        Uitgereikt
                                    </option>
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary me-2" 
                                        <?= !$data['magGewijzigdWorden'] ? 'disabled' : ''; ?>>
                                    Wijzig status voedselpakket
                                </button>
                                <a href="<?= URLROOT; ?>voedselpakketten/details/<?= (int)$data['voedselpakket']->GezinId; ?>" 
                                   class="btn btn-secondary me-2">Terug</a>
                                <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">Home</a>
                            </div>
                        </form>

                    <?php else: ?>
                        <div class="alert alert-danger">
                            Voedselpakket niet gevonden.
                        </div>
                        <div class="text-center">
                            <a href="<?= URLROOT; ?>voedselpakketten/overzicht" class="btn btn-secondary">Terug naar overzicht</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Client-side validatie -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('statusForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const status = document.getElementById('status').value;
            
            if (!status) {
                e.preventDefault();
                alert('Selecteer een status');
                return false;
            }
            
            return true;
        });
    }
});
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>