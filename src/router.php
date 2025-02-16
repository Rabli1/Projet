<?php

function urlPath() : string {

    $uri = $_SERVER['REQUEST_URI'];

    $parts = parse_url($uri);

    $path = $parts['path'];

    return $path;

}
function route(string $route, ?array $params = null) : void 
{
    $routeValid = false;

    if (array_key_exists($route, ROUTES)) {

        $controllerFile = 'controllers/' . ROUTES[$route];

        if (file_exists($controllerFile)) {

            $routeValid = true;
            require $controllerFile;

        }

    }

    if (!$routeValid) {
        require 'views/page-not-found.php';
    }

}

function redirect(string $url) : void 
{
    header('location: '. $url);
    exit;
}

