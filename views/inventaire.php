<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<main class="container mt-5">
    <?php if (isset($nomJoueur)): ?>
        <h2>Inventaire de <?= htmlspecialchars($nomJoueur) ?></h2>
        <h4>Montant de caps : <?= $montantCaps ?> <img src="public/img/caps.png" alt="caps" style="max-width: 16px"></h4>
    <?php endif; ?>

    <?php if (!empty($backpackItems)) { ?>
        <div class="table-responsive">
            <table class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Poids</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalWeight = 0;
                    foreach ($backpackItems as $item) { 
                        $totalWeight += $item['poidsItem'] * $item['qteItems'];
                    ?>
                        <tr>
                            <td><img src="public/img/<?= $item['photo'] ?>" class="img-fluid" alt="<?= $item['nomItem'] ?>" style="max-width: 20%"></td>
                            <td><?= htmlspecialchars($item['nomItem']) ?></td>
                            <td>
                                <div class="price-container">
                                    <?= $item['prixItem'] ?>
                                    <img src="public/img/caps.png" alt="caps">
                                </div>
                            </td>
                            <td>
                                <div class="price-container">
                                    <?= $item['poidsItem'] ?> lbs
                                    <img src="public/img/weight.webp" alt="lbs" style="max-width: 16px">
                                </div>
                            </td>
                            <td><?= $item['qteItems'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="price-container mt-3">
            <h3>Poids total : <?= $totalWeight ?> lbs <img src="public/img/weight.webp" alt="lbs" class="img-fluid" style="max-width: 9%"></h3>
        </div>
    <?php } else { ?>
        <p>Votre sac à dos est vide.</p>
    <?php } ?>
</main>

<?php require 'partials/footer.php'; ?>