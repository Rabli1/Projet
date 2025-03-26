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

//var_dump($_SESSION);

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
    if(isset($_POST['ressource'])) {
        $selectedTypes[] = ' ';
    }

    if (!empty($_POST['search']) && empty($selectedTypes)) {
        $items = $itemsModel->selectItemsByName($_POST['search']);
    } elseif(!empty($_POST['search']) && !empty($selectedTypes)) {
        $items = $itemsModel->selectByNameAndTypes($selectedTypes, $_POST['search']);
    } elseif(empty($_POST['search']) && !empty($selectedTypes)) {
        $items = $itemsModel->selectItemsByTypes($selectedTypes);
    } else {
        $items = $itemsModel->selectAllItems();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $itemId = (int)$_POST['idItem'];
    addToCart($itemId, $itemsModel);

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_SESSION['error_message'])) {
    echo "<script>alert('{$_SESSION['error_message']}');</script>";
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('{$_SESSION['success_message']}');</script>";
    unset($_SESSION['success_message']);
}

require 'views/index.php';