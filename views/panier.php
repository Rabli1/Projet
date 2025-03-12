<?php require 'partials/head.php'; ?>
<?php require 'partials/header.php'; ?>

<main>
    <div class="container-fluid row align-items-start">
        <div class="col-8">
            <div class="container row admin">
                <h1><strong>Panier d'achats</strong></h1>
                <div class="mb-3">
                    <!-- Bouton Accueil -->
                    <a href="/" class="btn btn-primary">Accueil</a>
                </div>
                <hr>
                <?php if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="row align-items-center mb-3">
                            <!-- Image de l'article -->
                            <div class="col-4">
                                <img src="public/uploads/<?= htmlspecialchars($item['image']) ?>"
                                    alt="<?= htmlspecialchars($item['name']) ?>" class="cart-detail-image img-fluid">
                            </div>

                            <!-- Détails de l'article -->
                            <div class="col-5">
                                <h4><?= htmlspecialchars($item['name']) ?></h4>
                                <p><?= htmlspecialchars($item['description']) ?></p>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <label>Quantité:</label>
                                    <select name="quantity" class="form-select w-50">
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>" <?= $i == $item['quantity'] ? 'selected' : '' ?>>
                                                <?= $i ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="mt-2">
                                        <button type="submit" name="update_quantity"
                                            class="btn btn-outline-secondary">MAJ</button>
                                        <button type="submit" name="remove_item"
                                            class="btn btn-outline-danger">Supprimer</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Prix unitaire -->
                            <div class="col-3 text-right">
                                <h5><?= number_format($item['price'], 2) ?> $</h5>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Votre panier est vide.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Résumé de la commande -->
        <div class="col-4">
            <div class="row admin">
                <h3>Résumé de la commande</h3>
                <hr>
                <h4>Sous-total (<span id="sub-total-items-count">
                        <?= array_reduce($cartItems, function ($total, $item) {
                            return $total + $item['quantity'];
                        }, 0) ?>
                    </span> items):
                    <strong><span id="sub-total-amount-formatted"><?= number_format($subTotal, 2) ?> $</span></strong>
                </h4>
                <a href="/checkout" class="btn cart-proceed-to-checkout">Passer à la caisse</a>
            </div>
        </div>
    </div>
</main>

<?php require 'partials/footer.php'; ?>