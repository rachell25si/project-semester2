<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/routes.php';

$page = $_GET['page'] ?? '';

if (isset($routes[$page])) {
    $controllerName = $routes[$page]['controller'];
    $action = $routes[$page]['action'];
    require_once __DIR__ . "/controllers/$controllerName.php";
    $controller = new $controllerName();
    $controller->$action();
} else {
    require_once __DIR__ . '/controllers/LandingController.php';
    $landing = new LandingController();
    $landing->index();
}
?>