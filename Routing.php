<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/UserController.php';

class Routing
{
    public static $routes = [];

    public static function get($url, $view)
    {
        self::$routes['GET'][$url] = $view;
    }

    public static function post($url, $view)
    {
        self::$routes['POST'][$url] = $view;
    }

    public static function run($url)
    {
        $urlParts = explode("/", $url);
        $action = $urlParts[0];

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (!array_key_exists($action, self::$routes[$requestMethod])) {
            die("Wrong url!");
        }

        $controller = self::$routes[$requestMethod][$action];
        $object = new $controller;

        $object->$action();
    }
}
