<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= URLROOT; ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= URLROOT; ?>/klanten">Klanten</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>
                    <i class="fas fa-user-circle me-2"></i>
                    <?= $data['title']; ?>
                </h1>
                <a href="<?= URLROOT; ?>/klanten" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Terug naar overzicht
                </a>
            </div>

            <?php if (empty($data['klant'])): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Klant niet gevonden.
                </div>
            <?php else: ?>
                <?php $hoofdklant = $data['klant'][0]; ?>
                
                <!-- Gezin Informatie -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-home me-2"></i>
                                    Gezin Informatie
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Gezin Naam:</strong> <?= htmlspecialchars($hoofdklant->GezinNaam); ?></p>
                                        <p><strong>Gezin Code:</strong> 
                                            <span class="badge bg-primary"><?= htmlspecialchars($hoofdklant->GezinCode); ?></span>
                                        </p>
                                        <p><strong>Omschrijving:</strong> <?= htmlspecialchars($hoofdklant->GezinOmschrijving); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Aantal Volwassenen:</strong> <?= $hoofdklant->AantalVolwassenen; ?></p>
                                        <p><strong>Aantal Kinderen:</strong> <?= $hoofdklant->AantalKinderen; ?></p>
                                        <p><strong>Aantal Baby's:</strong> <?= $hoofdklant->AantalBabys; ?></p>
                                        <p><strong>Totaal Personen:</strong> 
                                            <span class="badge bg-success"><?= $hoofdklant->TotaalAantalPersonen; ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-address-card me-2"></i>
                                    Contact Informatie
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($hoofdklant->Straat)): ?>
                                    <p><strong>Adres:</strong><br>
                                        <?= htmlspecialchars($hoofdklant->Straat); ?> 
                                        <?= htmlspecialchars($hoofdklant->Huisnummer); ?>
                                        <?= !empty($hoofdklant->Toevoeging) ? htmlspecialchars($hoofdklant->Toevoeging) : ''; ?><br>
                                        <?= htmlspecialchars($hoofdklant->Postcode); ?> 
                                        <?= htmlspecialchars($hoofdklant->Woonplaats); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if (!empty($hoofdklant->Email)): ?>
                                    <p><strong>Email:</strong><br>
                                        <a href="mailto:<?= htmlspecialchars($hoofdklant->Email); ?>">
                                            <?= htmlspecialchars($hoofdklant->Email); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if (!empty($hoofdklant->Mobiel)): ?>
                                    <p><strong>Telefoon:</strong><br>
                                        <a href="tel:<?= htmlspecialchars($hoofdklant->Mobiel); ?>">
                                            <?= htmlspecialchars($hoofdklant->Mobiel); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gezinsleden -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            Gezinsleden
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Naam</th>
                                        <th>Geboortedatum</th>
                                        <th>Type</th>
                                        <th>Vertegenwoordiger</th>
                                        <th>Leeftijd</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['klant'] as $persoon): ?>
                                        <?php 
                                        $geboortedatum = new DateTime($persoon->Geboortedatum);
                                        $vandaag = new DateTime();
                                        $leeftijd = $vandaag->diff($geboortedatum)->y;
                                        ?>
                                        <tr>
                                            <td>
                                                <?= htmlspecialchars($persoon->Voornaam); ?>
                                                <?= !empty($persoon->Tussenvoegsel) ? htmlspecialchars($persoon->Tussenvoegsel) . ' ' : ''; ?>
                                                <?= htmlspecialchars($persoon->Achternaam); ?>
                                            </td>
                                            <td><?= date('d-m-Y', strtotime($persoon->Geboortedatum)); ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= htmlspecialchars($persoon->TypePersoon); ?></span>
                                            </td>
                                            <td>
                                                <?php if ($persoon->IsVertegenwoordiger): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Ja
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Nee</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= $leeftijd; ?> jaar
                                                <?php if ($leeftijd < 2): ?>
                                                    <i class="fas fa-baby text-warning" title="Baby"></i>
                                                <?php elseif ($leeftijd < 18): ?>
                                                    <i class="fas fa-child text-info" title="Kind"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-user text-success" title="Volwassene"></i>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Acties -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-cogs me-2"></i>
                            Acties
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="btn-group" role="group">
                            <a href="<?= URLROOT; ?>/voedselpakketten/gezin/<?= $hoofdklant->GezinId; ?>" 
                               class="btn btn-success">
                                <i class="fas fa-box me-1"></i>
                                Voedselpakketten
                            </a>
                            <a href="<?= URLROOT; ?>/klanten/edit/<?= $hoofdklant->GezinId; ?>" 
                               class="btn btn-warning">
                                <i class="fas fa-edit me-1"></i>
                                Bewerken
                            </a>
                            <button class="btn btn-info" onclick="window.print()">
                                <i class="fas fa-print me-1"></i>
                                Print Details
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
