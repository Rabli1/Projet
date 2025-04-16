<?php




sessionStart();

if(!isAuthenticated()) {
    redirect('/');
}





require 'views/enigma.php';