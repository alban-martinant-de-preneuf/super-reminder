<?php

namespace App\Controller;

use App\Model\UserModel;

class DataController {

    public function getUserTaskLists() {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['message' => 'Not connected']);
            die();
        }
        $user = unserialize($_SESSION['user']);
        $userModel = new UserModel($user);
        $userTaskLists = $userModel->getLists();

        // var_dump($userTaskLists);

        echo json_encode($userTaskLists);
    }

    public function addList(string $title) : void {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['message' => 'Not connected']);
            die();
        }
        $user = unserialize($_SESSION['user']);
        $userModel = new UserModel($user);
        $userModel->createList($title);
        echo json_encode(['message' => 'List added']);
    }
}