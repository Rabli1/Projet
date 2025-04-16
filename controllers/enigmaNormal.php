<?php




sessionStart();
if(!isAuthenticated()) {
    redirect('/');
}






require 'views/enigmaNormal.php';