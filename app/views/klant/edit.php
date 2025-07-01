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

            <?php if (!empty($data['general_err'])): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= htmlspecialchars($data['general_err']); ?>
                </div>
            <?php endif; ?>

            <!-- Wijzig Klant Details volgens wireframe -->
            <div class="card shadow">
                <div class="card-header text-success">
                    <h5 class="mb-0">Wijzig Klant Details <?= htmlspecialchars($data['title']); ?></h5>
                </div>
                <div class="card-body p-3">
                    <form id="editForm" action="<?= URLROOT; ?>/klanten/edit/<?= $data['id']; ?>" method="POST" class="needs-validation" novalidate>
                        <!-- Bewerkbare velden -->
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Voornaam</div>
                            <div class="col-8">
                                <input type="text" 
                                       name="voornaam" 
                                       id="voornaam" 
                                       class="form-control form-control-sm <?= (!empty($data['voornaam_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= !empty($data['voornaam']) ? htmlspecialchars($data['voornaam']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback" id="voornaam-error">
                                    Voornaam is verplicht en mag geen cijfers bevatten
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
                                       value="<?= !empty($data['tussenvoegsel']) ? htmlspecialchars($data['tussenvoegsel']) : ''; ?>">
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
                                       value="<?= !empty($data['achternaam']) ? htmlspecialchars($data['achternaam']) : ''; ?>" 
                                       required>
                                <div class="invalid-feedback" id="achternaam-error">
                                    Achternaam is verplicht en mag geen cijfers bevatten
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
                                       min="1920-01-01"
                                       max="<?= date('Y-m-d'); ?>"
                                       required>
                                <div class="invalid-feedback" id="geboortedatum-error">
                                    Geboortedatum moet tussen 1920 en vandaag liggen
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <!-- Readonly velden -->
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
                                       pattern="[0-9]+"
                                       required>
                                <div class="invalid-feedback" id="huisnummer-error">
                                    Huisnummer mag alleen cijfers bevatten
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
                                       class="form-control form-control-sm <?= (!empty($data['mobiel_err'])) ? 'is-invalid' : ''; ?>" 
                                       value="<?= !empty($data['mobiel']) ? htmlspecialchars($data['mobiel']) : ''; ?>" 
                                       pattern="[0-9+\-\s()]*">
                                <div class="invalid-feedback" id="mobiel-error">
                                    Mobiel nummer mag alleen cijfers, spaties, +, -, ( en ) bevatten
                                </div>
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
// Uitgebreide client-side validatie
(function() {
    'use strict';
    
    // Validatie functies
    function validateName(value) {
        return value.trim() !== '' && !/\d/.test(value);
    }
    
    function validateBirthDate(value) {
        if (!value) return false;
        const date = new Date(value);
        const minDate = new Date('1920-01-01');
        const maxDate = new Date();
        return date >= minDate && date <= maxDate;
    }
    
    function validateHouseNumber(value) {
        return /^\d+$/.test(value.trim());
    }
    
    function validateMobile(value) {
        if (!value.trim()) return true; // Mobiel is optioneel
        return /^[0-9+\-\s()]*$/.test(value);
    }
    
    // Real-time validatie voor specifieke velden
    function addRealTimeValidation() {
        // Voornaam validatie
        const voornaamField = document.getElementById('voornaam');
        if (voornaamField) {
            voornaamField.addEventListener('input', function() {
                const isValid = validateName(this.value);
                toggleValidation(this, isValid);
            });
        }
        
        // Achternaam validatie
        const achternaamField = document.getElementById('achternaam');
        if (achternaamField) {
            achternaamField.addEventListener('input', function() {
                const isValid = validateName(this.value);
                toggleValidation(this, isValid);
            });
        }
        
        // Geboortedatum validatie
        const geboortedatumField = document.getElementById('geboortedatum');
        if (geboortedatumField) {
            geboortedatumField.addEventListener('change', function() {
                const isValid = validateBirthDate(this.value);
                toggleValidation(this, isValid);
            });
        }
        
        // Huisnummer validatie
        const huisnummerField = document.getElementById('huisnummer');
        if (huisnummerField) {
            huisnummerField.addEventListener('input', function() {
                const isValid = validateHouseNumber(this.value);
                toggleValidation(this, isValid);
            });
        }
        
        // Mobiel validatie
        const mobielField = document.getElementById('mobiel');
        if (mobielField) {
            mobielField.addEventListener('input', function() {
                const isValid = validateMobile(this.value);
                toggleValidation(this, isValid);
            });
        }
    }
    
    function toggleValidation(field, isValid) {
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
        }
    }
    
    window.addEventListener('load', function() {
        // Voeg real-time validatie toe
        addRealTimeValidation();
        
        // Bootstrap form validatie
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                let isFormValid = true;
                
                // Custom validatie checks
                const voornaam = document.getElementById('voornaam');
                if (voornaam && !validateName(voornaam.value)) {
                    toggleValidation(voornaam, false);
                    isFormValid = false;
                }
                
                const achternaam = document.getElementById('achternaam');
                if (achternaam && !validateName(achternaam.value)) {
                    toggleValidation(achternaam, false);
                    isFormValid = false;
                }
                
                const geboortedatum = document.getElementById('geboortedatum');
                if (geboortedatum && !validateBirthDate(geboortedatum.value)) {
                    toggleValidation(geboortedatum, false);
                    isFormValid = false;
                }
                
                const huisnummer = document.getElementById('huisnummer');
                if (huisnummer && !validateHouseNumber(huisnummer.value)) {
                    toggleValidation(huisnummer, false);
                    isFormValid = false;
                }
                
                const mobiel = document.getElementById('mobiel');
                if (mobiel && !validateMobile(mobiel.value)) {
                    toggleValidation(mobiel, false);
                    isFormValid = false;
                }
                
                // Combineer met Bootstrap validatie
                if (form.checkValidity() === false || !isFormValid) {
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
