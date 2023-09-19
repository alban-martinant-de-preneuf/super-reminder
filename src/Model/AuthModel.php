<?php

namespace App\Model;

class AuthModel extends DbConnection {

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
        var_dump($result);
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
}