<?php

require 'partials/head.php';
require 'partials/header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knapsack</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<main class="container mt-5">
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Formulaire de recherche -->
    <form method="POST" class="center-form mb-4">
        <div class="checkbox-container d-flex flex-wrap justify-content-center mb-3">
            <div class="form-check me-3">
                <input type="checkbox" class="form-check-input" id="arme" name="arme">
                <label class="form-check-label" for="arme">Armes</label>
            </div>
            <div class="form-check me-3">
                <input type="checkbox" class="form-check-input" id="munition" name="munition">
                <label class="form-check-label" for="munition">Munitions</label>
            </div>
            <div class="form-check me-3">
                <input type="checkbox" class="form-check-input" id="armure" name="armure">
                <label class="form-check-label" for="armure">Armures</label>
            </div>
            <div class="form-check me-3">
                <input type="checkbox" class="form-check-input" id="medicament" name="medicament">
                <label class="form-check-label" for="medicament">Médicaments</label>
            </div>
            <div class="form-check me-3">
                <input type="checkbox" class="form-check-input" id="nourriture" name="nourriture">
                <label class="form-check-label" for="nourriture">Nourritures</label>
            </div>
            <div class="form-check me-3">
                <input type="checkbox" class="form-check-input" id="ressource" name="ressource">
                <label class="form-check-label" for="ressource">Ressources</label>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <input type="text" id="search" name="search" class="form-control w-50 me-2" placeholder="Rechercher un item">
            <button type="submit" class="btn btn-primary" name="search_button">Rechercher</button>
        </div>
    </form>

    <!-- Affichage des items -->
    <div class="row">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="public/img/<?= $item->getPhoto() ?>" class="card-img-top img-fluid" alt="<?= $item->getNomItem() ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($item->getNomItem()) ?></h5>
                        <p class="card-text">
                            <strong>Prix :</strong> <?= $item->getPrixItem() ?> <img src="public/img/caps.png" alt="caps" style="max-width: 16px"><br>
                            <strong>Stock :</strong> <?= $item->getQteStock() ?><br>
                            <strong>Poids :</strong> <?= $item->getPoidsItem() ?> lbs<br>
                            <strong>Type :</strong> <?= getTypeItemName($item->getTypeItem()) ?><br>
                            <strong>Utilité :</strong> <?= $item->getUtilite() ?>
                        </p>
                        <?php
                        switch ($item->getTypeItem()) {
                            case 'r':
                                $armure = $armuresModel->selectById($item->getIdItem());
                                if ($armure) {
                                    echo "<p><strong>Matière :</strong> " . $armure->getMatière() . "</p>";
                                    echo "<p><strong>Taille :</strong> " . $armure->getTaille() . "</p>";
                                }
                                break;
                            case 'a':
                                $arme = $armesModel->selectById($item->getIdItem());
                                if ($arme) {
                                    echo "<p><strong>Efficacité :</strong> " . $arme->getEfficacité() . "</p>";
                                    echo "<p><strong>Type :</strong> " . $arme->getTypeArmes() . "</p>";
                                    echo "<p><strong>Description :</strong> " . $arme->getDescription() . "</p>";
                                }
                                break;
                            // Ajoutez les autres cas ici...
                        }
                        ?>
                    </div>
                    <div class="card-footer text-center">
                        <form method="POST">
                            <input type="hidden" name="idItem" value="<?= $item->getIdItem() ?>">
                            <button type="submit" class="btn btn-success btn-sm" name="add_to_cart" <?= !isAuthenticated() ? 'disabled' : '' ?>>
                                <i class="bi bi-cart-fill"></i> Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php require 'partials/footer.php'; ?>
</html>