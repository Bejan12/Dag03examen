<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-success">
                Klant Details <?= htmlspecialchars($data['klant']->Voornaam . ' ' . (!empty($data['klant']->Tussenvoegsel) ? $data['klant']->Tussenvoegsel . ' ' : '') . $data['klant']->Achternaam); ?>
            </h2>
            
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

            <form action="<?= URLROOT; ?>/klanten/edit/<?= $data['id']; ?>" method="POST" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Persoonlijke gegevens -->
                        <div class="mb-3">
                            <label for="voornaam" class="form-label">Voornaam</label>
                            <input type="text" 
                                   name="voornaam" 
                                   id="voornaam" 
                                   class="form-control <?= (!empty($data['voornaam_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['voornaam']; ?>" 
                                   readonly>
                            <div class="invalid-feedback">
                                <?= $data['voornaam_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tussenvoegsel" class="form-label">Tussenvoegsel</label>
                            <input type="text" 
                                   name="tussenvoegsel" 
                                   id="tussenvoegsel" 
                                   class="form-control" 
                                   value="<?= $data['tussenvoegsel']; ?>" 
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label for="achternaam" class="form-label">Achternaam</label>
                            <input type="text" 
                                   name="achternaam" 
                                   id="achternaam" 
                                   class="form-control <?= (!empty($data['achternaam_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['achternaam']; ?>" 
                                   readonly>
                            <div class="invalid-feedback">
                                <?= $data['achternaam_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="geboortedatum" class="form-label">Geboortedatum</label>
                            <input type="date" 
                                   name="geboortedatum" 
                                   id="geboortedatum" 
                                   class="form-control" 
                                   value="<?= $data['geboortedatum']; ?>" 
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label for="typepersoon" class="form-label">TypePersoon</label>
                            <input type="text" 
                                   name="typepersoon" 
                                   id="typepersoon" 
                                   class="form-control" 
                                   value="<?= $data['typepersoon']; ?>" 
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label for="vertegenwoordiger" class="form-label">Vertegenwoordiger</label>
                            <input type="text" 
                                   name="vertegenwoordiger" 
                                   id="vertegenwoordiger" 
                                   class="form-control" 
                                   value="<?= $data['vertegenwoordiger'] ? 'Ja' : 'Nee'; ?>" 
                                   readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Contactgegevens (bewerkbaar) -->
                        <div class="mb-3">
                            <label for="straat" class="form-label">Straatnaam</label>
                            <input type="text" 
                                   name="straat" 
                                   id="straat" 
                                   class="form-control <?= (!empty($data['straat_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['straat']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?= $data['straat_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="huisnummer" class="form-label">Huisnummer</label>
                            <input type="text" 
                                   name="huisnummer" 
                                   id="huisnummer" 
                                   class="form-control <?= (!empty($data['huisnummer_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['huisnummer']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?= $data['huisnummer_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="toevoeging" class="form-label">Toevoeging</label>
                            <input type="text" 
                                   name="toevoeging" 
                                   id="toevoeging" 
                                   class="form-control" 
                                   value="<?= $data['toevoeging']; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="postcode" class="form-label">Postcode</label>
                            <input type="text" 
                                   name="postcode" 
                                   id="postcode" 
                                   class="form-control <?= (!empty($data['postcode_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['postcode']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?= $data['postcode_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="woonplaats" class="form-label">Woonplaats</label>
                            <input type="text" 
                                   name="woonplaats" 
                                   id="woonplaats" 
                                   class="form-control <?= (!empty($data['woonplaats_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['woonplaats']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?= $data['woonplaats_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['email']; ?>">
                            <div class="invalid-feedback">
                                <?= $data['email_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mobiel" class="form-label">Mobiel</label>
                            <input type="tel" 
                                   name="mobiel" 
                                   id="mobiel" 
                                   class="form-control" 
                                   value="<?= $data['mobiel']; ?>">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="submit" class="btn btn-primary">
                        Wijzig
                    </button>
                    <div>
                        <a href="<?= URLROOT; ?>/klanten/details/<?= $data['id']; ?>" class="btn btn-secondary me-2">
                            terug
                        </a>
                        <a href="<?= URLROOT; ?>" class="btn btn-primary">
                            home
                        </a>
                    </div>
                </div>
            </form>
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
