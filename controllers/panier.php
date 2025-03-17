<?php 
require_once 'src/class/Database.php';
require_once 'src/functions.php';
require_once 'models/ItemsModel.php';

$db = Database::getInstance($dbConfig, $dbParams);
$pdo = $db->getPDO();
$itemsModel = new ItemsModel($pdo);

sessionStart();

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
    if (!empty($_POST['id']) && !empty($_POST['quantity'])) {
        $id = intval($_POST['id']);
        $quantity = intval($_POST['quantity']);

        $item = $itemsModel->selectById($id);
        if ($item && $quantity <= $item->getQteStock()) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($cartId) use ($id) {
                return $cartId !== $id; 
            });

            for ($i = 0; $i < $quantity; $i++) {
                $_SESSION['cart'][] = $id;
            }
        }

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $quantities = array_count_values($_SESSION['cart']);

    foreach ($quantities as $id => $quantity) {
        $item = $itemsModel->selectById($id);
        if ($item) {
            $item->setQuantity($quantity); // Use the setter method
            $cartItems[] = $item;
        }
    }
}

$subTotal = array_reduce($cartItems, function ($total, $item) {
    return $total + $item->getPrixItem() * $item->getQuantity(); // Use the getter method
}, 0);

require 'views/panier.php';