<?php

require 'src/class/Database.php';
require 'models/ItemsModel.php';
require 'models/ArmesModel.php';
require 'models/MunitionsModel.php';
require 'models/ArmuresModel.php';
require 'models/MédicamentModel.php';
require 'models/NourrituresModel.php';

sessionStart();
$idItem = intval($_GET['id']);
try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $itemsModel = new ItemsModel($pdo);
    $armesModel = new ArmesModel($pdo);
    $munitionsModel = new MunitionsModel($pdo);
    $armuresModel = new ArmuresModel($pdo);
    $medicamentsModel = new MédicamentsModel($pdo);
    $nourrituresModel = new NourrituresModel($pdo);
    $joueursModel = new JoueursModel($pdo);
    $joueur = $joueursModel->getJoueurById($_SESSION['idJoueur']);
    $items = $itemsModel->selectAllItems();
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}
$item = $itemsModel->selectById($idItem);

if (!$item) {
    echo "<p>Item introuvable.</p>";
    exit;
}


require 'views/detailItem.php';
