<?php

require_once 'src/class/Database.php';
require 'models/JoueursModel.php';

sessionStart();

if (!isset($_SESSION['joueurs_id'])) {
    header('Location: /connexion');
    exit;
}
try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $joueursModel = new JoueursModel($pdo);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $idJoueur = $_SESSION['joueurs_id'];

    try {
        // Validation du nom
        if (empty($nom)) {
            throw new Exception("Le nom ne peut pas être vide.");
        }

        // Mise à jour du nom
        $joueursModel->updateNom($idJoueur, $nom);
        $_SESSION['username'] = $nom;

        // Mise à jour du mot de passe (si fourni)
        if (!empty($password)) {
            if ($password !== $confirmPassword) {
                throw new Exception("Les mots de passe ne correspondent pas.");
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $joueursModel->updatePassword($idJoueur, $hashedPassword);
        }

        $_SESSION['success_message'] = "Votre profil a été mis à jour avec succès.";
        header('Location: /modifProfil');
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: /modifProfil');
        exit;
    }
}
require 'views/modifProfil.php';