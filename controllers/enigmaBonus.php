<?php
require 'src/class/Database.php';
require 'models/EnigmesModel.php';
require 'models/JoueursModel.php';



$activateGetQuestion = true;
$activateSelect = true;
$activateValidate = false;
$question = "";
$bonusCaps = 0;
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
        switch ($_POST['difficulty']) {
            case 'facile':
                $_SESSION['difficulty'] = "f";
                $_SESSION['recompense'] = 50;
                break;
            case 'moyen':
                $_SESSION['difficulty'] = "m";
                $_SESSION['recompense'] = 100;
                break;
            case 'difficile':
                $_SESSION['difficulty'] = "d";
                $_SESSION['recompense'] = 200;
                break;
        }


        $enigme = $enigmesModel->getRandomEnigmeByDifficulty($_SESSION['difficulty']);

        $question = $enigme->getDescription();
        $_SESSION['answer'] = $enigme->getReponse();

        $activateGetQuestion = false;
        $activateSelect = false;
        $activateValidate = true;

        $rightAnswer = false;
        $wrongAnswer = false;
    }

    if(isset($_POST['validate'])){
        if(strtoupper($_POST['answer']) == strtoupper($_SESSION['answer'])){

            if($_SESSION['difficulty'] == "d"){
                if (!isset($_SESSION['goodAnswers'])) {
                    $_SESSION['goodAnswers'] = 0;
                }
                $_SESSION['goodAnswers']++;
            }

            if(isset($_SESSION['goodAnswers']) && $_SESSION['goodAnswers'] >= 3){
                $_SESSION['goodAnswers'] = 0;
                $bonusCaps = 1000;
            } else {
                $bonusCaps = 0;
            }

            $newCaps = $joueur->getMontantCaps() + $_SESSION['recompense'] + $bonusCaps;
            $joueursModel->updateCaps($joueur->getIdJoueur(), $newCaps);

            $_SESSION['montantCaps'] = $newCaps;

            unset($_POST['answer']);
            unset($_SESSION['answer']);
            $rightAnswer = true;
        }else{
            $wrongAnswer = true;
            $_SESSION['goodAnswers'] = 0;
        }

        $activateGetQuestion = true;
        $activateSelect = true;
        $activateValidate = false;
    }
}





require 'views/enigmaBonus.php';