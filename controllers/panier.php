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
    $_SESSION['cart']['nbTotItem'] = 0;
}

if (isset($_POST['quantite']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $quantite = intval($_POST['quantite']);

    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($cartId) use ($id) {
            return $cartId !== $id;
        });

        for ($i = 0; $i < $quantite; $i++) {
            $_SESSION['cart'][] = $id;
        }
    }

    $_SESSION['cart']['nbTotItem'] = count($_SESSION['cart']);

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if (isset($_POST['remove_item']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);

    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($cartId) use ($id) {
        return $cartId !== $id;
    });

    $_SESSION['cart']['nbTotItem'] = count($_SESSION['cart']);

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

if (isset($_POST['buy_items'])) {
    if ($joueur->getMontantCaps() >= $totalPrice) {
        if ($totalWeight > $remainingWeight) {
            $excessWeight = $totalWeight - $remainingWeight;
            $dexterityPenalty = $excessWeight * 3;

            $newDexterity = max(0, $joueur->getDexterite() - $dexterityPenalty);
            $joueursModel->updateDexterity($joueur->getIdJoueur(), $newDexterity);
        }

        $newCaps = $joueur->getMontantCaps() - $totalPrice;
        $joueursModel->updateCaps($joueur->getIdJoueur(), $newCaps);

        foreach ($cartItems as $item) {
            $itemId = $item->getIdItem();
            $quantityPurchased = $item->getQuantite();

            $itemsModel->updateItemStock($itemId, $quantityPurchased);

            $backpackModel->addItemToBackpack($joueur->getIdJoueur(), $itemId, $quantityPurchased);
        }

        $_SESSION['cart'] = [];

        $_SESSION['success_message'] = "Achat effectué avec succès !";
        $_SESSION['montantCaps'] = $newCaps;
        $_SESSION['poids'] = $remainingWeight - $totalWeight;
        $_SESSION['dexterite'] = $newDexterity;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    } else {
        $_SESSION['error_message'] = "Vous n'avez pas assez de caps pour effectuer cet achat.";
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}
require 'views/panier.php';