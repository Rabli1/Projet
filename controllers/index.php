<?php
require 'src/class/Database.php';
require 'models/ItemsModel.php';
require 'models/ArmesModel.php';
require 'models/MunitionsModel.php';
require 'models/ArmuresModel.php';
require 'models/MédicamentModel.php';
require 'models/NourrituresModel.php';


sessionStart();

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $itemsModel = new ItemsModel($pdo);
    $armesModel = new ArmesModel($pdo);
    $munitionsModel = new MunitionsModel($pdo);
    $armuresModel = new ArmuresModel($pdo);
    $medicamentsModel = new MédicamentsModel($pdo);
    $nourrituresModel = new NourrituresModel($pdo);
    $items = $itemsModel->selectAllItems();
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedTypes = [];
    if (isset($_POST['arme'])) {
        $selectedTypes[] = 'a';
    }
    if (isset($_POST['munition'])) {
        $selectedTypes[] = 'u';
    }
    if (isset($_POST['armure'])) {
        $selectedTypes[] = 'r';
    }
    if (isset($_POST['medicament'])) {
        $selectedTypes[] = 'm';
    }
    if (isset($_POST['nourriture'])) {
        $selectedTypes[] = 'n';
    }
    if (isset($_POST['ressource'])) {
        $selectedTypes[] = ' ';
    }

    if (!empty($_POST['search']) && empty($selectedTypes)) {
        $items = $itemsModel->selectItemsByName($_POST['search']);
    } elseif (!empty($_POST['search']) && !empty($selectedTypes)) {
        $items = $itemsModel->selectByNameAndTypes($selectedTypes, $_POST['search']);
    } elseif (empty($_POST['search']) && !empty($selectedTypes)) {
        $items = $itemsModel->selectItemsByTypes($selectedTypes);
    } else {
        $items = $itemsModel->selectAllItems();
    }
} else {
    $items = $itemsModel->selectAllItems();
}

if (isset($_POST['add_to_cart']) && !empty($_POST['idItem'])) {
    $idItem = intval($_POST['idItem']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $idItem;

    $item = $itemsModel->selectById($idItem);
    if ($item) {
        $_SESSION['success_message'] = $item->getNomItem() . " a été ajouté au panier !";
    } else {
        $_SESSION['success_message'] = "L'objet a été ajouté au panier !";
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

require 'views/index.php';