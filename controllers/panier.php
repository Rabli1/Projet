<?php
require_once 'src/class/Database.php';
require_once 'src/functions.php';
require_once 'models/ItemsModel.php';
require_once 'models/JoueursModel.php';
require_once 'models/BackpackModel.php';

$db = Database::getInstance($dbConfig, $dbParams);
$pdo = $db->getPDO();
$itemsModel = new ItemsModel($pdo);
$backpackModel = new BackpackModel($pdo);
$joueursModel = new JoueursModel($pdo);
sessionStart();

if (isAuthenticated()) {
    $username = $_SESSION['username'];
    $joueur = $joueursModel->getJoueurByAlias($username);

    if (!$joueur) {
        header('Location: /connexion');
        exit;
    }

    $poidsTotalBackpack = $backpackModel->selectBackpackById($joueur->getIdJoueur());
    $nomJoueur = $joueur->getAlias();
    $montantCaps = $joueur->getMontantCaps();
} else {
    header('Location: /connexion');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['remove_item']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);

    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($cartId) use ($id) {
        return $cartId !== $id;
    });

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

$cartItems = [];
$totalWeight = 0;
$totalPrice = 0;

if (!empty($_SESSION['cart'])) {
    $quantities = array_count_values($_SESSION['cart']);
    foreach ($quantities as $id => $quantite) {
        $item = $itemsModel->selectById($id);
        if ($item) {
            $item->setQuantite($quantite);
            $cartItems[] = $item;
            $totalWeight += $item->getPoidsItem() * $quantite;
            $totalPrice += $item->getPrixItem() * $quantite;
        }
    }
}

$currentWeight = 0;
$backpack = $backpackModel->getItemsInBackpack($joueur->getIdJoueur());

if (!empty($backpack) && is_array($backpack)) {
    foreach ($backpack as $item) {
        $currentWeight += $item['poidsItem'] * $item['qteItems'];
    }
}

$poidsMaxTransport = $joueur->getPoidsMaxTransport();
$remainingWeight = $poidsMaxTransport - $currentWeight;

$dexterityPenalty = 0;
if ($totalWeight > $remainingWeight) {
    $excessWeight = $totalWeight - $remainingWeight;
    $dexterityPenalty = $excessWeight * 3;
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

require 'views/panier.php';