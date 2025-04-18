<?php
require 'src/class/Database.php';
require 'models/EnigmesModel.php';
require 'models/JoueursModel.php';



$activateGetQuestion = true;
$activateValidate = false;
$question = "";
$difficulty = "";
$recompense = 0;
$wrongAnswer = false;
$rightAnswer = false;
$recompense = 0;

sessionStart();

if(!isAuthenticated()) {
    redirect('/');
}

try {
    $db = Database::getInstance($dbConfig, $dbParams);
    $pdo = $db->getPDO();
    $enigmesModel = new EnigmesModel($pdo);
    $joueursModel = new JoueursModel($pdo);
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

$joueur = $joueursModel->getJoueurByAlias($_SESSION['username']);
$enigme=null;

if($_SERVER["REQUEST_METHOD"] == "POST") {

    switch ($_POST['difficulty']) {
        case 'facile':
            $difficulty = "f";
            $recompense = 50;
            break;
        case 'moyen':
            $difficulty = "m";
            $recompense = 100;
            break;
        case 'difficile':
            $difficulty = "d";
            $recompense = 200;
            break;
    }


    if(isset($_POST['getQuestion'])){

        //$enigme = $enigmesModel->getRandomEnigmeByDifficulty($difficulty);
        $enigme = $enigmesModel->getRandomEnigme();

        $question = $enigme->getDescription();
        $_SESSION['answer'] = $enigme->getReponse();

        $activateGetQuestion = false;
        $activateValidate = true;
        $rightAnswer = false;
        $wrongAnswer = false;

        
    }

    if(isset($_POST['validate'])){
        if(strtoupper($_POST['answer']) == strtoupper($_SESSION['answer'])){

            $joueursModel->updateCaps($joueur->getIdJoueur(), $joueur->getMontantCaps() + $recompense);
            $_SESSION['montantCaps'] = $joueur->getMontantCaps();
            unset($_POST['answer']);
            unset($_SESSION['answer']);
            $rightAnswer = true;
        }else{
            $wrongAnswer = true;
        }

        $activateGetQuestion = true;
        $activateValidate = false;
    }
}





require 'views/enigmaBonus.php';