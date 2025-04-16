<?php
require 'models/JoueursModel.php';
require 'models/BackpackModel.php';
require 'src/class/Database.php';

$errorLogin = false;
$successMsg = '';

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $joueursModel = new JoueursModel($pdo);
    $backpackModel = new BackpackModel($pdo);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = 'Votre compte a été créé';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $joueur = $joueursModel->getJoueurByAlias($username);

    if ($joueursModel->userExist($username) && password_verify($password, $joueur->getMotDePasse())) {

        $backpack = $backpackModel->getItemsInBackpack($joueur->getIdJoueur());

        $totalWeight = 0;
        if (!empty($backpack) && is_array($backpack)) {
            foreach ($backpack as $item) {
                $totalWeight += $item['poidsItem'] * $item['qteItems'];
            }
        }

        $poidsMaxTransport = $joueur->getPoidsMaxTransport();

        if($poidsMaxTransport - $totalWeight > 0)
            $remainingWeight = $poidsMaxTransport - $totalWeight;

        else if($poidsMaxTransport - $totalWeight <= 0)
            $remainingWeight = 0;

       sessionStart();
        $_SESSION['username'] = $username;
        $_SESSION['joueurs_id'] = $joueur->getIdJoueur();
        $_SESSION['montantCaps'] = $joueur->getMontantCaps();
        $_SESSION['dexterite'] = $joueur->getDexterite();
        $_SESSION['poids'] = $remainingWeight;
        $_SESSION['poidsMaxTransport'] = $joueur->getPoidsMaxTransport();
        redirect('index');
    } else {
        $errorLogin = true;
    }
}

require 'views/login.php';