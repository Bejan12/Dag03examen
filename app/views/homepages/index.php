<?php require_once APPROOT . '/views/includes/header.php'; ?>

<!-- Voor het centreren van de container gebruiken we het bootstrap grid -->
<div class="container">
    <div class="row mt-3">

        <div class="col-2"></div>

        <div class="col-8">

            <h3><?php echo $data['title']; ?></h3>
            
            <!-- Navigation links -->
            <div class="mt-4">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Manager'): ?>
                    <a href="<?= URLROOT; ?>voedselpakketten/overzicht" class="btn btn-primary">
                        Overzicht voedselpakketten
                    </a>
                <?php endif; ?>
                
                <!-- Andere links die voor alle gebruikers toegankelijk zijn -->
                <a href="<?= URLROOT; ?>klanten" class="btn btn-secondary">
                    Overzicht Klanten
                </a>
            </div>

        </div>
        
        <div class="col-2"></div>
        
    </div>

</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>