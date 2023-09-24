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
        $list = $userModel->createList($title);
        echo json_encode([
            'message' => 'List added',
            'list' => $list
        ]);
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

    public function addTask(string $title, int $idList) : void {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['message' => 'Not connected']);
            die();
        }
        $user = unserialize($_SESSION['user']);
        $userModel = new UserModel($user);
        if (!$userModel->isListOwner($idList)) {
            echo json_encode(['message' => 'Not authorized']);
            die();
        }
        $task = $userModel->createTask($title, $idList);
        echo json_encode([
            'message' => 'Task added',
            'task' => $task
        ]);
    }

    public function changeTaskState(array $task) : void {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['message' => 'Not connected']);
            die();
        }
        $user = unserialize($_SESSION['user']);
        $userModel = new UserModel($user);
        if (!$userModel->isTaskOwner($task['id'])) {
            echo json_encode(['message' => 'Not authorized']);
            die();
        }
        $state = $task['state'] === 'pending' ? 'completed' : 'pending';
        $userModel->updateTaskState($task['id'], $state);
        echo json_encode([
            'message' => 'State changed',
            'state' => $state
        ]);
    }

    public function deleteTask(int $idTask) : void {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['message' => 'Not connected']);
            die();
        }
        $user = unserialize($_SESSION['user']);
        $userModel = new UserModel($user);
        if (!$userModel->isTaskOwner($idTask)) {
            echo json_encode(['message' => 'Not authorized']);
            die();
        }
        $userModel->deleteTask($idTask);
        echo json_encode(['message' => 'Task deleted']);
    }
}