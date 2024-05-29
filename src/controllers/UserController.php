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

            if ($userRepository->isUsernameTaken($username)) {
                return $this->render('users', ['messages' => ['Username is already taken']]);
            }

            if ($userRepository->isEmailTaken($email)) {
                return $this->render('users', ['messages' => ['Email is already taken']]);
            }

            // Dodanie użytkownika do bazy danych
            $userRepository->addUser($fullName, $username, $password, $role, $email);

            // Przekierowanie z powrotem do listy użytkowników po dodaniu
            header('Location: users');
        }
    }

    public function checkUsername()
    {
        if ($this->isGET()) {
            header('Content-Type: application/json');
            if (isset($_GET['username'])) {
                $username = $_GET['username'];
                $userRepository = new UserRepository();
                $isTaken = $userRepository->isUsernameTaken($username);
                echo json_encode(['isTaken' => $isTaken]);
            }
        }
    }

    public function checkEmail()
    {
        if ($this->isGET()) {
            header('Content-Type: application/json');
            if (isset($_GET['email'])) {
                $email = $_GET['email'];
                $userRepository = new UserRepository();
                $isTaken = $userRepository->isEmailTaken($email);
                echo json_encode(['isTaken' => $isTaken]);
            }
        }
    }
    public function getUsers()
    {
        header('Content-Type: application/json');
        $userRepository = new UserRepository();
        $users = $userRepository->getAllUsers();

        echo json_encode($users);
    }

    public function deleteUser()
    {
        if ($this->isPost()) {
            if (isset($_POST['userId'])) {
                $userId = $_POST['userId'];

                $userRepository = new UserRepository();
                $userRepository->deleteUser($userId);

                echo json_encode(['status' => 'success']);
                return;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No user ID provided']);
                return;
            }
        }
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
}
