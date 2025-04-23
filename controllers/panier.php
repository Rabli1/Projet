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

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
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
$totalWeightPanier = 0;
$totalPrice = 0;

if (!empty($_SESSION['cart'])) {
    $quantities = array_count_values($_SESSION['cart']);
    foreach ($quantities as $id => $quantite) {
        $item = $itemsModel->selectById($id);
        if ($item) {
            $item->setQuantite($quantite);
            $cartItems[] = $item;
            $totalWeightPanier += $item->getPoidsItem() * $quantite;
            $totalPrice += $item->getPrixItem() * $quantite;
        }
    }
}


$backpack = $backpackModel->getItemsInBackpack($joueur->getIdJoueur());

if (!empty($backpack) && is_array($backpack)) {
    foreach ($backpack as $item) {
        $totalWeight += $item['poidsItem'] * $item['qteItems'];
    }
}

$poidsMaxTransport = $joueur->getPoidsMaxTransport();
if($totalWeight < $poidsMaxTransport) {
    $remainingWeight = $poidsMaxTransport - $totalWeight;
} else {
    $remainingWeight = 0;
}

$dexterityPenalty = 0;
if ($totalWeightPanier > $remainingWeight) {
    $excessWeight = $totalWeightPanier - $remainingWeight;
    $dexterityPenalty = $excessWeight * 3;
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if (isset($_POST['buy_items'])) {
    if ($joueur->getMontantCaps() >= $totalPrice) {
        $dexterityPenalty = 0;
        if ($totalWeightPanier > $remainingWeight) {
            $excessWeight = $totalWeightPanier - $remainingWeight;
            $dexterityPenalty = $excessWeight * 3;
            
            if($joueur->getDexterite() - $dexterityPenalty <= 0) {
                $newDexterity = 0;
                $_SESSION['dexterite'] = $newDexterity;
            } 
            else if($dexterityPenalty == 0 || $dexterityPenalty == null){
                $_SESSION['dexterite'] = 100;
            } 
            else {
                $newDexterity = $joueur->getDexterite() - $dexterityPenalty;
                $_SESSION['dexterite'] = $newDexterity;
            }
            
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
        if($poidsMaxTransport - $totalWeight - $totalWeightPanier <= 0){
            $_SESSION['poids'] = 0;
        } else {
            $_SESSION['poids'] = $poidsMaxTransport - $totalWeight - $totalWeightPanier;
        }
        
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    } else {
        $_SESSION['error_message'] = "Vous n'avez pas assez de caps pour effectuer cet achat.";
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}
require 'views/panier.php';