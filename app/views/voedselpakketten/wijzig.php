<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row mt-3">
        <div class="col-12">
            
            <!-- Success message -->
            <?php if (isset($data['success_message']) && !empty($data['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                    <?= htmlspecialchars($data['success_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Error messages -->
            <?php if (isset($data['error_message']) && !empty($data['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($data['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Header - Responsive -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3>Wijzig voedselpakket status</h3>
                </div>
            </div>

            <!-- Form - Responsive Layout -->
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-12">
                    <?php if (isset($data['voedselpakket']) && $data['voedselpakket']): ?>
                        
                        <!-- Pakket informatie - Responsive Card -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Pakketnummer: <?= (int)$data['voedselpakket']->PakketNummer; ?></h5>
                                        <p><strong>Gezin:</strong> <?= htmlspecialchars($data['voedselpakket']->GezinNaam ?? ''); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Huidige status:</strong></p>
                                        <span class="badge <?php
                                            switch($data['voedselpakket']->Status) {
                                                case 'NietUitgereikt': echo 'bg-warning text-dark'; break;
                                                case 'Uitgereikt': echo 'bg-success'; break;
                                                case 'NietMeerIngeschreven': echo 'bg-danger'; break;
                                                default: echo 'bg-secondary';
                                            }
                                        ?>">
                                            <?php
                                            switch($data['voedselpakket']->Status) {
                                                case 'NietUitgereikt': echo 'Niet uitgereikt'; break;
                                                case 'Uitgereikt': echo 'Uitgereikt'; break;
                                                case 'NietMeerIngeschreven': echo 'Niet meer ingeschreven'; break;
                                                default: echo htmlspecialchars($data['voedselpakket']->Status);
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Scenario 2: Warning bericht -->
                        <?php if (!$data['magGewijzigdWorden']): ?>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt
                            </div>
                        <?php endif; ?>

                        <!-- Status wijzig form - Responsive -->
                        <?php if (!isset($data['success_message']) || empty($data['success_message'])): ?>
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

                            <!-- Responsive Button Layout -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="submit" class="btn btn-primary" 
                                        <?= !$data['magGewijzigdWorden'] ? 'disabled' : ''; ?>>
                                    Wijzig status voedselpakket
                                </button>
                                <a href="<?= URLROOT; ?>voedselpakketten/details/<?= (int)$data['voedselpakket']->GezinId; ?>" 
                                   class="btn btn-secondary">Terug</a>
                                <a href="<?= URLROOT; ?>homepages/index" class="btn btn-secondary">Home</a>
                            </div>
                        </form>
                        <?php else: ?>
                            <!-- Success buttons - Responsive -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <p class="text-center w-100">U wordt automatisch doorverwezen...</p>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="alert alert-danger">
                            Voedselpakket niet gevonden.
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="<?= URLROOT; ?>voedselpakketten/overzicht" class="btn btn-secondary">Terug naar overzicht</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Auto-redirect script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.getElementById('successAlert');
    
    if (successAlert) {
        setTimeout(function() {
            <?php if (isset($data['redirect_url']) && !empty($data['redirect_url'])): ?>
                window.location.href = '<?= $data['redirect_url']; ?>';
            <?php else: ?>
                window.location.href = '<?= URLROOT; ?>voedselpakketten/overzicht';
            <?php endif; ?>
        }, 3000);
    }
    
    // Form validatie
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