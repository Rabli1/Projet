<?php 
require_once 'src/class/Database.php';
require_once 'src/functions.php';

$db = Database::getInstance($dbConfig, $dbParams);
$pdo = $db -> getPDO();

sessionStart();

if (!isAuthenticated()) {
    $_SESSION['alert'] = [
        'message' => 'Vous devez être connecté pour accéder à cette page.',
        'type' => 'danger'
    ];
    header('Location: /login.php');
    exit();
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
require 'views/panier.php';