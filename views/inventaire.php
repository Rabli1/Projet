<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success_message'] ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error_message'] ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>


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
                        <th>Actions</th>
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
            <td>
                <?php if ($item['typeItem'] === 'n'): ?>
                <form method="POST" action="inventaire" style="padding-bottom: 50%;">
                    <input type="hidden" name="idItem" value="<?= $item['idItem'] ?>">
                    <button type="submit" name="manger" class="btn btn-success" 
                        <?= $item['qteItems'] <= 1 && $item['utilité'] == 1 ? 'disabled' : '' ?>>
                        Manger
                    </button>
                </form>
            <?php endif; ?>
            <?php if ($item['typeItem'] === 'm'): ?>
                <form method="POST" action="inventaire" style="padding-bottom: 50%;">
                <input type="hidden" name="idItem" value="<?= $item['idItem'] ?>">
                <button type="submit" name="consomme" class="btn btn-success"
                        <?= $item['qteItems'] <= 1 && $item['utilité'] == 1 ? 'disabled' : '' ?>>
                        Consommer
                </button>
                </form>
            <?php endif; ?>
            <form method="POST" action="inventaire" style="text-align: center;">
                <input type="hidden" name="idItem" value="<?= $item['idItem'] ?>">
                <?php if (!($item['qteItems'] == 1 && $item['utilité'] == 1)): ?>
                    <select name="quantite" class="select-quantite" style="margin-bottom: 5%;">
                    <?php 
                        $maxQuantite = $item['utilité'] == 1 ? $item['qteItems'] - 1 : $item['qteItems'];
                        for ($i = 1; $i <= $maxQuantite; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                <?php endif; ?>
                <button type="submit" name="sell_item" class="btn btn-danger" 
                    <?= $item['qteItems'] <= 1 && $item['utilité'] == 1 ? 'disabled' : '' ?>>
                    Vendre
                </button>
                <button type="submit" name="jeter_item" class="btn btn-warning" 
                    <?= $item['qteItems'] <= 1 && $item['utilité'] == 1 ? 'disabled' : '' ?>>
                    Jeter
                </button>
            </form>
            </td>
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