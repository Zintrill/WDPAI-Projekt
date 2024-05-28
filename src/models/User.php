<?php

class User
{
    private $fullname;
    private $username;
    private $password;
    private $permission_id;
    private $email;

    public function __construct(string $fullname, string $username, string $password, int $permission_id, string $email)
    {
        $this->fullname = $fullname;
        $this->username = $username;
        $this->password = $password;
        $this->permission_id = $permission_id;
        $this->email = $email;
    }

    public function getFullName(): string
    {
        return $this->fullname;
    }

    public function setFullName(string $fullname)
    {
        $this->fullname = $fullname;
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

    public function getPermission_id(): int
    {
        return $this->permission_id;
    }

    public function setPermission_id(int $permission_id)
    {
        $this->permission_id = $permission_id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }
}
