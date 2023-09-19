<?php

session_start();



require_once 'vendor/autoload.php';

use App\Controller\ViewController;
use App\Controller\AuthController;

$router = new AltoRouter();

$router->setBasePath('/super-reminder');

$router->map('GET', '/', function () {
    $viewController = new ViewController();
    $viewController->getHome();
}, 'home');

$router->map('GET', '/login', function () {
    $viewController = new ViewController();
    $viewController->getLoginForm();
}, 'login');

$router->map('GET', '/registerForm', function () {
    $viewController = new ViewController();
    $viewController->getRegisterForm();
}, 'registerForm');

$router->map('GET', '/loginForm', function () {
    $viewController = new ViewController();
    $viewController->getLoginForm();
}, 'loginForm');

$router->map('GET', '/register', function () {
    $viewController = new ViewController();
    $viewController->getRegisterForm();
}, 'register');

$router->map('POST', '/login', function () {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $authController = new AuthController();
    $authController->login($email, $password);
}, 'loginPost');

$router->map('POST', '/register', function () {
    $authController = new AuthController();
    $authController->register($_POST);
}, 'registerPost');

$router->map('GET', '/logout', function () {
    session_destroy();
    header('Location: /super-reminder');
}, 'logout');

// for testing 

$router->map('GET', '/test', function () {
    if (isset($_SESSION['user'])) {
        var_dump($_SESSION['user']);
    } else {
        echo 'no user connected';
    }
}, 'test');

// match current request url
$match = $router->match();
// call closure or throw 404 status`
if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}