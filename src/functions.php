<?php
function dd(mixed $data, bool $die = true): void { #Die and Dump
    echo "<pre>";
    var_dump($data);
    echo "</pre>";

    if ($die) die();
}

function pre(mixed $data, bool $die = true): void {
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    if ($die) die();
}

function urlIs(string $url): bool {
    return $_SERVER['REQUEST_URI'] === $url;
}

function view($path, $attributes = []) : void
{
    extract($attributes);

    require "views/{$path}";
}

function sessionStart() : void
{

    if (session_status() === PHP_SESSION_NONE) { 
        session_start();
    }

}

function isAuthenticated() : bool
{
    sessionStart();
    return !empty($_SESSION['username']);

}

function isAdministrator() : bool 
{
    sessionStart();
    return !empty($_SESSION['estAdmin']) && $_SESSION['estAdmin']== '1';
}

function addToCart($itemId, $itemsModel) {
    sessionStart();

    if (!isAuthenticated()) {
        $_SESSION['error_message'] = "Vous devez être connecté pour ajouter des items au panier.";
        return;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $item = $itemsModel->selectById($itemId);
    if ($item) {
        $_SESSION['cart'][] = $itemId;

        $_SESSION['success_message'] = "L'objet '{$item->getNomItem()}' a été ajouté au panier.";
    } else {
        error_log("Invalid item ID: $itemId");
    }
}

function getTypeItemName($typeItem) {
    switch ($typeItem) {
        case 'r':
            return 'Armure';
        case 'a':
            return 'Arme';
        case 'm':
            return 'Médicament';
        case 'n':
            return 'Nourriture';
        case 'u':
            return 'Munition';
        default:
            return 'Ressource';
    }
}