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

require 'views/index.php';