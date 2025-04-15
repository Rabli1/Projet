<?php


sessionStart();
if(!isAuthenticated()) {
    redirect('/');
}







require 'views/enigmaBonus.php';