<?php
require 'src/class/Database.php';
require 'models/ItemsModel.php';


sessionStart();

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $itemsModel = new ItemsModel($pdo);
    $items = $itemsModel->selectAllItems();
    echo "Connected to MySQL successfully!";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if(!empty($selectedTypes)) {
        $items = $itemsModel->selectByTypes($selectedTypes);
    } else {
        $items = $itemsModel->selectAllItems();
    }
}

require 'views/index.php';