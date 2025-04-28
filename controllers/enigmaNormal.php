<?php
require 'src/class/Database.php';
require 'models/EnigmesModel.php';
require 'models/JoueursModel.php';



$activateGetQuestion = true;
$activateSelect = true;
$activateValidate = false;
$question = "";
$difficulty = "";
$wrongAnswer = false;
$rightAnswer = false;


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


if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['getQuestion'])){

        $enigme = $enigmesModel->getRandomEnigme();

        $question = $enigme->getDescription();
        $_SESSION['answer'] = $enigme->getReponse();
        
        $difficulty = $enigme->getDifficulté();
        
        switch ($difficulty) {
            case 'f':
                $_SESSION['recompense'] = 50;
                $_SESSION['hpLoss'] = 3;
                break;
            case 'm':
                $_SESSION['recompense'] = 100;
                $_SESSION['hpLoss'] = 6;
                break;
            case 'd':
                $_SESSION['recompense'] = 200;
                $_SESSION['hpLoss'] = 10;
                break;
        }

        $activateGetQuestion = false;
        $activateSelect = false;
        $activateValidate = true;

        $rightAnswer = false;
        $wrongAnswer = false;
    }

    if(isset($_POST['validate'])){
        if(strtoupper($_POST['answer']) == strtoupper($_SESSION['answer'])){

            $newCaps = $joueur->getMontantCaps() + $_SESSION['recompense'];
            $joueursModel->updateCaps($joueur->getIdJoueur(), $newCaps);

            $_SESSION['montantCaps'] = $newCaps;

            unset($_POST['answer']);
            unset($_SESSION['answer']);
            $rightAnswer = true;
        }else{
            $wrongAnswer = true;
            $joueursModel->updatePdv($joueur->getIdJoueur(), $joueur->getPointDeVie() - $_SESSION['hpLoss']);
            $_SESSION['pv'] = $joueur->getPointDeVie();
        }

        $activateGetQuestion = true;
        $activateSelect = true;
        $activateValidate = false;
    }
}





require 'views/enigmaNormal.php';