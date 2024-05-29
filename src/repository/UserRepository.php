<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $username): ?User
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM public.users WHERE username = :username
        ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['fullname'],
            $user['username'],
            $user['password'],
            $user['permission_id'],
            $user['email']
        );
    }

    public function addUser(string $fullName, string $username, string $password, string $role, string $email)
    {
        $roleMap = [
            'administrator' => 1,
            'technician' => 2,
            'operator' => 3
        ];

        $permissionId = $roleMap[$role];

        $stmt = $this->database->connect()->prepare('
        INSERT INTO public.users (fullname, username, password, permission_id, email)
        VALUES (:fullname, :username, :password, :permission_id, :email)
        ');
        $stmt->bindParam(':fullname', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':permission_id', $permissionId, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT u.fullname, u.username, u.password, p.role as role, u.email
        FROM public.users u
        JOIN public.permissions p ON u.permission_id = p.permission_id
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }
}
