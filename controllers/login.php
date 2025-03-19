<?php
require 'models/JoueursModel.php';
require 'src/class/Database.php';

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $joueursModel = new JoueursModel($pdo);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

var_dump($joueursModel->getAllJoueurs());

require 'views/login.php';