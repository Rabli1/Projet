<?php
require_once 'src/class/Database.php';
require_once 'src/functions.php';
require_once 'models/ItemsModel.php';
require_once 'models/BackpackModel.php';
require_once 'models/JoueursModel.php';

$db = Database::getInstance($dbConfig, $dbParams);
$pdo = $db->getPDO();
$itemsModel = new ItemsModel($pdo);
$backpackModel = new BackpackModel($pdo);
$joueursModel = new JoueursModel($pdo);


sessionStart();

if (isAuthenticated()) {
    $username = $_SESSION['username'];
    $joueur = $joueursModel->getJoueurByAlias($username);

    $backpackItems = $backpackModel->getItemsInBackpack($joueur->getIdJoueur());

    $nomJoueur = $joueur->getAlias();
    $montantCaps = $joueur->getMontantCaps();
} else {
    header('Location: /connexion');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sell_item'])) {
    $idItem = (int)$_POST['idItem'];

    try {
        // Récupérer les informations de l'item
        $item = $itemsModel->selectById($idItem);
        if (!$item) {
            throw new Exception("Item introuvable.");
        }

        // Appeler la méthode pour vendre l'item
        $backpackModel->sellItemFromBackpack($joueur->getIdJoueur(), $idItem, $item->getPrixItem());
        // Mettre à jour les caps du joueur
        $_SESSION['success_message'] = "Item vendu avec succès ! Vous avez gagné " . ($item->getPrixItem() * 0.6) . " caps.";
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Erreur lors de la vente de l'item : " . $e->getMessage();
    }

    header('Location: /inventaire');
    exit;
}

require 'views/inventaire.php';