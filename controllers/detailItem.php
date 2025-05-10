<?php

require 'src/class/Database.php';
require 'models/ItemsModel.php';
require 'models/ArmesModel.php';
require 'models/MunitionsModel.php';
require 'models/ArmuresModel.php';
require 'models/MédicamentModel.php';
require 'models/NourrituresModel.php';
require 'models/EvaluationModel.php';

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
    $evaluationModel = new EvaluationModel($pdo);
    $items = $itemsModel->selectAllItems();
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}
$item = $itemsModel->selectById($idItem);

if (!$item) {
    echo "<p>Item introuvable.</p>";
    exit;
}

$evaluations = $evaluationModel->selectAllEvaluationsByIdItem($idItem);
$avgEval = $evaluationModel->selectAverageEvaluationByIdItem($idItem);
$countEval = $evaluationModel->selectCountEvaluationByIdItem($idItem);
$eval1 = $evaluationModel->selectCountEvaluationByEvaluation($idItem, 1);
$pourcentEval1 = round($eval1/$countEval,2) * 100;
$eval2 = $evaluationModel->selectCountEvaluationByEvaluation($idItem, 2);
$pourcentEval2 = round($eval2/$countEval,2) * 100;
$eval3 = $evaluationModel->selectCountEvaluationByEvaluation($idItem, 3);
$pourcentEval3 = round($eval3/$countEval,2) * 100;
$eval4 = $evaluationModel->selectCountEvaluationByEvaluation($idItem, 4);
$pourcentEval4 = round($eval4/$countEval,2) * 100;
$eval5 = $evaluationModel->selectCountEvaluationByEvaluation($idItem, 5);
$pourcentEval5 = round($eval5/$countEval,2) * 100;

$evaluationExist = false;
if (isset($_SESSION['joueurs_id'])) {
    $idJoueur = $_SESSION['joueurs_id'];
    if (is_array($evaluations)) { // Vérifie si $evaluations est un tableau
        foreach ($evaluations as $evaluation) {
            if ($evaluation['idJoueurs'] == $idJoueur) {
                $evaluationExist = true;
                break;
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evaluation'], $_POST['commentaire'])) {
    $evaluation = intval($_POST['evaluation']);
    $commentaire = $_POST['commentaire'];
    $idJoueur = $_SESSION['joueurs_id']; // Assurez-vous que l'utilisateur est connecté

    try {
        if ($evaluationExist) {
            $evaluationModel->updateEvaluation($idJoueur, $idItem, $evaluation, $commentaire);
        } else {
            $evaluationModel->insertEvaluation($idJoueur, $idItem, $evaluation, $commentaire);
        }
        header("Location: detailItem?id=$idItem");
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout ou de la modification de l'évaluation : " . $e->getMessage());
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {
    $idJoueur = isAdministrator() ? intval($_POST['idJoueur']) : $_SESSION['joueurs_id'];
    $idItem = intval($_POST['idItem']);

    try {
        $evaluationModel->deleteEvaluation($idJoueur, $idItem);
        header("Location: detailItem?id=$idItem");
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de la suppression de l'évaluation : " . $e->getMessage());
    }
}

require 'views/detailItem.php';
