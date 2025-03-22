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

    $poidsTotalBackpack = $backpackModel->selectBackpackById($joueur['idJoueurs']);

    $poidsRestant = $joueur['poidsMaxTransport'] - $poidsTotalBackpack;

    $dexterityPenalty = 0;
    if ($poidsRestant < 0) {
        $excessWeight = abs($poidsRestant); // Poids excédentaire
        $dexterityPenalty = ceil($excessWeight / 3); // Réduction de la dextérité (1 lb pour 3 points)
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

if (isset($_POST['remove_item']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']); 

    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($cartId) use ($id) {
        return $cartId !== $id;
    });

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id']) && !empty($_POST['quantite'])) {
        $id = intval($_POST['id']);
        $quantite = intval($_POST['quantite']);

        $item = $itemsModel->selectById($id);
        if ($item && $quantite <= $item->getQteStock()) {
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
}

if (isset($_POST['buy_items'])) {
    $cartItems = [];
    $totalPrice = 0;
    $totalWeight = 0;

    if (!empty($_SESSION['cart'])) {
        $quantities = array_count_values($_SESSION['cart']);
        foreach ($quantities as $id => $quantite) {
            $item = $itemsModel->selectById($id);
            if ($item) {
                $item->setQuantite($quantite);
                $cartItems[] = $item;
                $totalPrice += $item->getPrixItem() * $quantite;
                $totalWeight += $item->getPoidsItem() * $quantite;
            }
        }
    }

    if ($joueur['montantCaps'] < $totalPrice) {
        $_SESSION['error_message'] = "Vous n'avez pas assez de caps pour acheter ces items.";
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    foreach ($cartItems as $item) {
        $backpackModel->addItemToBackpack($joueur['idJoueurs'], $item->getIdItem(), $item->getQuantite());

        $itemsModel->updateItemStock($item->getIdItem(), $item->getQuantite());
    }

    $joueursModel->updateCaps($joueur['idJoueurs'], $joueur['montantCaps'] - $totalPrice);

    if ($poidsRestant < 0) {
        $newDexterity = max(0, $joueur['dextérité'] - $dexterityPenalty);
        $joueursModel->updateDexterity($joueur['idJoueurs'], $newDexterity);
    }

    $_SESSION['cart'] = [];
    $_SESSION['success_message'] = "Achat réussi ! Les items ont été ajoutés à votre sac à dos.";
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $quantities = array_count_values($_SESSION['cart']);
    foreach ($quantities as $id => $quantite) {
        $item = $itemsModel->selectById($id);
        if ($item) {
            $item->setQuantite($quantite);
            $cartItems[] = $item;
        }
    }
}

require 'views/panier.php';