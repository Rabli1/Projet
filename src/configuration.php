<?php

const ROUTES = [

    '/' => 'index.php',
    '/index.php' => 'index.php', //deux index pour le moment

];

const DB_PARAMS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION        
];