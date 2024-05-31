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
            echo json_encode(['status' => 'error', 'message' => 'Username is already taken']);
            return;
        }

        if ($userRepository->isEmailTaken($email)) {
            echo json_encode(['status' => 'error', 'message' => 'Email is already taken']);
            return;
        }

        // Dodanie użytkownika do bazy danych
        $userRepository->addUser($fullName, $username, $password, $role, $email);

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
}


public function updateUser()
{
    if ($this->isPost()) {
        $userRepository = new UserRepository();

        $userId = $_POST['userId'];
        $fullName = $_POST['fullName'];
        $username = $_POST['username'];
        $password = $_POST['userPassword'];
        $role = $_POST['userRole'];
        $email = $_POST['email'];

        if ($userRepository->isUsernameTakenByAnother($username, $userId)) {
            echo json_encode(['status' => 'error', 'message' => 'Username is already taken by another user']);
            return;
        }

        if ($userRepository->isEmailTakenByAnother($email, $userId)) {
            echo json_encode(['status' => 'error', 'message' => 'Email is already taken by another user']);
            return;
        }

        // Aktualizacja użytkownika w bazie danych
        $userRepository->updateUser($userId, $fullName, $username, $password, $role, $email);

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
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

    public function getUserById()
    {
        try {
            if ($this->isGET()) {
                $userId = $_GET['id'];
                $userRepository = new UserRepository();
                $user = $userRepository->getUserById($userId);

                // Logowanie danych użytkownika
                error_log(print_r($user, true));

                // Konwertowanie obiektu użytkownika na JSON
                echo json_encode($user);
            }
        } catch (Exception $e) {
            // Zwróć błąd w formacie JSON
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
