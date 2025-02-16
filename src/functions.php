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