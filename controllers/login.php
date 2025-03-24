<?php
require 'models/JoueursModel.php';
require 'src/class/Database.php';

$errorLogin = false;
$successMsg = '';

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $joueursModel = new JoueursModel($pdo);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = 'Votre compte a été créé';
}

//var_dump($joueursModel->getAllJoueurs());

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $joueur = $joueursModel->getJoueurByAlias($username);

    if ($joueur && password_verify($password, $joueur['motDePasse'])) {
        sessionStart();
        $_SESSION['username'] = $username;
        redirect('index');
    } else {
        $errorLogin = true;
    }
}

require 'views/login.php';