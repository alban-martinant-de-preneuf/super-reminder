<?php

namespace App\Model;

class User
{

    private string $email;
    private string $password;
    private ?string $firstname;
    private ?string $lastname;
    private string $role;
    private ?int $id;

    public function __construct(
        string $email = '',
        string $password = '',
        ?string $firstname = null,
        ?string $lastname = null,
        string $role = 'USER',
        ?int $id = null
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->role = $role;
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function setFirstname(?string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname(?string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function setRole(string $role): User
    {
        $this->role = $role;
        return $this;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }
}
