<?php
require 'models/JoueursModel.php';
require 'src/class/Database.php';

$errorMotDePasse = false;

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $joueursModel = new JoueursModel($pdo);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    if($_POST['password'] === $_POST['passwordConfirm']) {
        $joueursModel->addNewJoueur($firstName, $lastName,
         $username, $_POST['password']);
    } else {
        $errorMotDePasse = true;
    }
}

require 'views/createAccount.php';