<?php
require 'src/class/Database.php';
require 'models/EnigmesModel.php';


$activateGetQuestion = true;
$activateValidate = false;


sessionStart();

if(!isAuthenticated()) {
    redirect('/');
}


if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['getQuestion'])){



        $activateGetQuestion = false;
        $activateValidate = true;
    }

    if(isset($_POST['validate'])){
        


        $activateGetQuestion = true;
        $activateValidate = false;
    }
}





require 'views/enigmaBonus.php';