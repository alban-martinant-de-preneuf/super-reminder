<?php

namespace App\Model;

class UserModel extends DbConnection {

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    public function register(): User {
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
    }

    public function isRegisted(): bool {
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
    }

    public function isConnect(): bool {
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']->getEmail() === $this->user->getEmail()) {
                return true;
            }
        }
        return false;
    }

    public function updateUser(): User {
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
    }

    public function getLists(): array {
        $sqlQuery = ("SELECT * FROM list WHERE id_user = :id_user");
        $statment = $this->pdo->prepare($sqlQuery);
        $statment->bindValue(':id_user', $this->user->getId(), \PDO::PARAM_INT);
        $statment->execute();
        $result = $statment->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getTasks(int $idList): array {
        $sqlQuery = ("SELECT * FROM task WHERE id_list = :id_list");
        $statment = $this->pdo->prepare($sqlQuery);
        $statment->bindValue(':id_list', $idList, \PDO::PARAM_INT);
        $statment->execute();
        $result = $statment->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function createList(string $title): void {
        $sqlQuery = "INSERT INTO list (title, id_user) VALUES (:title, :id_user)";
        $statment = $this->pdo->prepare($sqlQuery);
        $statment->bindValue(':title', $title, \PDO::PARAM_STR);
        $statment->bindValue(':id_user', $this->user->getId(), \PDO::PARAM_INT);
        $statment->execute();
    }

    public function isListOwner(int $idList): bool {
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
    }

    public function createTask(string $title, int $idList): void {
        $sqlQuery = "INSERT INTO task (title, id_list) VALUES (:title, :id_list)";
        $statment = $this->pdo->prepare($sqlQuery);
        $statment->bindValue(':title', $title, \PDO::PARAM_STR);
        $statment->bindValue(':id_list', $idList, \PDO::PARAM_INT);
        $statment->execute();
    }
    
}