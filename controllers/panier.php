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

    $poidsTotalBackpack = $backpackModel->selectBackpackById($joueur['idJoueurs']);

    $poidsRestant = $joueur['poidsMaxTransport'] - $poidsTotalBackpack;

    $dexterityPenalty = 0;
    if ($poidsRestant < 0) {
        $excessWeight = abs($poidsRestant);
        $dexterityPenalty = ceil($excessWeight / 3);
    }

    $nomJoueur = $joueur['alias'];
    $montantCaps = $joueur['montantCaps'];
} else {
    header('Location: /connexion');
    exit;
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$playerId = $_SESSION['joueurs_id'];
$joueur = $joueursModel->getJoueurById($playerId);

if (!$joueur) {
    die("Player not found.");
}

if (isset($_POST['remove_item']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']); 

    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($cartId) use ($id) {
        return $cartId !== $id;
    });

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy'])) {
    buy($joueur, $itemsModel, $backpackModel);
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
$backpack = $backpackModel->selectBackpackById($joueur->getIdJoueur());

if (!empty($backpack)) {
    foreach ($backpack as $item) {
        $currentWeight += $item['poidsItem'] * $item['quantite'];
    }
}

$poidsMaxTransport = $joueur->getPoidsMaxTransport();
$remainingWeight = $poidsMaxTransport - $currentWeight;

require 'views/panier.php';

function buy($joueur, $itemsModel, $backpackModel) {
    global $pdo;

    $totalWeight = 0;
    $totalPrice = 0;

    $cartItems = [];
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

    $currentWeight = 0;
    $backpack = $backpackModel->selectBackpackById($joueur->getIdJoueur());
    if (!empty($backpack)) {
        foreach ($backpack as $item) {
            $currentWeight += $item['poidsItem'] * $item['quantite'];
        }
    }

    $poidsMaxTransport = $joueur->getPoidsMaxTransport();

    if ($joueur->getMontantCaps() < $totalPrice) {
        echo "<script>alert('Vous n\'avez pas assez de caps pour acheter ces objets.');</script>";
        return;
    }

    if ($currentWeight + $totalWeight > $poidsMaxTransport) {
        $excessWeight = ($currentWeight + $totalWeight) - $poidsMaxTransport;
        $dexterityPenalty = $excessWeight * 3;
        echo "<script>alert('Vous allez perdre {$dexterityPenalty} dextérité si vous achetez ces objets.');</script>";
    }

    $joueursModel = new JoueursModel($pdo);
    $joueursModel->updateCaps($joueur->getIdJoueur(), $joueur->getMontantCaps() - $totalPrice);

    foreach ($cartItems as $item) {
        $backpackModel->addItemToBackpack($joueur->getIdJoueur(), $item->getIdItem(), $item->getQuantite());
    }

    

    $_SESSION['cart'] = [];
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}