<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header text-center text-success">
                    <h4 class="mb-0">
                        <i class="bi bi-box-seam me-2"></i>
                        Voedselbank Maaskantje
                    </h4>
                    <p class="mb-0 mt-2 text-muted">Inloggen</p>
                </div>
                <div class="card-body p-4">
                    <form action="<?= URLROOT; ?>/auth/login" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email adres</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['email']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?= $data['email_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Wachtwoord</label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?= $data['password']; ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?= $data['password_err']; ?>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Inloggen
                            </button>
                        </div>
                    </form>
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
