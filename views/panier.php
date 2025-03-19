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

    <script>
        function updateQuantity(form) {
            form.submit();
        }
    </script>
</head>
<body>
<main class="container mt-5">
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
                    foreach ($cartItems as $item) { 
                        $totalPrice += $item->getPrixItem() * $item->getQuantite();
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
                                    <select name="quantite" class="select-quantite" onchange="updateQuantity(this.form)">
                                        <?php for ($i = 1; $i <= $item->getQteStock(); $i++): ?>
                                            <option value="<?= $i ?>" <?= $i == $item->getQuantite() ? 'selected' : '' ?>>
                                                <?= $i ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                
                            </td>
                            <td>
                                    <div class="mt-2">
                                        <button type="submit" name="remove_item" class="btn btn-outline-danger">Supprimer</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="price-container mt-3">
            <h3>Total: <?= $totalPrice ?> <img src="public/img/caps.png" alt="caps" class="img-fluid" style="max-width: 9%"></h3>
        </div>
    <?php } else { ?>
        <p>Le panier est vide.</p>
    <?php } ?>
</main>

<?php require 'partials/footer.php'; ?>

</body>
</html>