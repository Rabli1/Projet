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

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['motDePasse'] === $_POST['motDePasseConfirmation']) {
        $joueursModel->addNewJoueur($_POST['firstName'], $_POST['lastName'],
         $_POST['username'], $_POST['motDePasse']);
    }
}

require 'views/createAccount.php';