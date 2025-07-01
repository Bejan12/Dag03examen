<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <?php if (empty($data['klant'])): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Klant niet gevonden.
                </div>
            <?php else: ?>
                <?php $hoofdklant = $data['klant'][0]; ?>
                
                <!-- Klant Details volgens wireframe -->
                <div class="card shadow">
                    <div class="card-header text-success">
                        <h5 class="mb-0">Klant Details <?= htmlspecialchars($data['title']); ?></h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Voornaam</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Voornaam) ? htmlspecialchars($hoofdklant->Voornaam) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Tussenvoegsel</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Tussenvoegsel) ? htmlspecialchars($hoofdklant->Tussenvoegsel) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Achternaam</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Achternaam) ? htmlspecialchars($hoofdklant->Achternaam) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Geboortedatum</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Geboortedatum) ? htmlspecialchars(date('d-m-Y', strtotime($hoofdklant->Geboortedatum))) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">TypePersoon</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->TypePersoon) ? htmlspecialchars($hoofdklant->TypePersoon) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Vertegenwoordiger</div>
                            <div class="col-8">
                                <?= $hoofdklant->IsVertegenwoordiger ? 'Ja' : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Straatnaam</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Straat) ? htmlspecialchars($hoofdklant->Straat) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Huisnummer</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Huisnummer) ? htmlspecialchars($hoofdklant->Huisnummer) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Toevoeging</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Toevoeging) ? htmlspecialchars($hoofdklant->Toevoeging) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Postcode</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Postcode) ? htmlspecialchars($hoofdklant->Postcode) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Woonplaats</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Woonplaats) ? htmlspecialchars($hoofdklant->Woonplaats) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Email</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Email) ? htmlspecialchars($hoofdklant->Email) : '~~~~'; ?>
                            </div>
                        </div>
                        <hr class="my-2">
                        
                        <div class="row mb-0">
                            <div class="col-4 fw-bold">Mobiel</div>
                            <div class="col-8">
                                <?= !empty($hoofdklant->Mobiel) ? htmlspecialchars($hoofdklant->Mobiel) : str_repeat('~', 20); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Knoppen volgens wireframe -->
                <div class="mt-3 d-flex justify-content-between">
                    <a href="<?= URLROOT; ?>/klanten/edit/<?= $hoofdklant->GezinId; ?>" 
                       class="btn btn-primary btn-sm">
                        Wijzig
                    </a>
                    <div>
                        <a href="<?= URLROOT; ?>/klanten" class="btn btn-secondary btn-sm me-2">terug</a>
                        <a href="<?= URLROOT; ?>" class="btn btn-primary btn-sm">home</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
