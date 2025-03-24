<?php
require 'models/JoueursModel.php';
require 'src/class/Database.php';

$errorMotDePasse = false;
$errorUsernameExists = false;

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

    if ($joueursModel->getJoueurByAlias($username)) {
        $errorUsernameExists = true;
    } else {
        if($_POST['password'] === $_POST['passwordConfirm'] ) {
            $joueursModel->addNewJoueur($firstName, $lastName,
            $username, password_hash($_POST['password'], PASSWORD_DEFAULT));
            header('Location: connexion?success=1');
            exit();
        } else {
            $errorMotDePasse = true;
        }
    }
}

require 'views/createAccount.php';