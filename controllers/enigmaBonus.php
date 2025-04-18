<?php


sessionStart();

if(!isAuthenticated()) {
    redirect('/');
}


if($_SERVER["METHOD"] == "POST") {

    if(isset($_POST['getQuestion'])){

    }

    if(isset($_POST['validate'])){
        
    }
}





require 'views/enigmaBonus.php';