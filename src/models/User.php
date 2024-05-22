<?php


class User
{
    private $username;
    private $password;
    private $name;
    private $surname;


    public function __construct( string $username, string $password, string $name, string $surname)
    {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    
}