<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
<main class="container mt-5">
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
    <?php if (isset($nomJoueur)): ?>
        <h2>Bienvenue, <?= htmlspecialchars($nomJoueur) ?> !</h2>
        <h4>Poids restant dans votre inventaire : <?= max(0, $remainingWeight) ?> lbs</h4>
        <h4>Montant de caps : <?= $joueur->getMontantCaps() ?> <img src="public/img/caps.png" alt="caps" style="max-width: 16px"></h4>
        <h4>Dextérité actuelle : <?= $joueur->getDexterite() ?></h4>
    <?php endif; ?>

    <?php if (!empty($cartItems)) { ?>
        <div class="table-responsive">
            <table class="table table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Poids</th>
                        <th>Quantité</th>
                        <th>Retirer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalPrice = 0;
                    $totalWeight = 0;
                    $totalItems = 0;
                    foreach ($cartItems as $item) { 
                        $totalPrice += $item->getPrixItem() * $item->getQuantite();
                        $totalWeight += $item->getPoidsItem() * $item->getQuantite();
                        $totalItems += $item->getQuantite();
                    
                    ?>
                        <tr>
                            <td><img src="public/img/<?= $item->getPhoto() ?>" class="img-fluid" alt="<?= $item->getNomItem() ?>" style="max-width: 20%"></td>
                            <td><?= $item->getNomItem() ?></td>
                            <td>
                                <div class="price-container">
                                    <?= $item->getPrixItem() ?>
                                    <img src="public/img/caps.png" alt="caps">
                                </div>
                            </td>
                            <td>
                                <div class="price-container">
                                <?= $item->getPoidsItem() ?> lbs
                                <img src="public/img/weight.webp" alt="lbs" style="max-width: 16px">
                                </div>
                            </td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?= $item->getIdItem() ?>">
                                    <select name="quantite" class="select-quantite" onchange="this.form.submit()">
                                        <?php for ($i = 1; $i <= $item->getQteStock(); $i++): ?>
                                            <option value="<?= $i ?>" <?= $i == $item->getQuantite() ? 'selected' : '' ?>>
                                                <?= $i ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?= $item->getIdItem() ?>">
                                    <button type="submit" name="remove_item" class="btn btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="price-container mt-3">
    <h3>Total: <?= $totalPrice ?> <img src="public/img/caps.png" alt="caps" class="img-fluid" style="max-width: 9%"></h3>
    <h3>Nombre total d'items: <?= $totalItems ?></h3>
    <h3>Poids total: <?= $totalWeight ?> lbs <img src="public/img/weight.webp" alt="lbs" class="img-fluid" style="max-width: 9%"></h3>
    <form method="POST" action="">
        <button type="submit" name="buy_items" class="btn btn-success">Acheter</button>
        <button type="submit" name="clear_cart" class="btn btn-danger">Supprimer le panier</button>
        <div class="mt-3">
            <?php if ($joueur->getMontantCaps() < $totalPrice): ?>
                <div class="alert alert-danger" role="alert">
                    Attention : Vous n'avez pas assez de caps pour acheter ces items. Vous avez <?= $joueur->getMontantCaps() ?> caps, mais le total est de <?= $totalPrice ?> caps.
                </div>
            <?php endif; ?>
            <?php if ($totalWeight > $remainingWeight): ?>
                <div class="alert alert-warning" role="alert">
                    Attention : Vous perdrez <?= $dexterityPenalty ?> points de dextérité en raison du poids excédentaire.
                </div>
            <?php endif; ?>
        </div>
    </form>
</div>
    <?php } else { ?>
        <p>Le panier est vide.</p>
    <?php } ?>
</main>

<?php require 'partials/footer.php'; ?>

</body>
</html>