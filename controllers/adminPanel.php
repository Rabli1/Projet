<?php
require_once 'models/JoueursModel.php';
require_once 'src/class/Database.php';
require_once 'src/functions.php';

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $joueursModel = new JoueursModel($pdo);
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

$joueurs = $joueursModel->getAllJoueurs();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['capsAjout'])) {
    $joueurId = intval($_POST['joueur_id']);
    $capsAdded = $joueursModel->increaseCaps($joueurId);

    if ($capsAdded > 0) {
        $_SESSION['success_message'] = "Le capital du joueur a été augmenté de $capsAdded caps.";
    } else {
        $_SESSION['error_message'] = "Le capital du joueur ne peut plus être augmenté.";
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

require "views/adminPanel.php";