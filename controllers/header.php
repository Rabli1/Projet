<?php
require_once 'src/class/Database.php';
require_once 'src/functions.php';
require_once 'models/ItemsModel.php';
require_once 'models/BackpackModel.php';
require_once 'models/JoueursModel.php';
require_once 'models/NourrituresModel.php';
require_once 'models/MédicamentModel.php';
sessionStart();

$backpackModel = new BackpackModel($pdo);
$joueursModel = new JoueursModel($pdo);

$joueur = $joueursModel->getJoueurByAlias($_SESSION['username']);
require 'views/partials/header.php';