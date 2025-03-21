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
    echo "Connected to MySQL successfully!";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

var_dump($_SESSION);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_button'])) {
    $selectedTypes = [];
    if(isset($_POST['arme'])) {
        $selectedTypes[] = 'a';
    }
    if(isset($_POST['munition'])) {
        $selectedTypes[] = 'u';
    }
    if(isset($_POST['armure'])) {
        $selectedTypes[] = 'r';
    }
    if(isset($_POST['medicament'])) {
        $selectedTypes[] = 'm';
    }
    if(isset($_POST['nourriture'])) {
        $selectedTypes[] = 'n';
    }

    if (!empty($_POST['search'])) {
        $items = $itemsModel->selectItemsByName($_POST['search']);
    } elseif(!empty($selectedTypes)) {
        $items = $itemsModel->selectItemsByTypes($selectedTypes);
    } else {
        $items = $itemsModel->selectAllItems();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $itemId = (int)$_POST['idItem'];
    addToCart($itemId, $itemsModel);

    header('Location: /panier');
    exit();
}
require 'views/index.php';