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

<div class="container mt-5">
    <h2>Modifier votre profil</h2>
    <form method="POST" action="/modifProfil" style="max-width: 500px; margin: auto;">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($_SESSION['username']) ?>" required>
        </div>
        <div class="form-group mt-3">
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group mt-3">
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Enregistrer les modifications</button>
    </form>
</div>

<?php require 'partials/footer.php'; ?>