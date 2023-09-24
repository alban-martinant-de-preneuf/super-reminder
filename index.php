<?php

session_start();



require_once 'vendor/autoload.php';

use App\Controller\ViewController;
use App\Controller\AuthController;
use App\Controller\DataController;

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

$router->map('GET', '/list_page', function () {
    $viewController = new ViewController();
    $viewController->getListPage();
}, 'list_page');

$router->map('GET', '/lists', function () {
    $dataController = new DataController();
    $dataController->getUserLists();
}, 'lists');

$router->map('GET', '/tasks/[i:idList]', function ($idList) {
    $dataController = new DataController();
    $dataController->getTasks($idList);
}, 'tasks');

$router->map('POST', '/lists/add', function () {
    $dataController = new DataController();
    $dataController->addList($_POST['title']);
}, 'addList');

$router->map('POST', '/tasks/add', function () {
    $dataController = new DataController();
    $dataController->addTask($_POST['title'], $_POST['list_id']);
}, 'addTask');

$router->map('POST', '/tasks/changestate', function () {
    $task = json_decode(file_get_contents('php://input'), true);
    $dataController = new DataController();
    $dataController->changeTaskState($task);
}, 'changeTaskState');

$router->map('DELETE', '/tasks/delete/[i:id]', function ($id) {
    $dataController = new DataController();
    $dataController->deleteTask($id);
}, 'deleteTask');

$router->map('DELETE', '/lists/delete/[i:id]', function ($id) {
    $dataController = new DataController();
    $dataController->deleteList($id);
}, 'deleteList');

// for testing 

$router->map('GET', '/test', function () {
    // $dataController = new DataController();
    // $dataController->getUserTaskLists();
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
