<?php
require 'partials/head.php';
require 'partials/header.php';
?>


<?php if (!empty($_SESSION['success_message'])): ?>
    <div class="alert alert-success" role="alert">
        <?= htmlspecialchars($_SESSION['success_message']) ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<form method="POST" class="center-form" id="filterForm">
    <div class="checkbox-container">
        <div class="checkbox-item">
            <input type="checkbox" id="arme" name="arme" <?= isset($_POST['arme']) ? 'checked' : '' ?>
                onchange="document.getElementById('filterForm').submit();">
            <label for="arme">Armes</label>
        </div>
        <div class="checkbox-item">
            <input type="checkbox" id="munition" name="munition" <?= isset($_POST['munition']) ? 'checked' : '' ?>
                onchange="document.getElementById('filterForm').submit();">
            <label for="munition">Munitions</label>
        </div>
        <div class="checkbox-item">
            <input type="checkbox" id="armure" name="armure" <?= isset($_POST['armure']) ? 'checked' : '' ?>
                onchange="document.getElementById('filterForm').submit();">
            <label for="armure">Armures</label>
        </div>
        <div class="checkbox-item">
            <input type="checkbox" id="medicament" name="medicament" <?= isset($_POST['medicament']) ? 'checked' : '' ?>
                onchange="document.getElementById('filterForm').submit();">
            <label for="medicament">Médicaments</label>
        </div>
        <div class="checkbox-item">
            <input type="checkbox" id="nourriture" name="nourriture" <?= isset($_POST['nourriture']) ? 'checked' : '' ?>
                onchange="document.getElementById('filterForm').submit();">
            <label for="nourriture">Nourritures</label>
        </div>
        <div class="checkbox-item">
            <input type="checkbox" id="ressource" name="ressource" <?= isset($_POST['ressource']) ? 'checked' : '' ?>
                onchange="document.getElementById('filterForm').submit();">
            <label for="ressource">Ressources</label>
        </div>
    </div>
    <input type="text" id="search" name="search" placeholder="Rechercher un item"
        value="<?= htmlspecialchars($_POST['search'] ?? '') ?>"
        onchange="document.getElementById('filterForm').submit();"> <br>
</form>
<?php if (!empty($items)): ?>
    <div class="tab-content">
        <div class='tab-pane active' id='tab1' role='tabpanel'>
            <div class="table-container">

                <table class="table" style="width: 100%;">
                    <tr>
                        <?php $nbParLigne = 1;
                        foreach ($items as $index => $item) { ?>
                            <td>
                                <div class="img-thumbnail">
                                    <div class="price price-container"><?= $item->getPrixItem() ?><img class="price-container"
                                            src="public/img/caps.png" alt="caps" style="max-width: 16px"></div>
                                    <div class="quantity <?= $item->getQteStock() <= 0 ? 'stockZero' : '' ?>">
                                        <?= $item->getQteStock() ?> en stock</div>
                                    <h4><?= $item->getNomItem() ?></h4>
                                    <a href="detailItem?id=<?= $item->getIdItem() ?>">
                                        <img src="public/img/<?= $item->getPhoto() ?>" class="img-fluid"
                                            alt="<?= $item->getNomItem() ?>">
                                    </a>
                                    <div><strong><?= getTypeItemName($item->getTypeItem()) ?></strong></div>
                                    <div><strong>Utilité : </strong> <?= $item->getUtilite() ?></div>
                                    <div class="caption">
                                        <div class="weight price-container"><?= $item->getPoidsItem() ?> lbs<img
                                                src="public/img/weight.webp" alt="lbs" class="price-container"
                                                style="max-width: 16px"></div>
                                        
                                        <form method="POST">
                                            <input type="hidden" name="idItem" value="<?= $item->getIdItem() ?>">
                                            <input type="hidden" name="name" value="<?= $item->getNomItem() ?>">
                                            <input type="hidden" name="prixItem" value="<?= $item->getPrixItem() ?>">
                                            <input type="hidden" name="image" value="<?= $item->getPhoto() ?>">
                                            <input type="hidden" name="typeItem" value="<?= $item->getTypeItem() ?>">
                                            <input type="hidden" name="utilite" value="<?= $item->getUtilite() ?>">
                                            <br>
                                            <br>
                                            <button type="submit"
                                                class="btn btn-order add-to-cart <?= isAdministrator() || !isAuthenticated() || $item->getQteStock() <= 0 ? 'btn-danger' : 'btn-primary' ?>"
                                                name="add_to_cart" <?= isAdministrator() || !isAuthenticated() || $item->getQteStock() <= 0 ? 'disabled' : '' ?>>
                                                <span class="bi-cart-fill"></span> Ajouter au panier
                                            </button>
                                            <?php if (!isAuthenticated()): ?>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <?php if ($nbParLigne % 3 == 0) {
                                echo "</tr><tr>";
                                $nbParLigne = 1;
                            } else {
                                $nbParLigne++;
                            } ?>
                        <?php } ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <p style="text-align: center;">Aucun item disponible.</p>
<?php endif; ?>
</main>
<?php require 'partials/footer.php'; ?>

</html>