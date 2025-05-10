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
                $_SESSION['hpLoss'] = 3;
                break;
            case 'moyen':
                $_SESSION['difficulty'] = "m";
                $_SESSION['recompense'] = 100;
                $_SESSION['hpLoss'] = 6;
                break;
            case 'difficile':
                $_SESSION['difficulty'] = "d";
                $_SESSION['recompense'] = 200;
                $_SESSION['hpLoss'] = 10;
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
                    $_SESSION['goodAnswers'] = 0;//initialise la variable de session si elle n'existe pas
                }
                $_SESSION['goodAnswers']++;
            }

            if(isset($_SESSION['goodAnswers']) && $_SESSION['goodAnswers'] >= 3){
                $_SESSION['goodAnswers'] = 0;
                $_SESSION['recompense'] += 1000;//donne le bonus de 1000 caps quand le joueur a reussi 3 enigmes difficiles
            } 

            $newCaps = $joueur->getMontantCaps() + $_SESSION['recompense'];
            $joueursModel->updateCaps($joueur->getIdJoueur(), $newCaps);

            $_SESSION['montantCaps'] = $newCaps;

            unset($_POST['answer']);
            unset($_SESSION['answer']);
            $rightAnswer = true;
        }else{
            $wrongAnswer = true;
            $_SESSION['goodAnswers'] = 0;
            
            $newPdv = $joueur->getPointDeVie() - $_SESSION['hpLoss'];
            $joueursModel->updatePdv($joueur->getIdJoueur(), $newPdv);
            
            $_SESSION['pv'] = $joueur->getPointDeVie();
        }

        $activateGetQuestion = true;
        $activateSelect = true;
        $activateValidate = false;
    }
}





require 'views/enigmaBonus.php';