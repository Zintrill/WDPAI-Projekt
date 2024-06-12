<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
            '1' => 1,
            '2' => 2,
            '3' => 3
        ];

        $permissionId = $roleMap[$role] ?? null;

        if ($permissionId === null) {
            throw new Exception('Invalid role');
        }

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
            SELECT u.user_id AS id, u.fullname, u.username, u.password, p.role AS role, u.email
            FROM public.users u
            JOIN public.permissions p ON u.permission_id = p.permission_id
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function deleteUser(int $userId)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM public.users WHERE user_id = :id
        ');
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function isUsernameTaken(string $username): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*) FROM public.users WHERE username = :username
        ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    public function isEmailTaken(string $email): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*) FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updateUser(int $userId, string $fullName, string $username, string $password, string $role, string $email)
    {
        $roleMap = [
            '1' => 1,
            '2' => 2,
            '3' => 3
        ];

        $permissionId = $roleMap[$role];

        $stmt = $this->database->connect()->prepare('
            UPDATE public.users 
            SET fullname = :fullname, username = :username, password = :password, permission_id = :permission_id, email = :email
            WHERE user_id = :id
        ');
        $stmt->bindParam(':fullname', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':permission_id', $permissionId, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function getUserById(int $userId): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.user_id AS id, u.fullname, u.username, u.password, u.permission_id, u.email
            FROM public.users u
            WHERE u.user_id = :id
        ');
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return $user;
    }

    public function isUsernameTakenByAnother(string $username, int $userId): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*) FROM public.users WHERE username = :username AND user_id != :id
        ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function isEmailTakenByAnother(string $email, int $userId): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*) FROM public.users WHERE email = :email AND user_id != :id
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
