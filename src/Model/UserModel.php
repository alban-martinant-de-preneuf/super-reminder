<?php

namespace App\Model;

class UserModel extends DbConnection
{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    public function register(): User
    {
        try {
            $sqlQuery = "INSERT INTO user (email, password, firstname, lastname, role) VALUES (:email, :password, :firstname, :lastname, :role)";
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':email', $this->user->getEmail(), \PDO::PARAM_STR);
            $statment->bindValue(':password', $this->user->getPassword(), \PDO::PARAM_STR);
            $statment->bindValue(':firstname', $this->user->getFirstname(), \PDO::PARAM_STR);
            $statment->bindValue(':lastname', $this->user->getLastname(), \PDO::PARAM_STR);
            $statment->bindValue(':role', $this->user->getRole(), \PDO::PARAM_STR);
            $statment->execute();
            $this->user->setId($this->pdo->lastInsertId());
            return $this->user;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in register()' . $e->getMessage()]);
            die();
        }
    }

    public function isRegisted(): bool
    {
        try {

            $sqlQuery = ("SELECT COUNT(*)
            FROM user 
            WHERE email = :email"
            );
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':email', $this->user->getEmail(), \PDO::PARAM_STR);
            $statment->execute();
            $result = $statment->fetch(\PDO::FETCH_COLUMN);
            if ($result) {
                return true;
            }
            return false;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in isRegistered(): ' . $e->getMessage()]);
            die();
        }
    }

    public function isConnect(): bool
    {
        try {
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user']->getEmail() === $this->user->getEmail()) {
                    return true;
                }
            }
            return false;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in isConnect(): ' . $e->getMessage()]);
            die();
        }
    }

    public function updateUser(): User
    {
        try {
            $sqlQuery = ("SELECT * FROM user WHERE email = :email");
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':email', $this->user->getEmail(), \PDO::PARAM_STR);
            $statment->execute();
            $result = $statment->fetch(\PDO::FETCH_ASSOC);
            $this->user->setFirstname($result['firstname']);
            $this->user->setLastname($result['lastname']);
            $this->user->setRole($result['role']);
            $this->user->setId($result['id']);
            
            return $this->user;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in updateUser(): ' . $e->getMessage()]);
            die();
        }
    }

    public function getLists(): array
    {
        try {
            $sqlQuery = ("SELECT * FROM list WHERE id_user = :id_user");
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':id_user', $this->user->getId(), \PDO::PARAM_INT);
            $statment->execute();
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            
            return $result;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in getLists(): ' . $e->getMessage()]);
            die();
        }
    }

    public function getTasks(int $idList): array
    {
        try {
            $sqlQuery = ("SELECT * FROM task WHERE id_list = :id_list");
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':id_list', $idList, \PDO::PARAM_INT);
            $statment->execute();
            $result = $statment->fetchAll(\PDO::FETCH_ASSOC);
            
            return $result;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in getTasks(): ' . $e->getMessage()]);
            die();
        }
    }

    public function createList(string $title): array
    {
        try {
            $sqlQuery = "INSERT INTO list (title, id_user) VALUES (:title, :id_user)";
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':title', $title, \PDO::PARAM_STR);
            $statment->bindValue(':id_user', $this->user->getId(), \PDO::PARAM_INT);
            $statment->execute();
            $result = [
                'id' => $this->pdo->lastInsertId(),
                'title' => $title,
                'id_user' => $this->user->getId()
            ];
            
            return $result;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in createList(): ' . $e->getMessage()]);
            die();
        }
    }

    public function isListOwner(int $idList): bool
    {
        try {
            $sqlQuery = ("SELECT COUNT(*)
            FROM list 
            WHERE id_user = :id_user AND id = :id_list"
            );
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':id_user', $this->user->getId(), \PDO::PARAM_INT);
            $statment->bindValue(':id_list', $idList, \PDO::PARAM_INT);
            $statment->execute();
            $result = $statment->fetch(\PDO::FETCH_COLUMN);
            if ($result) {
                return true;
            }
            return false;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in isListOwner(): ' . $e->getMessage()]);
            die();
        }
        $sqlQuery = ("SELECT COUNT(*)
            FROM list 
            WHERE id_user = :id_user AND id = :id_list"
        );
    }

    public function createTask(string $title, int $idList): array
    {
        try {
            $sqlQuery = "INSERT INTO task (title, id_list) VALUES (:title, :id_list)";
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':title', $title, \PDO::PARAM_STR);
            $statment->bindValue(':id_list', $idList, \PDO::PARAM_INT);
            $statment->execute();
            $result = [
                'id' => $this->pdo->lastInsertId(),
                'title' => $title,
                'state' => 'pending',
                'id_list' => $idList
            ];
            
            return $result;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in createTask(): ' . $e->getMessage()]);
            die();
        }
    }

    public function updateTaskState(int $idTask, string $state): void
    {
        try {
            $sqlQuery = "UPDATE task SET state = :state WHERE id = :id_task";
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':state', $state, \PDO::PARAM_INT);
            $statment->bindValue(':id_task', $idTask, \PDO::PARAM_INT);
            $statment->execute();
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in updateTaskState(): ' . $e->getMessage()]);
            die();
        }
    }

    public function isTaskOwner(int $idTask): bool
    {
        try {
            $sqlQuery = ("SELECT COUNT(*)
            FROM task
            INNER JOIN list ON task.id_list = list.id
            WHERE list.id_user = :id_user AND task.id = :id_task"
            );
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':id_user', $this->user->getId(), \PDO::PARAM_INT);
            $statment->bindValue(':id_task', $idTask, \PDO::PARAM_INT);
            $statment->execute();
            $result = $statment->fetch(\PDO::FETCH_COLUMN);
            if ($result) {
                return true;
            }
            return false;
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in isTaskOwner(): ' . $e->getMessage()]);
            die();
        }
        $sqlQuery = ("SELECT COUNT(*)
            FROM task
            INNER JOIN list ON task.id_list = list.id
            WHERE list.id_user = :id_user AND task.id = :id_task"
        );
    }

    public function deleteTask(int $idTask): void
    {
        try {
            $sqlQuery = "DELETE FROM task WHERE id = :id_task";
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':id_task', $idTask, \PDO::PARAM_INT);
            $statment->execute();
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in deleteTask(): ' . $e->getMessage()]);
            die();
        }
    }

    public function deleteList(int $idList): void
    {
        try {
            $sqlQuery = "DELETE FROM list WHERE id = :id_list";
            $statment = $this->pdo->prepare($sqlQuery);
            $statment->bindValue(':id_list', $idList, \PDO::PARAM_INT);
            $statment->execute();
        } catch (\PDOException $e) {
            echo json_encode(['message' => 'Error in deleteList(): ' . $e->getMessage()]);
            die();
        }
    }
}
