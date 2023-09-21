<?php

namespace App\Controller;

use App\Model\User;
use App\Model\UserModel;

class AuthController
{

    public function register(array $args): void
    {
        foreach ($args as &$arg) {
            $arg = htmlspecialchars($arg);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : null;
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
        $role = isset($_POST['role']) ? $_POST['role'] : 'USER';

        if ($password !== $password2) {
            echo json_encode(['message' => 'Passwords don\'t match']);
            die();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['message' => 'Invalid email']);
            die();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User($email, $hashedPassword, $firstname, $lastname, $role);
        $authModel = new UserModel($user);
        if ($authModel->isRegisted()) {
            echo json_encode(['message' => 'Email already exists']);
            die();
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        $authModel->register();
        echo json_encode(['message' => 'Registered']);
    }

    public function login(string $email, string $password): void
    {
        $args = func_get_args();
        foreach ($args as &$arg) {
            $arg = htmlspecialchars($arg);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['message' => 'Invalid email']);
            die();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $authModel = new UserModel(new User($email, $hashedPassword));
        if ($authModel->isRegisted()) {
            $user = $authModel->updateUser();
        } else {
            echo json_encode(['message' => 'Invalid email or password']);
            die();
        }

        if (!password_verify($password, $user->getPassword())) {
            echo json_encode(['message' => 'Invalid email or password']);
            die();
        }

        $_SESSION['user'] = serialize($user);
        echo json_encode(['message' => 'Connected']);
    }
}

