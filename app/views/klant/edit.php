<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><?php echo $data['title']; ?></h2>
            <p class="mb-4">Wijzig de contactgegevens van <strong><?php echo $data['klant']->Voornaam . ' ' . $data['klant']->Tussenvoegsel . ' ' . $data['klant']->Achternaam; ?></strong></p>
            
            <?php if (isset($data['success'])): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo $data['success']; ?>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = '<?php echo URLROOT; ?>/klanten/details/<?php echo $data['id']; ?>';
                    }, 3000);
                </script>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    U wordt automatisch doorverwezen naar de klantdetails...
                </div>
            <?php endif; ?>

            <form action="<?php echo URLROOT; ?>/klanten/edit/<?php echo $data['id']; ?>" method="POST" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="straat" class="form-label">Straat <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="straat" 
                                   id="straat" 
                                   class="form-control <?php echo (!empty($data['straat_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['straat']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?php echo $data['straat_err']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="huisnummer" class="form-label">Huisnummer <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="huisnummer" 
                                   id="huisnummer" 
                                   class="form-control <?php echo (!empty($data['huisnummer_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['huisnummer']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?php echo $data['huisnummer_err']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="toevoeging" class="form-label">Toevoeging</label>
                            <input type="text" 
                                   name="toevoeging" 
                                   id="toevoeging" 
                                   class="form-control" 
                                   value="<?php echo $data['toevoeging']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="postcode" class="form-label">Postcode <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="postcode" 
                                   id="postcode" 
                                   class="form-control <?php echo (!empty($data['postcode_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['postcode']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?php echo $data['postcode_err']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="woonplaats" class="form-label">Woonplaats <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="woonplaats" 
                                   id="woonplaats" 
                                   class="form-control <?php echo (!empty($data['woonplaats_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['woonplaats']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?php echo $data['woonplaats_err']; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mailadres</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['email']; ?>">
                            <div class="invalid-feedback">
                                <?php echo $data['email_err']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobiel" class="form-label">Mobiel nummer</label>
                            <input type="tel" 
                                   name="mobiel" 
                                   id="mobiel" 
                                   class="form-control" 
                                   value="<?php echo $data['mobiel']; ?>">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="<?php echo URLROOT; ?>/klanten/details/<?php echo $data['id']; ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Terug naar klantdetails
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy me-1"></i>
                        Wijzigingen opslaan
                    </button>
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
