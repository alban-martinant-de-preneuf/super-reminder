<?php

namespace App\Controller;

use App\Model\User;
use App\Model\AuthModel;

class AuthController
{

    public function register(array $args): void
    {
        var_dump($args);
        foreach ($args as &$arg) {
            var_dump($arg);
            $arg = htmlspecialchars($arg);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : null;
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
        $role = isset($_POST['role']) ? $_POST['role'] : 'USER';

        if ($password !== $password2) {
            echo 'Passwords don\'t match';
            die();
        }
        // if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$/', $password)) {
        //     echo 'Invalid password';
        //     die();
        // }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email';
            die();
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User($email, $hashedPassword, $firstname, $lastname, $role);
        $authModel = new AuthModel($user);
        if ($authModel->isRegisted()) {
            echo 'Email already exists';
            die();
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $authModel->register();
    }

    public function login(string $email, string $password): void
    {
        $args = func_get_args();
        foreach ($args as &$arg) {
            echo $arg;
            $arg = htmlspecialchars($arg);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email';
            die();
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User($email, $hashedPassword);
        $authModel = new AuthModel($user);
        if (!$authModel->isRegisted()) {
            echo 'Email not found';
            die();
        }
        if (!password_verify($password, $user->getPassword())) {
            echo 'Invalid password';
            die();
        }
        $_SESSION['user'] = $user;
    }
}
