<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class UserController extends AppController
{
    public function addUser()
    {
        if ($this->isPost()) {
            $userRepository = new UserRepository();

            $fullName = $_POST['fullName'];
            $username = $_POST['username'];
            $password = $_POST['userPassword'];
            $role = $_POST['userRole'];
            $email = $_POST['email'];

            // Dodanie użytkownika do bazy danych
            $userRepository->addUser($fullName, $username, $password, $role, $email);

            // Przekierowanie z powrotem do listy użytkowników po dodaniu
            header('Location: users');
        }
    }

    public function getUsers()
    {
        header('Content-Type: application/json');
        $userRepository = new UserRepository();
        $users = $userRepository->getAllUsers();

        echo json_encode($users);
    }
}
