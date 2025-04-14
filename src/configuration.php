<?php

const ROUTES = [

    '/' => 'index.php',
    '/index' => 'index.php', //deux index pour le moment
    '/panier' => 'panier.php',
    '/connexion' => 'login.php',
    '/register' => 'register.php',
    '/createAccount' => 'createAccount.php',
    '/deconnexion' => 'deconnexion.php',
    '/inventaire' => 'inventaire.php',
    '/detailItem' => 'detailItem.php',
];

const DB_PARAMS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION        
];