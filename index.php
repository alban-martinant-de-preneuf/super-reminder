<?php

session_start();

require_once 'vendor/autoload.php';

use App\Controller\ViewController;

$router = new AltoRouter();

$router->setBasePath('/super-reminder');

$router->map('GET', '/', function () {
    $viewController = new ViewController();
}, 'home');

$router->map('GET', '/login', function () {
    $viewController = new ViewController();
    $viewController->getLoginForm();
}, 'login');

$router->map('GET', '/register', function () {
    $viewController = new ViewController();
    $viewController->getRegisterForm();
}, 'register');

// match current request url
$match = $router->match();
// call closure or throw 404 status`
if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}