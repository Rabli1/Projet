<?php
require_once 'src/class/Database.php';
require_once 'src/functions.php';
require_once 'models/ItemsModel.php';
require_once 'models/BackpackModel.php';
require_once 'models/JoueursModel.php';
require_once 'models/NourrituresModel.php';
require_once 'models/MédicamentModel.php';

$db = Database::getInstance($dbConfig, $dbParams);
$pdo = $db->getPDO();
$itemsModel = new ItemsModel($pdo);
$backpackModel = new BackpackModel($pdo);
$joueursModel = new JoueursModel($pdo);
$nourrituresModel = new NourrituresModel($pdo);
$medicamentsModel = new MédicamentsModel($pdo);


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

if (isset($_POST['sell_item']) && !empty($_POST['idItem']) && !empty($_POST['quantite'])) {
    $idItem = intval($_POST['idItem']);
    $quantite = intval($_POST['quantite']);

    $item = $backpackModel->getItemFromBackpack($joueur->getIdJoueur(), $idItem);

    if ($item && $item['qteItems'] >= $quantite) {
        $totalPrice = $item['prixItem'] * $quantite * 0.6;

        $newQuantity = $item['qteItems'] - $quantite;
        $backpackModel->updateItemQuantity($joueur->getIdJoueur(), $idItem, $newQuantity);

        $joueursModel->updateCaps($joueur->getIdJoueur(), $joueur->getMontantCaps() + $totalPrice);

        $_SESSION['success_message'] = "Vous avez vendu $quantite " . htmlspecialchars($item['nomItem']) . " pour $totalPrice caps.";
    } else {
        $_SESSION['error_message'] = "Erreur : Quantité invalide ou insuffisante.";
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manger'])) {
    $idItem = (int)$_POST['idItem'];

    try {
        $item = $itemsModel->selectById($idItem);
        if (!$item || $item->getTypeItem() !== 'n') {
            throw new Exception("Cet item n'est pas une nourriture.");
        }

        $nourriture = $nourrituresModel->selectById($idItem);
        if (!$nourriture) {
            throw new Exception("Impossible de récupérer les informations de la nourriture.");
        }

        $backpackModel->mangerNourriture($joueur->getIdJoueur(), $idItem, $nourriture->getPtsVie());

        $_SESSION['success_message'] = "Vous avez mangé " . htmlspecialchars($item->getNomItem()) . " et gagné " . $nourriture->getPtsVie() . " points de vie.";
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Erreur lors de la consommation de la nourriture : " . $e->getMessage();
    }

    header('Location: /inventaire');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consomme'])) {
    $idItem = (int)$_POST['idItem'];

    try {
        $item = $itemsModel->selectById($idItem);
        if (!$item || $item->getTypeItem() !== 'm') {
            throw new Exception("Cet item n'est pas un médicament.");
        }

        $medicament = $medicamentsModel->selectById($idItem);
        if (!$medicament) {
            throw new Exception("Impossible de récupérer les informations du médicament.");
        }

        $backpackModel->mangerNourriture($joueur->getIdJoueur(), $idItem, $medicament->getPtsVie());

        $_SESSION['success_message'] = "Vous avez consommé " . htmlspecialchars($item->getNomItem()) . " et gagné " . $medicament->getPtsVie() . " points de vie.";
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Erreur lors de la consommation du médicament : " . $e->getMessage();
    }

    header('Location: /inventaire');
    exit;
}

require 'views/inventaire.php';