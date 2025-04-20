<?php
require 'partials/head.php';
require 'partials/header.php';
?>

<main class="container mt-5">
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (!empty($joueurs)): ?>
        <div class="players-container">
            <?php foreach ($joueurs as $joueur): ?>
                <div class="player-card">
                    <h4><?= htmlspecialchars($joueur->getAlias()) ?></h4>
                    <p><strong>Nom :</strong> <?= htmlspecialchars($joueur->getNom()) ?></p>
                    <p><strong>Prénom :</strong> <?= htmlspecialchars($joueur->getPrenom()) ?></p>
                    <p><strong>Caps :</strong> <?= $joueur->getMontantCaps() ?> caps</p>
                    <p><strong>Augmentations :</strong> <?= $joueur->getAjoutCapsCount() ?>/3</p>
                    <form method="POST" action="">
                        <input type="hidden" name="joueur_id" value="<?= $joueur->getIdJoueur() ?>">
                        <button type="submit" name="capsAjout" class="btn btn-success"
                            <?= $joueur->getAjoutCapsCount() >= 3 ? 'disabled' : '' ?>>
                            Augmenter le capital
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align: center;">Aucun joueur disponible.</p>
    <?php endif; ?>
</main>

<?php require 'partials/footer.php'; ?>