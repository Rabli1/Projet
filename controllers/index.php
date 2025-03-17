<?php
require 'src/class/Database.php';
require 'models/ItemsModel.php';

sessionStart();

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $itemsModel = new ItemsModel($pdo);
    $items = $itemsModel->selectAll();
    echo "Connected to MySQL successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $itemId = (int)$_POST['idItem'];
    addToCart($itemId, $itemsModel);

    header('Location: /panier');
    exit();
}

require 'views/index.php';