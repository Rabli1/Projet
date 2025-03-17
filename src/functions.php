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
    return !empty($_SESSION['user']);

}

function isAdministrator() : bool 
{
    sessionStart();
    return !empty($_SESSION['user']) && $_SESSION['user']['role'] == '1';
}
function addToCart(int $id, ItemsModel $itemsModel) {
    $item = $itemsModel->selectById($id);

    if ($item !== null) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (!array_key_exists($id, $_SESSION['cart'])) {
            $_SESSION['cart'][$id] = 1;
        } else {
            $_SESSION['cart'][$id]++;
        }
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
            return 'Inconnu';
    }
}