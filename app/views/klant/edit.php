<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <?php if (isset($data['success'])): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    De klantgegevens zijn gewijzigd
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = '<?= URLROOT; ?>/klanten/details/<?= $data['id']; ?>';
                    }, 3000);
                </script>
            <?php endif; ?>

            <?php if (isset($data['general_err']) && !empty($data['general_err'])): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= $data['general_err']; ?>
                </div>
            <?php endif; ?>

            <!-- Wijzig Klant Details volgens wireframe -->
            <div class="card shadow">
                <div class="card-header text-success">
                    <h5 class="mb-0">Wijzig Klant Details <?= htmlspecialchars($data['title']); ?></h5>
                </div>
                <div class="card-body p-3">
                    <form id="editForm" action="<?= URLROOT; ?>/klanten/edit/<?= $data['id']; ?>" method="POST" class="needs-validation" novalidate>
                        <!-- Readonly velden -->
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Voornaam</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="voornaam" 
                                       id="voornaam" 
                                       class="form-control form-control-sm <?= (!empty($data['voornaam_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= htmlspecialchars($data['voornaam']); ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?= $data['voornaam_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Tussenvoegsel</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="tussenvoegsel" 
                                       id="tussenvoegsel" 
                                       class="form-control form-control-sm <?= (!empty($data['tussenvoegsel_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= $data['tussenvoegsel'] ? htmlspecialchars($data['tussenvoegsel']) : ''; ?>">
                                <div class="invalid-feedback">
                                    <?= $data['tussenvoegsel_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Achternaam</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="achternaam" 
                                       id="achternaam" 
                                       class="form-control form-control-sm <?= (!empty($data['achternaam_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= htmlspecialchars($data['achternaam']); ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?= $data['achternaam_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Geboortedatum</div>
                            <div class="col-8">
                                <input type="date" 
                                       name="geboortedatum" 
                                       id="geboortedatum" 
                                       class="form-control form-control-sm <?= (!empty($data['geboortedatum_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= !empty($data['geboortedatum']) ? htmlspecialchars($data['geboortedatum']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?= $data['geboortedatum_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">TypePersoon</div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" value="<?= !empty($data['typepersoon']) ? htmlspecialchars($data['typepersoon']) : '~~~~'; ?>" readonly>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Vertegenwoordiger</div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" value="<?= !empty($data['vertegenwoordiger']) ? htmlspecialchars($data['vertegenwoordiger']) : '~~~~'; ?>" readonly>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <!-- Bewerkbare velden -->
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Straatnaam</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="straat" 
                                       id="straat" 
                                       class="form-control form-control-sm <?= (!empty($data['straat_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= !empty($data['straat']) ? htmlspecialchars($data['straat']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?= $data['straat_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Huisnummer</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="huisnummer" 
                                       id="huisnummer" 
                                       class="form-control form-control-sm <?= (!empty($data['huisnummer_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= !empty($data['huisnummer']) ? htmlspecialchars($data['huisnummer']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?= $data['huisnummer_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Toevoeging</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="toevoeging" 
                                       id="toevoeging" 
                                       class="form-control form-control-sm" 
                                       value="<?= !empty($data['toevoeging']) ? htmlspecialchars($data['toevoeging']) : ''; ?>">
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Postcode</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="postcode" 
                                       id="postcode" 
                                       class="form-control form-control-sm <?= (!empty($data['postcode_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= !empty($data['postcode']) ? htmlspecialchars($data['postcode']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?= $data['postcode_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Woonplaats</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="woonplaats" 
                                       id="woonplaats" 
                                       class="form-control form-control-sm <?= (!empty($data['woonplaats_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= !empty($data['woonplaats']) ? htmlspecialchars($data['woonplaats']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?= $data['woonplaats_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Email</div>
                            <div class="col-8">
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control form-control-sm <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= !empty($data['email']) ? htmlspecialchars($data['email']) : ''; ?>">
                                <div class="invalid-feedback">
                                    <?= $data['email_err']; ?>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-0">
                            <div class="col-4 fw-bold">Mobiel</div>
                            <div class="col-8">
                                <input type="tel" 
                                       name="mobiel" 
                                       id="mobiel" 
                                       class="form-control form-control-sm" 
                                       value="<?= !empty($data['mobiel']) ? htmlspecialchars($data['mobiel']) : ''; ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Knoppen volgens wireframe -->
            <div class="mt-3 d-flex justify-content-between">
                <button type="submit" form="editForm" class="btn btn-primary btn-sm">
                    Wijzig Klant Details
                </button>
                <div>
                    <a href="<?= URLROOT; ?>/klanten/details/<?= $data['id']; ?>" class="btn btn-secondary btn-sm me-2">terug</a>
                    <a href="<?= URLROOT; ?>" class="btn btn-primary btn-sm">home</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
