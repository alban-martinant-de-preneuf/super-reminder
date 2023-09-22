<?php

namespace App\Controller;

use App\Model\UserModel;

class DataController {

    public function getUserLists() {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['message' => 'Not connected']);
            die();
        }
        $user = unserialize($_SESSION['user']);
        $userModel = new UserModel($user);
        $userLists = $userModel->getLists();

        echo json_encode($userLists);
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

    public function getTasks(int $idList) {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['message' => 'Not connected']);
            die();
        }
        $user = unserialize($_SESSION['user']);
        $userModel = new UserModel($user);
        $tasks = $userModel->getTasks($idList);
        echo json_encode($tasks);
    }
}